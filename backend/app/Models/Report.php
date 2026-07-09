<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    protected $fillable = [
        'name',
        'title',
        'type',
        'filters',
        'status',
        'generated_by',
        'generated_at',
    ];

    protected function casts(): array
    {
        return [
            'filters' => 'array',
            'generated_at' => 'datetime',
        ];
    }

    public function exports(): HasMany
    {
        return $this->hasMany(
            ReportExport::class
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'generated_by'
        );
    }
}
