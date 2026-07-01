<?php

declare(strict_types=1);

namespace App\Services\Network;

use App\Contracts\MikrotikServiceInterface;
use RouterOS\Query;

class MikrotikService extends BaseMikrotikService implements MikrotikServiceInterface
{
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
