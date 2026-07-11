<?php

declare(strict_types=1);

namespace App\Exceptions\Network;

use Throwable;

class ValidationException extends MikroTikException
{
    /**
     * Validation errors.
     *
     * @var array<string,array<int,string>>
     */
    protected array $errors = [];


    /**
     * Create validation exception.
     *
     * @param array<string,array<int,string>> $errors
     * @param array<string,mixed> $context
     */
    public function __construct(
        string $message = 'Router data validation failed.',
        array $errors = [],
        int $code = 422,
        ?Throwable $previous = null,
        array $context = []
    ) {
        parent::__construct(
            $message,
            $code,
            $previous,
            $context
        );

        $this->errors = $errors;
    }


    /**
     * Get validation errors.
     *
     * @return array<string,array<int,string>>
     */
    public function errors(): array
    {
        return $this->errors;
    }


    /**
     * Create invalid parameter exception.
     *
     * @param array<string,mixed> $context
     */
    public static function invalidParameter(
        string $parameter,
        array $context = []
    ): self {
        return new self(
            "Invalid router parameter: {$parameter}.",
            [
                $parameter => [
                    'Invalid value.'
                ]
            ],
            422,
            null,
            $context
        );
    }
}
