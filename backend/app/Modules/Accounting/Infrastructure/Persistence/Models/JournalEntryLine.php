<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JournalEntryLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_entry_id',
        'account_id',
        'description',
        'debit',
        'credit',
    ];

    protected function casts(): array
    {
        return [
            'debit' => 'decimal:2',
            'credit' => 'decimal:2',
        ];
    }

    public function journalEntry(): BelongsTo
    {
        return $this->belongsTo(
            JournalEntry::class,
            'journal_entry_id',
        );
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(
            Account::class,
            'account_id',
        );
    }
}
