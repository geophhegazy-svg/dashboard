<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Modules\Customer\Application\Actions\ChangeCustomerPasswordAction;
use App\Modules\Customer\Application\Actions\UpdateCustomerProfileAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerProfileController extends Controller
{
    public function __construct(
        private readonly UpdateCustomerProfileAction $updateProfile,
        private readonly ChangeCustomerPasswordAction $changePassword,
    ) {}

    public function show()
    {
        $customer = Auth::guard('customer')->user();

        return view(
            'customer.profile',
            compact('customer')
        );
    }

    public function update(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:customers,email,' . $customer->id,
            'phone'   => 'required|string|unique:customers,phone,' . $customer->id,
            'address' => 'nullable|string',
        ]);

        $this->updateProfile->execute(
            $customer,
            $request->only([
                'name',
                'email',
                'phone',
                'address',
            ]),
        );

        return back()->with(
            'success',
            'تم تحديث البيانات بنجاح'
        );
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:8|confirmed',
        ]);

        $customer = Auth::guard('customer')->user();

        if (! Hash::check(
            $request->current_password,
            $customer->password
        )) {
            return back()->withErrors([
                'current_password' => 'كلمة المرور الحالية غير صحيحة',
            ]);
        }

        $this->changePassword->execute(
            $customer,
            $request->new_password,
        );

        return back()->with(
            'success',
            'تم تغيير كلمة المرور بنجاح'
        );
    }
}
