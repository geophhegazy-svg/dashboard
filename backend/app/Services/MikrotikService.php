<?php

namespace App\Services;

use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Query;

class MikrotikService
{
    protected function client()
{
    return new Client(
        new Config([
            'host' => env('MIKROTIK_HOST'),
            'user' => env('MIKROTIK_USER'),
            'pass' => env('MIKROTIK_PASSWORD'),
            'port' => (int) env('MIKROTIK_PORT', 8728),
        ])
    );
}
    public function disablePppoe($username)
    {
        $client = $this->client();
        $find = (new Query('/ppp/secret/print'))->where('name', $username);
        $user = $client->query($find)->read();
        if (!count($user)) {
            return false;
        }
        $disable = (new Query('/ppp/secret/set'))->equal('.id', $user[0]['.id'])->equal('disabled', 'yes');
        $client->query($disable)->read();
        return true;
    }
    public function enablePppoe($username)
    {
        $client = $this->client();
        $find = (new Query('/ppp/secret/print'))->where('name', $username);
        $user = $client->query($find)->read();
        if (!count($user)) {
            return false;
        }
        $enable = (new Query('/ppp/secret/set'))->equal('.id', $user[0]['.id'])->equal('disabled', 'no');
        $client->query($enable)->read();
        return true;
    }
    public function disableHotspot($username)
    {
        $client = $this->client();
        $find = (new Query('/ip/hotspot/user/print'))->where('name', $username);
        $user = $client->query($find)->read();
        if (!count($user)) {
            return false;
        }
        $disable = (new Query('/ip/hotspot/user/set'))->equal('.id', $user[0]['.id'])->equal('disabled', 'yes');
        $client->query($disable)->read();
        return true;
    }
    public function enableHotspot($username)
    {
        $client = $this->client();
        $find = (new Query('/ip/hotspot/user/print'))->where('name', $username);
        $user = $client->query($find)->read();
        if (!count($user)) {
            return false;
        }
        $enable = (new Query('/ip/hotspot/user/set'))->equal('.id', $user[0]['.id'])->equal('disabled', 'no');
        $client->query($enable)->read();
        return true;
    }
    public function getPppoeUsers()
    {
        return $this->client()
            ->query(new Query('/ppp/secret/print'))
            ->read();
    }

    public function getHotspotUsers()
    {
        return $this->client()
            ->query(new Query('/ip/hotspot/user/print'))
            ->read();
    }

    public function getActiveHotspotUsers()
    {
        return $this->client()
            ->query(new Query('/ip/hotspot/active/print'))
            ->read();
    }

    public function createPppoe(
        string $username,
        string $password,
        string $profile = 'default'
    ) {
        $query = (new Query('/ppp/secret/add'))
            ->equal('name', $username)
            ->equal('password', $password)
            ->equal('service', 'pppoe')
            ->equal('profile', $profile);

        return $this->client()
            ->query($query)
            ->read();
    }

    public function createHotspot(
        string $username,
        string $password,
        string $profile = 'default'
    ) {
        $query = (new Query('/ip/hotspot/user/add'))
            ->equal('name', $username)
            ->equal('password', $password)
            ->equal('profile', $profile);

        return $this->client()
            ->query($query)
            ->read();
    }

    public function findPppoe(string $username)
    {
        $result = $this->client()
            ->query(
                (new Query('/ppp/secret/print'))
                    ->where('name', $username)
            )
            ->read();

        return count($result)
            ? $result[0]
            : null;
    }

    public function findHotspot(string $username)
    {
        $result = $this->client()
            ->query(
                (new Query('/ip/hotspot/user/print'))
                    ->where('name', $username)
            )
            ->read();

        return count($result)
            ? $result[0]
            : null;
    }
}
