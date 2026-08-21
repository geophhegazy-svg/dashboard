<?php

declare(strict_types=1);

namespace App\Modules\Reports\Infrastructure\Persistence\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduledReport extends Model
{
    use HasFactory;

    protected $table = 'scheduled_reports';

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

    protected static function newFactory()
    {
        return \Database\Factories\Modules\Reports\Infrastructure\Persistence\Models\ScheduledReportFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }
}
