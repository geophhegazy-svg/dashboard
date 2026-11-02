<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Core\Tenancy\Contracts\TenantContextInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class OnboardSubscriberRequest extends FormRequest
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

        $customerTenantExists = Rule::exists('customers', 'id');
        $packageExists = Rule::exists('packages', 'id');
        $deviceExists = Rule::exists('network_devices', 'id');
        $areaExists = Rule::exists('areas', 'id');

        if (! $isGlobal && $tenantId !== null) {
            $tenantExists->where('id', $tenantId);
            $customerTenantExists->where('tenant_id', $tenantId);
            $packageExists->where('tenant_id', $tenantId);
            $deviceExists->where('tenant_id', $tenantId);
            $areaExists->where('tenant_id', $tenantId);
        }

        return [
            'tenant_id' => [
                'required',
                'integer',
                $tenantExists,
            ],

            'customer' => [
                'required',
                'array',
            ],

            'customer.name' => [
                'required',
                'string',
                'max:255',
            ],

            'customer.phone' => [
                'required',
                'string',
                'max:20',
            ],

            'customer.email' => [
                'nullable',
                'email',
            ],

            'customer.address' => [
                'nullable',
                'string',
            ],

            'customer.national_id' => [
                'nullable',
                'string',
                'max:14',
            ],

            'customer.status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                    'suspended',
                ]),
            ],

            'customer.notes' => [
                'nullable',
                'string',
            ],

            'subscription' => [
                'required',
                'array',
            ],

            'subscription.package_id' => [
                'required',
                'integer',
                $packageExists,
            ],

            'subscription.start_date' => [
                'required',
                'date',
            ],

            'subscription.end_date' => [
                'nullable',
                'date',
                'after_or_equal:subscription.start_date',
            ],

            'subscription.monthly_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'subscription.status' => [
                'required',
                Rule::in([
                    'draft',
                    'pending',
                    'active',
                ]),
            ],

            'subscription.notes' => [
                'nullable',
                'string',
            ],

            'network_service' => [
                'required',
                'array',
            ],

            'network_service.area_id' => [
                'nullable',
                'integer',
                $areaExists,
            ],

            'network_service.network_device_id' => [
                'required',
                'integer',
                $deviceExists,
            ],

            'network_service.connection_type' => [
                'required',
                Rule::in([
                    'pppoe',
                    'hotspot',
                ]),
            ],

            'network_service.username' => [
                'required',
                'string',
                'max:255',
            ],

            'network_service.password' => [
                'required',
                'string',
                'max:255',
            ],

            'network_service.mac_address' => [
                'nullable',
                'string',
                'max:17',
            ],

            'network_service.ip_address' => [
                'nullable',
                'ip',
            ],

            'network_service.ip_mode' => [
                'required',
                Rule::in([
                    'dynamic',
                    'static',
                ]),
            ],

            'network_service.starts_at' => [
                'required',
                'date',
            ],

            'network_service.ends_at' => [
                'nullable',
                'date',
                'after_or_equal:network_service.starts_at',
            ],

            'network_service.status' => [
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
