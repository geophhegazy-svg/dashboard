<?php

declare(strict_types=1);

namespace App\Modules\Reports\Infrastructure\Persistence\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportExport extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Database\Factories\Modules\Reports\Infrastructure\Persistence\Models\ReportExportFactory::new();
    }

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
            Report::class,
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'exported_by',
        );
    }
}
