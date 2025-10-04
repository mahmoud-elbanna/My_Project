<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;



class AdminAuthController extends Controller
{
    // عرض صفحة التسجيل
    public function showRegisterForm()
    {
        return view('admin.auth.register');
    }

    // معالجة التسجيل
    public function register(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // إنشاء Admin جديد
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // تسجيل الدخول مباشرة باستخدام Guard Admin
        auth()->guard('admin')->login($admin);

        // Redirect للـ Dashboard
        return redirect()->route('admin.dashboard');
    }

    // عرض صفحة تسجيل الدخول
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // معالجة تسجيل الدخول
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required|string',
        ]);

        if(auth()->guard('admin')->attempt($credentials, $request->filled('remember'))){
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email'=>'Invalid credentials'
        ]);
    }

    // تسجيل الخروج
    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
