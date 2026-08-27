<?php

declare(strict_types=1);

namespace App\Modules\Task\Infrastructure\Persistence\Models;

use App\Models\Tenant;
use App\Models\User;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Database\Factories\TaskFactory;

class Task extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected static function newFactory()
    {
        return TaskFactory::new();
    }

    protected $fillable = [
        'tenant_id',
        'user_id',
        'title',
        'description',
        'priority',
        'status',
        'started_at',
        'completed_at',
        'cancelled_at',
        'meta',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'meta' => 'array',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
