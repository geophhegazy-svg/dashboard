<?php

namespace App\Services\Network;

use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Query;

class MikrotikConnection
{
    protected Client $client;

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

    /**
     * Return MikroTik Client instance.
     */
    public function client(): Client
    {
        return $this->client;
    }

    /**
     * Clean a single string to valid UTF-8.
     */
    protected function cleanString(mixed $value): mixed
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
            'ISO-8859-1',
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
                // Ignore and continue
            }
        }

        return @iconv(
            'UTF-8',
            'UTF-8//IGNORE',
            $value
        ) ?: '';
    }

    /**
     * Clean array recursively.
     */
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

    /**
     * Execute RouterOS query and return cleaned result.
     */
    public function execute(Query $query): array
    {
        $result = $this->client()
            ->query($query)
            ->read();

        return $this->cleanArray($result);
    }
}
