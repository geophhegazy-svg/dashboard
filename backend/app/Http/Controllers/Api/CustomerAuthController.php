<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Customer\Application\Actions\ChangeCustomerPasswordAction;
use App\Modules\Customer\Application\Actions\UpdateCustomerProfileAction;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class CustomerAuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        $customer = Customer::where(
            'phone',
            $request->input('phone')
        )->first();

        if (
            !$customer ||
            !Hash::check(
                $request->input('password'),
                $customer->password
            )
        ) {
            return response()->json([
                'message' => 'Invalid phone or password',
            ], 401);
        }

        $token = $customer
            ->createToken('customer-token')
            ->plainTextToken;

        return response()->json([
            'token' => $token,
            'customer' => $customer,
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json(
            $request->user()
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $token = $request->bearerToken();

        if ($token !== null) {
            PersonalAccessToken::findToken($token)?->delete();
        }

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    public function updateProfile(
        Request $request,
        UpdateCustomerProfileAction $action,
    ): JsonResponse {
        /** @var Customer $customer */
        $customer = $request->user();

        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['sometimes', 'string', 'max:50'],
            'email' => ['sometimes', 'nullable', 'email', 'max:255'],
            'address' => ['sometimes', 'nullable', 'string', 'max:1000'],
        ]);

        $customer = $action->execute(
            $customer,
            $data,
        );

        return response()->json([
            'message' => 'Profile updated successfully',
            'customer' => $customer,
        ]);
    }

    public function changePassword(
        Request $request,
        ChangeCustomerPasswordAction $action,
    ): JsonResponse {
        /** @var Customer $customer */
        $customer = $request->user();

        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check(
            $data['current_password'],
            $customer->password
        )) {
            return response()->json([
                'message' => 'Current password is incorrect',
            ], 422);
        }

        $customer = $action->execute(
            $customer,
            $data['password'],
        );

        return response()->json([
            'message' => 'Password changed successfully',
            'customer' => $customer,
        ]);
    }
}
