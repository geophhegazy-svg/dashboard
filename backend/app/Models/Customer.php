<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'tenant_id',
        'name',
        'phone',
        'email',
        'address',
        'national_id',
        'status',
        'notes',
    ]; //
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    public function devices()
    {
        return $this->hasMany(Device::class);
    }
    public function payments()
    {
        return $this->hasManyThrough(
            Payment::class,
            Invoice::class
        );
    }
    
}
