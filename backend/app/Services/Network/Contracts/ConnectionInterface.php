<?php

declare(strict_types=1);

namespace App\Services\Network\Contracts;

use RouterOS\Client;

interface ConnectionInterface
{
    /**
     * إنشاء اتصال جديد مع MikroTik.
     */
    public function connect(
        string $host,
        string $username,
        string $password,
        int $port = 8728
    ): bool;

    /**
     * إعادة الاتصال باستخدام آخر بيانات اتصال.
     */
    public function reconnect(): bool;

    /**
     * إنهاء الاتصال الحالي.
     */
    public function disconnect(): void;

    /**
     * التحقق من حالة الاتصال.
     */
    public function isConnected(): bool;

    /**
     * الحصول على RouterOS Client.
     */
    public function getClient(): ?Client;

    /**
     * اختبار الاتصال بالجهاز.
     */
    public function testConnection(): bool;

    /**
     * الحصول على اسم الجهاز (Identity).
     */
    public function getIdentity(): ?string;

    /**
     * الحصول على إصدار RouterOS.
     */
    public function getRouterOSVersion(): ?string;

    /**
     * الحصول على نوع المعمارية (Architecture).
     */
    public function getArchitecture(): ?string;

    /**
     * الحصول على مدة التشغيل (Uptime).
     */
    public function getUptime(): ?string;
}
