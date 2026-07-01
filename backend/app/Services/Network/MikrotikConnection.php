<?php

namespace App\Services\Network;

use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Query;

class MikrotikConnection
{
    protected ?Client $client = null;

    /**
     * Return MikroTik Client instance.
     */
    public function client(): Client
    {
        if ($this->client === null) {

            $this->client = new Client(
                new Config([
                    'host' => config('mikrotik.host'),
                    'user' => config('mikrotik.user'),
                    'pass' => config('mikrotik.password'),
                    'port' => config('mikrotik.port'),
                ])
            );
        }

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

        foreach (
            [
                'Windows-1256',
                'ISO-8859-6',
                'CP1252',
                'ISO-8859-1',
            ] as $encoding
        ) {

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
            } catch (\Throwable) {
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
     * Execute RouterOS query.
     */
    public function execute(Query $query): array
    {
        return $this->cleanArray(
            $this->client()
                ->query($query)
                ->read()
        );
    }
}
