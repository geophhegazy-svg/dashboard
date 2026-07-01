<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'logo', 'phone', 'email', 'address', 'domain', 'status',];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
