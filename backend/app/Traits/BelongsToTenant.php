<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\User;
use App\Scopes\TenantScope;
use Illuminate\Support\Facades\Auth;

trait BelongsToTenant
{
    /**
     * بيتنادى تلقائيًا لما الموديل يتحمّل.
     * بيضيف الفلترة التلقائية + بيملأ tenant_id وحده لما تتعمل عملية Create.
     */
    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function ($model) {

            // لو الموديل ده اتعمله tenant_id يدويًا بالفعل، سيبه زي ما هو.
            if ($model->tenant_id) {
                return;
            }

            $user = Auth::user();

            if ($user instanceof User && $user->tenant_id) {
                $model->tenant_id = $user->tenant_id;
            }
        });
    }
}
