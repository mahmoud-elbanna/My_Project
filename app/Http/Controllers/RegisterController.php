<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;



class RegisterController extends Controller
{
    public function create()
    {
        return view('register');
    }

    public function store(RegisterRequest $request)
    {
        $data = $request->validated();

        // ✅ إنشاء المستخدم مع الحقول الجديدة
        $user = User::create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'phone'         => $data['phone'],
            'gender'        => $data['gender'],
            'date_of_birth' => $data['date_of_birth'],
        ]);

        // ✅ إرسال إيميل Verification
        $user->sendEmailVerificationNotification();

        // ✅ تسجيل الدخول للمستخدم
        auth()->login($user);

        // ✅ رسالة نجاح
        session()->flash('success', 'Registration successful. Please verify your email.');

        return redirect()->route('verification.notice');
    }
}
