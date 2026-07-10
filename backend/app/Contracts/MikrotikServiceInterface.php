<?php

namespace App\Contracts;

use App\Models\NetworkDevice;

interface MikrotikServiceInterface
{
    /**
     * الاتصال بجهاز MikroTik
     */
    public function connect(string $ip, string $username, string $password, int $port = 8728): bool;

    /**
     * إنشاء مستخدم PPPoE جديد
     */
    public function createUser(string $username, string $password, string $profile, array $options = []): bool;

    /**
     * تعطيل مستخدم
     */
    public function disableUser(string $username): bool;

    /**
     * تفعيل مستخدم
     */
    public function enableUser(string $username): bool;

    /**
     * حذف مستخدم
     */
    public function deleteUser(string $username): bool;

    /**
     * جلب جميع مستخدمي PPPoE من MikroTik
     */
    public function getAllUsers(): array;

    /**
     * جلب الجلسات النشطة
     */
    public function getActiveSessions(): array;

    /**
     * تحديث حدود السرعة (Queue)
     */
    public function updateUserQueue(string $username, int $download, int $upload): bool;

    /**
     * جلب القراءة التراكمية لاستهلاك كل Queue (اسم الـ Queue = اسم مستخدم PPPoE).
     * كل عنصر: ['name' => ..., 'bytes_download' => ..., 'bytes_upload' => ...]
     */
    public function getQueueUsage(): array;

    /**
     * الحصول على إحصائيات الجهاز
     */
    public function getDeviceStats(): array;

    /**
     * Ping للجهاز
     */
    public function ping(string $ip): bool;

    /**
     * فصل مستخدم عن الجلسة النشطة
     */
    public function disconnectUser(string $username): bool;

    /**
     * تحديث حالة الجهاز في قاعدة البيانات
     */
    public function updateDeviceStatus(NetworkDevice $device): void;

    // ========== دوال Hotspot ==========
    public function getHotspotUsers(): array;
    public function getHotspotActiveSessions(): array;
    public function createHotspotUser(string $username, string $password, string $profile, array $options = []): bool;
    public function disableHotspotUser(string $username): bool;
    public function enableHotspotUser(string $username): bool;
}
