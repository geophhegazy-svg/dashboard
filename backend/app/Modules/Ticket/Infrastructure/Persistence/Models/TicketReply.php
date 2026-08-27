<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Infrastructure\Persistence\Models;

use App\Models\User;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use Database\Factories\Modules\Ticket\Infrastructure\Persistence\Models\TicketReplyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketReply extends Model
{
    use HasFactory;

    protected static function newFactory(): TicketReplyFactory
    {
        return TicketReplyFactory::new();
    }

    protected $fillable = [
        'ticket_id',
        'customer_id',
        'user_id',
        'message',
        'is_staff',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'is_staff' => 'boolean',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
