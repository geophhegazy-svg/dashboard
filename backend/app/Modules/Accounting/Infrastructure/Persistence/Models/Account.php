<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\BelongsToTenant;

class Account extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected static function newFactory()
    {
        return \Database\Factories\Modules\Accounting\Infrastructure\Persistence\Models\AccountFactory::new();
    }

    protected $fillable = [
        'tenant_id',
        'parent_id',
        'code',
        'name',
        'type',
        'nature',
        'level',
        'is_system',
        'is_active',
        'description',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            self::class,
            'parent_id',
        );
    }

    public function children(): HasMany
    {
        return $this->hasMany(
            self::class,
            'parent_id',
        )->orderBy('code');
    }

    public function journalEntryLines(): HasMany
    {
        return $this->hasMany(
            JournalEntryLine::class,
        );
    }
}
