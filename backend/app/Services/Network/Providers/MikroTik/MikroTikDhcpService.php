<?php

declare(strict_types=1);

namespace App\Services\Network\Providers\MikroTik;

use App\Exceptions\Network\ResourceNotFoundException;
use App\Contracts\Network\Services\DhcpServiceInterface;
use RouterOS\Query;

class MikroTikDhcpService implements DhcpServiceInterface
{
    public function __construct(
        protected MikroTikQueryService $query
    ) {
    }


    /**
     * Get all DHCP leases.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getAll(): array
    {
        return $this->query->execute(
            new Query('/ip/dhcp-server/lease/print')
        );
    }



    /**
     * Find DHCP lease by id.
     *
     * @return array<string,mixed>|null
     */
    public function find(
        string $id
    ): ?array {

        $leases = $this->getAll();


        foreach ($leases as $lease) {

            if (($lease['.id'] ?? null) === $id) {

                return $lease;
            }
        }


        return null;
    }



    /**
     * Find lease by MAC address.
     *
     * @return array<string,mixed>|null
     */
    public function findByMac(
        string $mac
    ): ?array {

        $leases = $this->getAll();


        foreach ($leases as $lease) {

            if (
                isset($lease['mac-address'])
                &&
                strtolower($lease['mac-address'])
                === strtolower($mac)
            ) {

                return $lease;
            }
        }


        return null;
    }



    /**
     * Add static DHCP lease.
     */
    public function create(
        string $address,
        string $macAddress,
        ?string $hostname = null,
        array $options = []
    ): bool {

        $query = (new Query('/ip/dhcp-server/lease/add'))
            ->equal('address', $address)
            ->equal('mac-address', $macAddress);



        if ($hostname !== null) {

            $query->equal(
                'host-name',
                $hostname
            );
        }



        if (isset($options['comment'])) {

            $query->equal(
                'comment',
                $options['comment']
            );
        }



        if (isset($options['server'])) {

            $query->equal(
                'server',
                $options['server']
            );
        }


        return $this->query->write($query);
    }

    /**
     * Update DHCP lease.
     *
     * @param array<string,mixed> $data
     */
    public function update(
        string $id,
        array $data
    ): bool {

        $lease = $this->find($id);


        if ($lease === null) {

            throw ResourceNotFoundException::missing(
                'dhcp-lease',
                [
                    'id' => $id,
                ]
            );
        }


        $query = (new Query('/ip/dhcp-server/lease/set'))
            ->equal('.id', $id);


        foreach ($data as $key => $value) {

            $query->equal(
                str_replace('_', '-', $key),
                $value
            );
        }


        return $this->query->write($query);
    }



    /**
     * Delete DHCP lease.
     */
    public function delete(
        string $id
    ): bool {

        $lease = $this->find($id);


        if ($lease === null) {

            throw ResourceNotFoundException::missing(
                'dhcp-lease',
                [
                    'id' => $id,
                ]
            );
        }


        $query = (new Query('/ip/dhcp-server/lease/remove'))
            ->equal('.id', $id);


        return $this->query->write($query);
    }



    /**
     * Make lease static.
     */
    public function makeStatic(
        string $id
    ): bool {

        $lease = $this->find($id);


        if ($lease === null) {

            throw ResourceNotFoundException::missing(
                'dhcp-lease',
                [
                    'id' => $id,
                ]
            );
        }


        $query = (new Query('/ip/dhcp-server/lease/make-static'))
            ->equal('.id', $id);


        return $this->query->write($query);
    }



    /**
     * Remove static binding.
     */
    public function removeStatic(
        string $id
    ): bool {

        $lease = $this->find($id);


        if ($lease === null) {

            throw ResourceNotFoundException::missing(
                'dhcp-lease',
                [
                    'id' => $id,
                ]
            );
        }


        $query = (new Query('/ip/dhcp-server/lease/remove-static'))
            ->equal('.id', $id);


        return $this->query->write($query);
    }

    /**
     * Search DHCP leases.
     *
     * @return array<int,array<string,mixed>>
     */
    public function search(
        string $keyword
    ): array {

        $leases = $this->getAll();


        return array_values(
            array_filter(
                $leases,
                function (array $lease) use ($keyword) {

                    $address = $lease['address'] ?? '';
                    $mac = $lease['mac-address'] ?? '';
                    $host = $lease['host-name'] ?? '';
                    $comment = $lease['comment'] ?? '';


                    $text = strtolower(
                        implode(
                            ' ',
                            [
                                $address,
                                $mac,
                                $host,
                                $comment,
                            ]
                        )
                    );


                    return str_contains(
                        $text,
                        strtolower($keyword)
                    );
                }
            )
        );
    }



    /**
     * Get DHCP statistics.
     *
     * @return array<string,int>
     */
    public function statistics(): array
    {
        $leases = $this->getAll();


        $dynamic = 0;
        $static = 0;
        $bound = 0;


        foreach ($leases as $lease) {

            if (
                ($lease['dynamic'] ?? 'false')
                === 'true'
            ) {
                $dynamic++;
            } else {
                $static++;
            }


            if (
                ($lease['status'] ?? null)
                === 'bound'
            ) {
                $bound++;
            }
        }


        return [
            'total' => count($leases),
            'static' => $static,
            'dynamic' => $dynamic,
            'bound' => $bound,
        ];
    }



    /**
     * Get active DHCP clients.
     *
     * @return array<int,array<string,mixed>>
     */
    public function activeClients(): array
    {
        return array_values(
            array_filter(
                $this->getAll(),
                function (array $lease) {

                    return ($lease['status'] ?? null)
                        === 'bound';
                }
            )
        );
    }
}
