<?php

namespace App\Services\Network;

use RouterOS\Client;
use RouterOS\Query;
use Illuminate\Support\Facades\Log;

class MikroTikAdvancedService
{
    protected $client;

    /**
     * تحويل النص إلى UTF-8 مع دعم اللغة العربية
     */
    protected function convertToUtf8($text)
    {
        if ($text === null || $text === '') {
            return $text;
        }

        // استخدام iconv للتحويل
        $converted = @iconv('Windows-1256', 'UTF-8//IGNORE//TRANSLIT', $text);
        if ($converted !== false && $converted !== '') {
            return $converted;
        }

        // محاولة مع ISO-8859-6
        $converted = @iconv('ISO-8859-6', 'UTF-8//IGNORE//TRANSLIT', $text);
        if ($converted !== false && $converted !== '') {
            return $converted;
        }

        // استخدام mb_convert_encoding مع تحويل الأخطاء
        return mb_convert_encoding($text, 'UTF-8', 'auto');
    }

    /**
     * تنظيف مصفوفة من النصوص وتحويلها إلى UTF-8
     */
    protected function cleanArrayUtf8($array)
    {
        if (!is_array($array)) {
            return $this->convertToUtf8($array);
        }

        $cleaned = [];
        foreach ($array as $key => $value) {
            $cleaned[$key] = is_array($value)
                ? $this->cleanArrayUtf8($value)
                : $this->convertToUtf8($value);
        }
        return $cleaned;
    }

    public function connect(string $ip, string $username, string $password, int $port = 8728): bool
    {
        try {
            $this->client = new Client([
                'host' => $ip,
                'user' => $username,
                'pass' => $password,
                'port' => $port,
            ]);

            $query = new Query('/system/resource/print');
            $this->client->query($query)->read();

            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Advanced Connection Error: " . $e->getMessage());
            return false;
        }
    }

    // ========== إدارة الـ Queues ==========

