<?php

declare(strict_types=1);

namespace App\Modules\Reports\Infrastructure\Persistence\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Database\Factories\Modules\Reports\Infrastructure\Persistence\Models\ReportFactory::new();
    }

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
            ReportExport::class,
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'generated_by',
        );
    }
}
