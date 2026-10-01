<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Core\Tenancy\Contracts\TenantContextInterface;
use Illuminate\Validation\Rule;

class UpdateNetworkServiceRequest extends FormRequest
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
                'sometimes',
                'required',
                $tenantExists,
            ],

            'customer_id' => [
                'sometimes',
                'required',
                $customerExists,
            ],

            'area_id' => [
                'sometimes',
                'nullable',
                $areaExists,
            ],

            'package_id' => [
                'sometimes',
                'required',
                $packageExists,
            ],

            'network_device_id' => [
                'sometimes',
                'required',
                $deviceExists,
            ],

            'connection_type' => [
                'sometimes',
                'required',
                Rule::in(['pppoe', 'hotspot']),
            ],

            'username' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],

            'password' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
            ],

            'mac_address' => [
                'sometimes',
                'nullable',
                'string',
                'max:17',
            ],

            'ip_address' => [
                'sometimes',
                'nullable',
                'ip',
            ],

            'ip_mode' => [
                'sometimes',
                'required',
                Rule::in(['dynamic', 'static']),
            ],

            'starts_at' => [
                'sometimes',
                'required',
                'date',
            ],

            'ends_at' => [
                'sometimes',
                'nullable',
                'date',
                'after_or_equal:starts_at',
            ],

            'status' => [
                'prohibited',
            ],
        ];
    }
}
