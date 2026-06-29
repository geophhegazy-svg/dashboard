<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Customer extends Authenticatable
{
    use HasApiTokens, Notifiable;

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
        return $this->hasMany(\App\Models\Notification::class);
    }
}
