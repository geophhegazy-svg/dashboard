<?php

declare(strict_types=1);

namespace App\Scopes;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class TenantScope implements Scope
{
    /**
     * يتم تنفيذ الكود ده تلقائيًا مع أي استعلام (Query) على أي موديل
     * بيستخدم الـ Trait بتاع BelongsToTenant.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $user = Auth::user();

        // لو مفيش يوزر مسجل دخوله (مثلاً أمر Console شغال من غير طلب ويب)
        // متعملش فلترة خالص، عشان الأوامر التلقائية (زي subscriptions:sync)
        // تقدر تشتغل على كل الشركات.
        if (!$user instanceof User) {
            return;
        }

        // الـ Super Admin بيشوف بيانات كل الشركات (Tenants) من غير استثناء.
        if (method_exists($user, 'hasRole') && $user->hasRole('Super Admin')) {
            return;
        }

        if ($user->tenant_id) {
            $builder->where(
                $model->getTable() . '.tenant_id',
                $user->tenant_id
            );
        }
    }
}
رررر