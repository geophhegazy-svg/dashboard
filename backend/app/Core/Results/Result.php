<?php

declare(strict_types=1);

namespace App\Core\Results;

use App\Core\Results\Concerns\HasMetadata;
use App\Core\Results\Contracts\ResultInterface;

abstract class Result implements ResultInterface
{
    use HasMetadata;

    protected bool $success;

    protected mixed $data;

    protected ?string $message;

    protected array $errors;

    protected ?string $code;

    public function __construct(
        bool $success,
        mixed $data = null,
        ?string $message = null,
        array $errors = [],
        ?string $code = null,
        array $meta = [],
    ) {
        $this->success = $success;
        $this->data = $data;
        $this->message = $message;
        $this->errors = $errors;
        $this->code = $code;
        $this->meta = $meta;
    }

    public function successful(): bool
    {
        return $this->success;
    }

    public function failed(): bool
    {
        return ! $this->success;
    }

    public function message(): ?string
    {
        return $this->message;
    }

    public function data(): mixed
    {
        return $this->data;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function code(): ?string
    {
        return $this->code;
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'code' => $this->code,
            'data' => $this->data,
            'errors' => $this->errors,
            'meta' => $this->meta,
        ];
    }
}
