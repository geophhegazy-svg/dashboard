<?php

namespace App\Services;

use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Query;
use Exception;

class MikrotikService
{
    private ?Client $client = null;

    /**
     * Initialize Mikrotik Connection
     */
    public function __construct()
    {
        $config = new Config([
            'host' => config('services.mikrotik.host'),
            'user' => config('services.mikrotik.user'),
            'pass' => config('services.mikrotik.pass'),
            'port' => config('services.mikrotik.port'),
        ]);

        $this->client = new Client($config);
    }

    /**
     * Get the client instance
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    // ==================== PPPoE Methods ====================

    /**
     * Get all PPPoE secrets
     */
    public function getPppoeUsers(): array
    {
        return $this->client->query(new Query('/ppp/secret/print'))->read();
    }

    /**
     * Create PPPoE user
     */
    public function createPppoeUser(string $username, string $password, string $profile, string $service = 'pppoe'): void
    {
        $query = (new Query('/ppp/secret/add'))
            ->equal('name', $username)
            ->equal('password', $password)
            ->equal('service', $service)
            ->equal('profile', $profile);

        $this->client->query($query)->read();
    }

    /**
     * Find PPPoE user by username
     */
    public function findPppoeUser(string $username): ?array
    {
        $result = $this->client
            ->query((new Query('/ppp/secret/print'))->where('name', $username))
            ->read();

        return count($result) > 0 ? $result[0] : null;
    }

    /**
     * Enable/Disable PPPoE user
     */
    public function setPppoeUserStatus(string $username, bool $enabled): void
    {
        $user = $this->findPppoeUser($username);

        if (!$user) {
            throw new Exception("PPPoE user '{$username}' not found on Mikrotik");
        }

        $query = (new Query('/ppp/secret/set'))
            ->equal('.id', $user['.id'])
            ->equal('disabled', $enabled ? 'no' : 'yes');

        $this->client->query($query)->read();
    }

    // ==================== Hotspot Methods ====================

    /**
     * Get all Hotspot users
     */
    public function getHotspotUsers(): array
    {
        $response = $this->client->query(new Query('/ip/hotspot/user/print'))->read();

        return json_decode(json_encode($response, JSON_INVALID_UTF8_IGNORE), true);
    }

    /**
     * Create Hotspot user
     */
    public function createHotspotUser(string $username, string $password, string $profile = 'default'): void
    {
        $query = (new Query('/ip/hotspot/user/add'))
            ->equal('name', $username)
            ->equal('password', $password)
            ->equal('profile', $profile);

        $this->client->query($query)->read();
    }

    /**
     * Find Hotspot user by username
     */
    public function findHotspotUser(string $username): ?array
    {
        $result = $this->client
            ->query((new Query('/ip/hotspot/user/print'))->where('name', $username))
            ->read();

        return count($result) > 0 ? $result[0] : null;
    }

    /**
     * Get Hotspot user ID
     */
    public function getHotspotUserId(string $username): string
    {
        $user = $this->findHotspotUser($username);

        if (!$user) {
            throw new Exception("Hotspot user '{$username}' not found");
        }

        return $user['.id'];
    }

    /**
     * Enable/Disable Hotspot user
     */
    public function setHotspotUserStatus(string $username, bool $enabled): void
    {
        $userId = $this->getHotspotUserId($username);

        $query = (new Query('/ip/hotspot/user/set'))
            ->equal('.id', $userId)
            ->equal('disabled', $enabled ? 'no' : 'yes');

        $this->client->query($query)->read();
    }

    /**
     * Delete Hotspot user
     */
    public function deleteHotspotUser(string $username): void
    {
        $userId = $this->getHotspotUserId($username);

        $query = (new Query('/ip/hotspot/user/remove'))
            ->equal('.id', $userId);

        $this->client->query($query)->read();
    }

    /**
     * Get active Hotspot users
     */
    public function getActiveHotspotUsers(): array
    {
        $response = $this->client->query(new Query('/ip/hotspot/active/print'))->read();

        return json_decode(json_encode($response, JSON_INVALID_UTF8_IGNORE), true);
    }
}
