<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    protected $fillable = [
        'name',
        'email',
        'password',
        'tenant_id',
    ];
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * فلتر اختياري (مش تلقائي) — استخدمه بس لما تحب تجيب موظفين شركة
     * اليوزر المسجل دخوله دلوقتي بس، مثال:
     * User::forCurrentTenant()->get();
     *
     * ما بيتفعّلش لوحده عشان ميعملش مشاكل وقت تسجيل الدخول نفسه.
     */
    public function scopeForCurrentTenant(Builder $query): Builder
    {
        $user = Auth::user();

        if ($user instanceof self && method_exists($user, 'hasRole') && $user->hasRole('Super Admin')) {
            return $query;
        }

        if ($user instanceof self && $user->tenant_id) {
            return $query->where('tenant_id', $user->tenant_id);
        }

        return $query;
    }
}
