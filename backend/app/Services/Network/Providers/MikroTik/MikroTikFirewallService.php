<?php

declare(strict_types=1);

namespace App\Services\Network\Providers\MikroTik;

use App\Exceptions\Network\ResourceNotFoundException;
use App\Contracts\Network\Services\FirewallServiceInterface;
use RouterOS\Query;

class MikroTikFirewallService implements FirewallServiceInterface
{
    public function __construct(
        protected MikroTikQueryService $query
    ) {
    }


    /**
     * Get firewall filter rules.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getRules(): array
    {
        return $this->query->execute(
            new Query('/ip/firewall/filter/print')
        );
    }



    /**
     * Find firewall rule by id.
     *
     * @return array<string,mixed>|null
     */
    public function find(
        string $id
    ): ?array {

        $rules = $this->getRules();


        foreach ($rules as $rule) {

            if (($rule['.id'] ?? null) === $id) {

                return $rule;
            }
        }


        return null;
    }



    /**
     * Create firewall rule.
     *
     * @param array<string,mixed> $data
     */
    public function create(
        array $data
    ): bool {

        $query = (new Query('/ip/firewall/filter/add'));


        foreach ($data as $key => $value) {

            $query->equal(
                str_replace('_', '-', $key),
                $value
            );
        }


        return $this->query->write($query);
    }



    /**
     * Update firewall rule.
     *
     * @param array<string,mixed> $data
     */
    public function update(
        string $id,
        array $data
    ): bool {

        $rule = $this->find($id);


        if ($rule === null) {

            throw ResourceNotFoundException::missing(
                'firewall-rule',
                [
                    'id' => $id,
                ]
            );
        }


        $query = (new Query('/ip/firewall/filter/set'))
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
     * Delete firewall rule.
     */
    public function delete(
        string $id
    ): bool {

        $rule = $this->find($id);


        if ($rule === null) {

            throw ResourceNotFoundException::missing(
                'firewall-rule',
                [
                    'id' => $id,
                ]
            );
        }


        $query = (new Query('/ip/firewall/filter/remove'))
            ->equal('.id', $id);


        return $this->query->write($query);
    }



    /**
     * Disable firewall rule.
     */
    public function disable(
        string $id
    ): bool {

        return $this->changeState(
            $id,
            true
        );
    }



    /**
     * Enable firewall rule.
     */
    public function enable(
        string $id
    ): bool {

        return $this->changeState(
            $id,
            false
        );
    }



    /**
     * Change firewall rule state.
     */
    protected function changeState(
        string $id,
        bool $disabled
    ): bool {

        $rule = $this->find($id);


        if ($rule === null) {

            throw ResourceNotFoundException::missing(
                'firewall-rule',
                [
                    'id' => $id,
                ]
            );
        }


        $query = (new Query('/ip/firewall/filter/set'))
            ->equal('.id', $id)
            ->equal(
                'disabled',
                $disabled ? 'yes' : 'no'
            );


        return $this->query->write($query);
    }



    /**
     * Get NAT rules.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getNatRules(): array
    {
        return $this->query->execute(
            new Query('/ip/firewall/nat/print')
        );
    }



    /**
     * Find NAT rule.
     *
     * @return array<string,mixed>|null
     */
    public function findNat(
        string $id
    ): ?array {

        $rules = $this->getNatRules();


        foreach ($rules as $rule) {

            if (($rule['.id'] ?? null) === $id) {

                return $rule;
            }
        }


        return null;
    }

    /**
     * Create NAT rule.
     *
     * @param array<string,mixed> $data
     */
    public function createNat(
        array $data
    ): bool {

        $query = (new Query('/ip/firewall/nat/add'));


        foreach ($data as $key => $value) {

            $query->equal(
                str_replace('_', '-', $key),
                $value
            );
        }


        return $this->query->write($query);
    }



    /**
     * Update NAT rule.
     *
     * @param array<string,mixed> $data
     */
    public function updateNat(
        string $id,
        array $data
    ): bool {

        $rule = $this->findNat($id);


        if ($rule === null) {

            throw ResourceNotFoundException::missing(
                'nat-rule',
                [
                    'id' => $id,
                ]
            );
        }


        $query = (new Query('/ip/firewall/nat/set'))
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
     * Delete NAT rule.
     */
    public function deleteNat(
        string $id
    ): bool {

        $rule = $this->findNat($id);


        if ($rule === null) {

            throw ResourceNotFoundException::missing(
                'nat-rule',
                [
                    'id' => $id,
                ]
            );
        }


        $query = (new Query('/ip/firewall/nat/remove'))
            ->equal('.id', $id);


        return $this->query->write($query);
    }



    /**
     * Search firewall rules.
     *
     * @return array<int,array<string,mixed>>
     */
    public function search(
        string $keyword
    ): array {

        $rules = $this->getRules();


        return array_values(
            array_filter(
                $rules,
                function (array $rule) use ($keyword) {

                    $comment = $rule['comment'] ?? '';

                    return str_contains(
                        strtolower((string) $comment),
                        strtolower($keyword)
                    );
                }
            )
        );
    }



    /**
     * Get firewall statistics.
     *
     * @return array<string,int>
     */
    public function statistics(): array
    {
        return [
            'filter_rules' =>
            count($this->getRules()),

            'nat_rules' =>
            count($this->getNatRules()),
        ];
    }
}
