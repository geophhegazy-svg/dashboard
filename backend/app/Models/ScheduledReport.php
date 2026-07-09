<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduledReport extends Model
{
    protected $fillable = [
        'name',
        'report_name',
        'frequency',
        'format',
        'filters',
        'email',
        'is_active',
        'last_run_at',
        'next_run_at',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'filters' => 'array',
            'is_active' => 'boolean',
            'last_run_at' => 'datetime',
            'next_run_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }
}
