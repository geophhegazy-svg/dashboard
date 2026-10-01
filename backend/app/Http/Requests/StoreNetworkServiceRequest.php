<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Core\Tenancy\Contracts\TenantContextInterface;
use Illuminate\Validation\Rule;

class StoreNetworkServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tenantContext = app(TenantContextInterface::class);
        $tenantId = $tenantContext->tenantId();
        $isGlobal = $tenantContext->isGlobal();

        $tenantExists = Rule::exists('tenants', 'id');

        $customerExists = Rule::exists('customers', 'id');
        $areaExists = Rule::exists('areas', 'id');
        $packageExists = Rule::exists('packages', 'id');
        $deviceExists = Rule::exists('network_devices', 'id');

        if (! $isGlobal && $tenantId !== null) {
            $tenantExists->where('id', $tenantId);
            $customerExists->where('tenant_id', $tenantId);
            $areaExists->where('tenant_id', $tenantId);
            $packageExists->where('tenant_id', $tenantId);
            $deviceExists->where('tenant_id', $tenantId);
        }

        return [
            'tenant_id' => [
                'required',
                $tenantExists,
            ],

            'customer_id' => [
                'required',
                $customerExists,
            ],

            'area_id' => [
                'nullable',
                $areaExists,
            ],

            'package_id' => [
                'required',
                $packageExists,
            ],

            'network_device_id' => [
                'required',
                $deviceExists,
            ],

            'connection_type' => [
                'required',
                Rule::in(['pppoe', 'hotspot']),
            ],

            'username' => [
                'required',
                'string',
                'max:255',
            ],

            'password' => [
                'required',
                'string',
                'max:255',
            ],

            'mac_address' => [
                'nullable',
                'string',
                'max:17',
            ],

            'ip_address' => [
                'nullable',
                'ip',
            ],

            'ip_mode' => [
                'required',
                Rule::in(['dynamic', 'static']),
            ],

            'starts_at' => [
                'required',
                'date',
            ],

            'ends_at' => [
                'nullable',
                'date',
                'after_or_equal:starts_at',
            ],

            'status' => [
                'sometimes',
                Rule::in([
                    'pending',
                    'active',
                    'suspended',
                    'expired',
                    'cancelled',
                ]),
            ],
        ];
    }
}
