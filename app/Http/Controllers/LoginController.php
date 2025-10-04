<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function show()
    {
        return view('login');
    }

    public function authenticate(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return redirect()->route('login')->with('error', 'Invalid credentials');
        }

        $request->session()->regenerate();
        if (is_null($user->email_verified_at)) {
            // Ask to verify email first
            auth()->login($user, false);
            return redirect()->route('verification.notice')->with('error', 'Please verify your email first.');
        }

        auth()->login($user, isset($data['remember']) && (bool)$data['remember']);
        session()->flash('success', 'Login successful');

        return redirect()->route('dashboard');
    }   

}
