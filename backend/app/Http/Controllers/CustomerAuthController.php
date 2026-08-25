<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;

class CustomerAuthController extends Controller
{
    // عرض صفحة تسجيل الدخول
    public function showLoginForm()
    {
        return view('customer.auth.login');
    }

    // معالجة تسجيل الدخول
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // محاولة تسجيل الدخول باستخدام Guard customer
        if (Auth::guard('customer')->attempt([
            'username' => $request->username,
            'password' => $request->password,
        ])) {
            return response()->json([
                'message' => 'Customer authentication is available through the API.',
            ]);
        }

        return back()->withErrors([
            'username' => 'بيانات الدخول غير صحيحة',
        ]);
    }

    // تسجيل الخروج
    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login');
    }
}
