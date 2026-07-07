<?php

namespace App\Services\Network;

use App\Contracts\MikrotikServiceInterface;
use App\Models\NetworkDevice;
use RouterOS\Client;
use RouterOS\Query;
use Illuminate\Support\Facades\Log;

class MikroTikService implements MikrotikServiceInterface
{
    protected $client;
    protected $device;

    /**
     * الاتصال بجهاز MikroTik
     */
    public function connect(string $ip, string $username, string $password, int $port = 8728): bool
    {
        try {
            $this->client = new Client([
                'host' => $ip,
                'user' => $username,
                'pass' => $password,
                'port' => $port,
            ]);

            // اختبار الاتصال
            $query = new Query('/system/resource/print');
            $this->client->query($query)->read();

            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Connection Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * إنشاء مستخدم PPPoE جديد
     */
    public function createUser(string $username, string $password, string $profile, array $options = []): bool
    {
        try {
            $query = (new Query('/ppp/secret/add'))
                ->equal('name', $username)
                ->equal('password', $password)
                ->equal('profile', $profile)
                ->equal('service', 'pppoe');

            if (isset($options['comment'])) {
                $query->equal('comment', $options['comment']);
            }

            if (isset($options['disabled']) && $options['disabled']) {
                $query->equal('disabled', 'yes');
            }

            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Create User Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * تعطيل مستخدم
     */
    public function disableUser(string $username): bool
    {
        try {
            $query = (new Query('/ppp/secret/set'))
                ->equal('.id', $username)
                ->equal('disabled', 'yes');

            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Disable User Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * تفعيل مستخدم
     */
    public function enableUser(string $username): bool
    {
        try {
            $query = (new Query('/ppp/secret/set'))
                ->equal('.id', $username)
                ->equal('disabled', 'no');

            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Enable User Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * حذف مستخدم
     */
    public function deleteUser(string $username): bool
    {
        try {
            $query = (new Query('/ppp/secret/remove'))
                ->equal('.id', $username);

            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Delete User Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * جلب جميع مستخدمي PPPoE من MikroTik
     */
    public function getAllUsers(): array
    {
        try {
            $query = (new Query('/ppp/secret/print'));
            $response = $this->client->query($query)->read();

            $users = [];
            foreach ($response as $item) {
                $users[] = [
                    'name' => $item['name'] ?? null,
                    'password' => $item['password'] ?? null,
                    'profile' => $item['profile'] ?? null,
                    'disabled' => isset($item['disabled']) && $item['disabled'] === 'true',
                    'comment' => $item['comment'] ?? null,
                ];
            }

            return $users;
        } catch (\Exception $e) {
            Log::error("MikroTik Get Users Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * جلب الجلسات النشطة
     */
    public function getActiveSessions(): array
    {
        try {
            $query = (new Query('/ppp/active/print'));
            $response = $this->client->query($query)->read();

            $sessions = [];
            foreach ($response as $item) {
                $sessions[] = [
                    'name' => $item['name'] ?? null,
                    'address' => $item['address'] ?? null,
                    'uptime' => $item['uptime'] ?? null,
                    'bytes_in' => $item['bytes-in'] ?? 0,
                    'bytes_out' => $item['bytes-out'] ?? 0,
                ];
            }

            return $sessions;
        } catch (\Exception $e) {
            Log::error("MikroTik Get Sessions Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * تحديث حدود السرعة (Queue)
     */
    public function updateUserQueue(string $username, int $download, int $upload): bool
    {
        try {
            $query = (new Query('/queue/simple/set'))
                ->equal('.id', $username)
                ->equal('max-limit', "{$upload}M/{$download}M");

            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Update Queue Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * الحصول على إحصائيات الجهاز
     */
    public function getDeviceStats(): array
    {
        try {
            $cpuQuery = (new Query('/system/resource/print'));
            $cpuResponse = $this->client->query($cpuQuery)->read();

            $interfaceQuery = (new Query('/interface/print'));
            $interfaceResponse = $this->client->query($interfaceQuery)->read();

            return [
                'cpu_load' => $cpuResponse[0]['cpu-load'] ?? 0,
                'uptime' => $cpuResponse[0]['uptime'] ?? '0s',
                'free_memory' => $cpuResponse[0]['free-memory'] ?? 0,
                'total_memory' => $cpuResponse[0]['total-memory'] ?? 0,
                'interfaces' => $interfaceResponse,
            ];
        } catch (\Exception $e) {
            Log::error("MikroTik Get Stats Error: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Ping للجهاز
     */
    public function ping(string $ip): bool
    {
        try {
            $query = (new Query('/ping'))
                ->equal('address', $ip)
                ->equal('count', 1);

            $response = $this->client->query($query)->read();

            return isset($response[0]['time']) && $response[0]['time'] > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * فصل مستخدم عن الجلسة النشطة
     */
    public function disconnectUser(string $username): bool
    {
        try {
            $query = (new Query('/ppp/active/remove'))
                ->equal('.id', $username);

            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Disconnect User Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * تحديث حالة الجهاز في قاعدة البيانات
     */
    public function updateDeviceStatus(NetworkDevice $device): void
    {
        try {
            $isOnline = $this->ping($device->ip_address);

            $device->update([
                'is_online' => $isOnline,
                'last_ping_at' => now(),
                'status' => $isOnline ? 'active' : 'inactive',
            ]);

            Log::info("MikroTik Device {$device->name} is " . ($isOnline ? 'online' : 'offline'));
        } catch (\Exception $e) {
            Log::error("MikroTik Update Device Status Error: " . $e->getMessage());
        }
    }

    // ========== دوال Hotspot ==========

    /**
     * جلب جميع مستخدمي Hotspot من MikroTik
     */
    public function getHotspotUsers(): array
    {
        try {
            $query = (new Query('/ip/hotspot/user/print'));
            $response = $this->client->query($query)->read();

            $users = [];
            foreach ($response as $item) {
                $users[] = [
                    'name' => $item['name'] ?? null,
                    'password' => $item['password'] ?? null,
                    'profile' => $item['profile'] ?? null,
                    'disabled' => isset($item['disabled']) && $item['disabled'] === 'true',
                    'comment' => $item['comment'] ?? null,
                ];
            }

            return $users;
        } catch (\Exception $e) {
            Log::error("MikroTik Get Hotspot Users Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * جلب الجلسات النشطة لـ Hotspot
     */
    public function getHotspotActiveSessions(): array
    {
        try {
            $query = (new Query('/ip/hotspot/active/print'));
            $response = $this->client->query($query)->read();

            $sessions = [];
            foreach ($response as $item) {
                $sessions[] = [
                    'name' => $item['user'] ?? null,     // اسم المستخدم
                    'address' => $item['address'] ?? null,
                    'uptime' => $item['uptime'] ?? 0,
                    'bytes_in' => $item['bytes-in'] ?? 0,
                    'bytes_out' => $item['bytes-out'] ?? 0,
                    'idle_time' => $item['idle-time'] ?? 0,
                    'server' => $item['server'] ?? null,
                ];
            }

            return $sessions;
        } catch (\Exception $e) {
            Log::error("MikroTik Get Hotspot Sessions Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * إنشاء مستخدم Hotspot جديد
     */
    public function createHotspotUser(string $username, string $password, string $profile, array $options = []): bool
    {
        try {
            $query = (new Query('/ip/hotspot/user/add'))
                ->equal('name', $username)
                ->equal('password', $password)
                ->equal('profile', $profile);

            if (isset($options['expiry_date'])) {
                $query->equal('expiry-date', $options['expiry_date']);
            }

            if (isset($options['comment'])) {
                $query->equal('comment', $options['comment']);
            }

            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Create Hotspot User Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * تعطيل مستخدم Hotspot
     */
    public function disableHotspotUser(string $username): bool
    {
        try {
            $query = (new Query('/ip/hotspot/user/set'))
                ->equal('.id', $username)
                ->equal('disabled', 'yes');

            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Disable Hotspot User Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * تفعيل مستخدم Hotspot
     */
    public function enableHotspotUser(string $username): bool
    {
        try {
            $query = (new Query('/ip/hotspot/user/set'))
                ->equal('.id', $username)
                ->equal('disabled', 'no');

            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Enable Hotspot User Error: " . $e->getMessage());
            return false;
        }
    }
}
