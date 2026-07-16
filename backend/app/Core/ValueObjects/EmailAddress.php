<?php

declare(strict_types=1);

namespace App\Core\ValueObjects;

use InvalidArgumentException;

final readonly class EmailAddress
{
    private function __construct(
        private string $value,
    ) {}

    public static function make(
        string $value,
    ): self {

        $email = strtolower(trim($value));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid email address [%s].',
                    $value
                )
            );
        }

        return new self($email);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function domain(): string
    {
        return substr(
            strrchr($this->value, '@'),
            1
        );
    }

    public function localPart(): string
    {
        return strstr(
            $this->value,
            '@',
            true
        );
    }

    public function equals(
        self $other
    ): bool {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
