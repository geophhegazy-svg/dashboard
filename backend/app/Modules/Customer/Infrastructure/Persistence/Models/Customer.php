<?php

declare(strict_types=1);

namespace App\Modules\Customer\Infrastructure\Persistence\Models;

use App\Modules\Notification\Infrastructure\Persistence\Models\Notification;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Wallet\Infrastructure\Persistence\Models\WalletTransaction;

use App\Traits\BelongsToTenant;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;
    use Notifiable;
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'name',
        'phone',
        'email',
        'address',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