    /**
     * جلب جميع قوائم الانتظار (Simple Queues)
     */
    public function getSimpleQueues(): array
    {
        try {
            $query = (new Query('/queue/simple/print'));
            $response = $this->client->query($query)->read();

            $queues = [];
            foreach ($response as $item) {
                $queues[] = [
                    'id' => $item['.id'] ?? null,
                    'name' => $item['name'] ?? null,
                    'target' => $item['target'] ?? null,
                    'max_limit' => $item['max-limit'] ?? null,
                    'limit_at' => $item['limit-at'] ?? null,
                    'priority' => $item['priority'] ?? 1,
                    'queue_type' => $item['queue'] ?? 'default',
                    'bytes_in' => $item['bytes-in'] ?? 0,
                    'bytes_out' => $item['bytes-out'] ?? 0,
                    'total_bytes' => ($item['bytes-in'] ?? 0) + ($item['bytes-out'] ?? 0),
                    'comment' => $this->convertToUtf8($item['comment'] ?? null),  // 🔥 تحويل التعليق
                ];
            }

            return $queues;
        } catch (\Exception $e) {
            Log::error("MikroTik Get Queues Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * إنشاء Queue جديدة
     */
    public function createSimpleQueue(string $name, string $target, string $maxLimit, string $limitAt = null, int $priority = 1): bool
    {
        try {
            $query = (new Query('/queue/simple/add'))
                ->equal('name', $name)
                ->equal('target', $target)
                ->equal('max-limit', $maxLimit)
                ->equal('priority', $priority);

            if ($limitAt) {
                $query->equal('limit-at', $limitAt);
            }

            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Create Queue Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * تحديث Queue
     */
    public function updateSimpleQueue(string $id, array $data): bool
    {
        try {
            $query = (new Query('/queue/simple/set'))
                ->equal('.id', $name);

            if (isset($data['max_limit'])) {
                $query->equal('max-limit', $data['max_limit']);
            }

            if (isset($data['limit_at'])) {
                $query->equal('limit-at', $data['limit_at']);
            }

            if (isset($data['priority'])) {
                $query->equal('priority', $data['priority']);
            }

            if (isset($data['comment'])) {
                $query->equal('comment', $data['comment']);
            }

            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Update Queue Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * حذف Queue
     */
    public function deleteSimpleQueue(string $name): bool
    {
        try {
            $query = (new Query('/queue/simple/remove'))
                ->equal('.id', $name);

            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Delete Queue Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * تعطيل Queue
     */
    public function disableSimpleQueue(string $name): bool
    {
        try {
            $query = (new Query('/queue/simple/disable'))
                ->equal('.id', $name);

            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Disable Queue Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * تفعيل Queue
     */
    public function enableSimpleQueue(string $name): bool
    {
        try {
            $query = (new Query('/queue/simple/enable'))
                ->equal('.id', $name);

            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Enable Queue Error: " . $e->getMessage());
            return false;
        }
    }

    // ========== إدارة الـ Firewall ==========

    /**
     * جلب قواعد الـ Firewall
     */
    public function getFirewallRules(): array
    {
        try {
            $query = (new Query('/ip/firewall/filter/print'));
            $response = $this->client->query($query)->read();

            $rules = [];
            foreach ($response as $item) {
                $rules[] = [
                    'id' => $item['.id'] ?? null,
                    'chain' => $item['chain'] ?? null,
                    'action' => $item['action'] ?? null,
                    'src_address' => $item['src-address'] ?? null,
                    'dst_address' => $item['dst-address'] ?? null,
                    'protocol' => $item['protocol'] ?? null,
                    'port' => $item['dst-port'] ?? null,
                    'comment' => $this->convertToUtf8($item['comment'] ?? null),  // 🔥 تحويل التعليق
                    'disabled' => isset($item['disabled']) && $item['disabled'] === 'true',
                ];
            }

            return $rules;
        } catch (\Exception $e) {
            Log::error("MikroTik Get Firewall Rules Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * إنشاء قاعدة Firewall جديدة
     */
    public function createFirewallRule(array $data): bool
    {
        try {
            $query = (new Query('/ip/firewall/filter/add'))
                ->equal('chain', $data['chain'])
                ->equal('action', $data['action']);

            if (isset($data['src_address'])) {
                $query->equal('src-address', $data['src_address']);
            }

            if (isset($data['dst_address'])) {
                $query->equal('dst-address', $data['dst_address']);
            }

            if (isset($data['protocol'])) {
                $query->equal('protocol', $data['protocol']);
            }

            if (isset($data['dst_port'])) {
                $query->equal('dst-port', $data['dst_port']);
            }

            if (isset($data['comment'])) {
                $query->equal('comment', $data['comment']);
            }

            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Create Firewall Rule Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * حذف قاعدة Firewall
     */
    public function deleteFirewallRule(string $id): bool
    {
        try {
            $query = (new Query('/ip/firewall/filter/remove'))
                ->equal('.id', $id);

            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Delete Firewall Rule Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * تحديث عقد DHCP
     */
    public function updateDHCPLease(string $id, array $data): bool
    {
        try {
            $query = (new Query('/ip/dhcp-server/lease/set'))
                ->equal('.id', $id);

            if (isset($data['address'])) {
                $query->equal('address', $data['address']);
            }

            if (isset($data['mac_address'])) {
                $query->equal('mac-address', $data['mac_address']);
            }

            if (isset($data['hostname'])) {
                $query->equal('host-name', $data['hostname']);
            }

            if (isset($data['comment'])) {
                $query->equal('comment', $data['comment']);
            }

            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Update DHCP Lease Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * تحديث قاعدة Firewall
     */
    public function updateFirewallRule(string $id, array $data): bool
    {
        try {
            $query = (new Query('/ip/firewall/filter/set'))->equal('.id', $id);
            foreach ($data as $key => $value) {
                $mikroKey = str_replace('_', '-', $key);
                if ($key === 'src_address') $mikroKey = 'src-address';
                if ($key === 'dst_address') $mikroKey = 'dst-address';
                if ($key === 'dst_port') $mikroKey = 'dst-port';
                $query->equal($mikroKey, $value);
            }
            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Update Firewall Rule Error: " . $e->getMessage());
            return false;
        }
    }

    // ========== إدارة الـ NAT ==========

    /**
     * جلب قواعد الـ NAT
     */
    public function getNATRules(): array
    {
        try {
            $query = (new Query('/ip/firewall/nat/print'));
            $response = $this->client->query($query)->read();

            $rules = [];
            foreach ($response as $item) {
                $rules[] = [
                    'id' => $item['.id'] ?? null,
                    'chain' => $item['chain'] ?? null,
                    'action' => $item['action'] ?? null,
                    'src_address' => $item['src-address'] ?? null,
                    'dst_address' => $item['dst-address'] ?? null,
                    'protocol' => $item['protocol'] ?? null,
                    'dst_port' => $item['dst-port'] ?? null,
                    'to_addresses' => $item['to-addresses'] ?? null,
                    'comment' => $item['comment'] ?? null,
                    'disabled' => isset($item['disabled']) && $item['disabled'] === 'true',
                ];
            }

            return $rules;
        } catch (\Exception $e) {
            Log::error("MikroTik Get NAT Rules Error: " . $e->getMessage());
            return [];
        }
    }

    // ========== إدارة DHCP ==========

    /**
     * جلب عقود DHCP (Leases)
     */
    public function getDHCPLeases(): array
    {
        try {
            $query = (new Query('/ip/dhcp-server/lease/print'));
            $response = $this->client->query($query)->read();

            $leases = [];
            foreach ($response as $item) {
                $leases[] = [
                    'id' => $item['.id'] ?? null,
                    'address' => $item['address'] ?? null,
                    'mac_address' => $item['mac-address'] ?? null,
                    'hostname' => $this->convertToUtf8($item['host-name'] ?? null),  // 🔥 تحويل اسم المضيف
                    'client_id' => $item['client-id'] ?? null,
                    'status' => $item['status'] ?? null,
                    'server' => $item['server'] ?? null,
                    'expires_after' => $item['expires-after'] ?? null,
                    'comment' => $this->convertToUtf8($item['comment'] ?? null),  // 🔥 تحويل التعليق
                ];
            }

            return $leases;
        } catch (\Exception $e) {
            Log::error("MikroTik Get DHCP Leases Error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * إضافة Lease جديد
     */
    public function addDHCPLease(string $address, string $macAddress, string $hostname = null): bool
    {
        try {
            $query = (new Query('/ip/dhcp-server/lease/add'))
                ->equal('address', $address)
                ->equal('mac-address', $macAddress);

            if ($hostname) {
                $query->equal('host-name', $hostname);
            }

            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Add DHCP Lease Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * حذف Lease
     */
    public function deleteDHCPLease(string $id): bool
    {
        try {
            $query = (new Query('/ip/dhcp-server/lease/remove'))
                ->equal('.id', $id);

            $this->client->query($query)->read();
            return true;
        } catch (\Exception $e) {
            Log::error("MikroTik Delete DHCP Lease Error: " . $e->getMessage());
            return false;
        }
    }
}
