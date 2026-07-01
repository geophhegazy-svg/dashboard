<?php

declare(strict_types=1);

namespace App\Services\Network;

use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Query;

class MikrotikService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(
            new Config([
                'host' => env('MIKROTIK_HOST'),
                'user' => env('MIKROTIK_USER'),
                'pass' => env('MIKROTIK_PASSWORD'),
                'port' => (int) env('MIKROTIK_PORT', 8728),
            ])
        );
    }

    protected function client(): Client
    {
        return $this->client;
    }

    /*
    |--------------------------------------------------------------------------
    | Core Execution
    |--------------------------------------------------------------------------
    */

    protected function cleanString($value)
    {
        if (!is_string($value)) {
            return $value;
        }

        if (mb_check_encoding($value, 'UTF-8')) {
            return $value;
        }

        $encodings = [
            'Windows-1256',
            'ISO-8859-6',
            'CP1252',
            'ISO-8859-1'
        ];

        foreach ($encodings as $encoding) {
            try {
                $converted = @mb_convert_encoding(
                    $value,
                    'UTF-8',
                    $encoding
                );

                if (
                    $converted !== false &&
                    mb_check_encoding($converted, 'UTF-8')
                ) {
                    return $converted;
                }
            } catch (\Throwable $e) {
                continue;
            }
        }

        return @iconv('UTF-8', 'UTF-8//IGNORE', $value) ?: '';
    }

    protected function cleanArray(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->cleanArray($value);
            } elseif (is_string($value)) {
                $data[$key] = $this->cleanString($value);
            }
        }

        return $data;
    }

    protected function execute(Query $query): array
    {
        $result = $this->client()
            ->query($query)
            ->read();

        return $this->cleanArray($result);
    }

    /*
    |--------------------------------------------------------------------------
    | Generic Update Helpers (NEW)
    |--------------------------------------------------------------------------
    */

    private function updatePppoeUser(string $username, array $attributes): bool
    {
        $user = $this->findPppoe($username);

        if (!$user || !isset($user['.id'])) {
            return false;
        }

        $query = (new Query('/ppp/secret/set'))
            ->equal('.id', $user['.id']);

        foreach ($attributes as $key => $value) {
            $query->equal($key, $value);
        }

        $this->execute($query);

        return true;
    }

    private function updateHotspotUser(string $username, array $attributes): bool
    {
        $user = $this->findHotspot($username);

        if (!$user || !isset($user['.id'])) {
            return false;
        }

        $query = (new Query('/ip/hotspot/user/set'))
            ->equal('.id', $user['.id']);

        foreach ($attributes as $key => $value) {
            $query->equal($key, $value);
        }

        $this->execute($query);

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | PPPoE
    |--------------------------------------------------------------------------
    */

    public function getPppoeUsers(): array
    {
        return $this->execute(new Query('/ppp/secret/print'));
    }

    public function createPppoe(string $username, string $password, string $profile = 'default')
    {
        return $this->execute(
            (new Query('/ppp/secret/add'))
                ->equal('name', $username)
                ->equal('password', $password)
                ->equal('service', 'pppoe')
                ->equal('profile', $profile)
        );
    }

    public function findPppoe(string $username)
    {
        $result = $this->execute(
            (new Query('/ppp/secret/print'))
                ->where('name', $username)
        );

        return count($result) ? $result[0] : null;
    }

    public function deletePppoe(string $username): bool
    {
        $user = $this->findPppoe($username);

        if (!$user || !isset($user['.id'])) {
            return false;
        }

        $this->execute(
            (new Query('/ppp/secret/remove'))
                ->equal('.id', $user['.id'])
        );

        return true;
    }

    public function enablePppoe(string $username): bool
    {
        return $this->updatePppoeUser($username, [
            'disabled' => 'no',
        ]);
    }

    public function disablePppoe(string $username): bool
    {
        return $this->updatePppoeUser($username, [
            'disabled' => 'yes',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Hotspot
    |--------------------------------------------------------------------------
    */

    public function getHotspotUsers(): array
    {
        return $this->execute(new Query('/ip/hotspot/user/print'));
    }

    public function getActiveHotspotUsers(): array
    {
        return $this->execute(new Query('/ip/hotspot/active/print'));
    }

    public function createHotspot(string $username, string $password, string $profile = 'default')
    {
        return $this->execute(
            (new Query('/ip/hotspot/user/add'))
                ->equal('name', $username)
                ->equal('password', $password)
                ->equal('profile', $profile)
        );
    }

    public function findHotspot(string $username)
    {
        $result = $this->execute(
            (new Query('/ip/hotspot/user/print'))
                ->where('name', $username)
        );

        return count($result) ? $result[0] : null;
    }

    public function deleteHotspot(string $username): bool
    {
        $user = $this->findHotspot($username);

        if (!$user || !isset($user['.id'])) {
            return false;
        }

        $this->execute(
            (new Query('/ip/hotspot/user/remove'))
                ->equal('.id', $user['.id'])
        );

        return true;
    }

    public function enableHotspot(string $username): bool
    {
        return $this->updateHotspotUser($username, [
            'disabled' => 'no',
        ]);
    }

    public function disableHotspot(string $username): bool
    {
        return $this->updateHotspotUser($username, [
            'disabled' => 'yes',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DHCP
    |--------------------------------------------------------------------------
    */

    public function getDhcpLeases(): array
    {
        $leases = $this->execute(new Query('/ip/dhcp-server/lease/print'));

        return collect($leases)->map(function ($lease) {
            return [
                'id'        => $lease['.id'] ?? null,
                'address'   => $lease['address'] ?? null,
                'mac'       => $lease['mac-address'] ?? null,
                'comment'   => $lease['comment'] ?? '',
                'status'    => $lease['status'] ?? '',
                'host_name' => $lease['host-name'] ?? '',
                'last_seen' => $lease['last-seen'] ?? '',
            ];
        })->values()->all();
    }

    /*
    |--------------------------------------------------------------------------
    | Generic
    |--------------------------------------------------------------------------
    */

    public function run(Query $query): array
    {
        return $this->execute($query);
    }

    public function raw(string $command): array
    {
        return $this->execute(new Query($command));
    }
}
