<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportExport extends Model
{
    protected $fillable = [
        'report_id',
        'format',
        'filename',
        'disk',
        'path',
        'mime_type',
        'size',
        'exported_by',
        'exported_at',
    ];

    protected function casts(): array
    {
        return [
            'exported_at' => 'datetime',
        ];
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(
            Report::class
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'exported_by'
        );
    }
}
