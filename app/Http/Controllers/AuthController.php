<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


    public function login(Request $request)
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('page.index');
        }
        return view('frontend.auth.login');
    }

    public function register(Request $request)
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('page.index');
        }
        return view('frontend.auth.register');
    }

    public function logout()
    {
        $customer = Auth::guard('web')->user();
        log_activity($customer, 'logout', 'Khách đăng xuất', [
            'guard' => 'Web',
        ]);
        Auth::guard('web')->logout();
        return response()->json([
            'message' => 'Đăng xuất thành công',
            'redirect' => route('page.index')
        ]);
    }

    public function submitLogin(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            $customer = Auth::guard('web')->user();
            log_activity($customer, 'login', 'Khách đăng nhập', [
                'guard' => 'Web',
            ]);
            return response()->json(['message' => 'Đăng nhập thành công', 'user' => Auth::guard('web')->user()]);
        }

        return response()->json(['message' => 'Sai email hoặc mật khẩu'], 401);
    }

    public function submitRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $customer = \App\Models\Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        Auth::guard('web')->login($customer);

        log_activity($customer, 'register', 'Khách đăng ký', [
            'guard' => 'Web',
        ]);

        return response()->json(['message' => 'Đăng ký thành công', 'redirect' => route('page.index')]);
    }
}
