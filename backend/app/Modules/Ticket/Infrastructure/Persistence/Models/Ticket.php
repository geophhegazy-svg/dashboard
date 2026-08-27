<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Infrastructure\Persistence\Models;

use App\Models\Tenant;
use App\Models\User;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Traits\BelongsToTenant;
use Database\Factories\Modules\Ticket\Infrastructure\Persistence\Models\TicketFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected static function newFactory(): TicketFactory
    {
        return TicketFactory::new();
    }

    protected $fillable = [
        'tenant_id',
        'customer_id',
        'user_id',
        'ticket_number',
        'subject',
        'description',
        'priority',
        'status',
        'opened_at',
        'closed_at',
        'notes',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(TicketReply::class)
            ->orderBy('sent_at');
    }
}
