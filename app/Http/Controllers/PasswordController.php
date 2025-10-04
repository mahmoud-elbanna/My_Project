<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdatePasswordRequest;


class PasswordController extends Controller
{
    public function edit()
    {
        return view('dashboard.password.edit');
    }

    public function update(UpdatePasswordRequest $request)
    {
        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'The current password is incorrect.');
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Your password has been updated successfully!');
    }
}
