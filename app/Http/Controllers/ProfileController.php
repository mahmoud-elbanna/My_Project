<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('dashboard.profile.edit');
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        // ✅ Update name & email
        $user->name = $request->input('name');
        $oldEmail = $user->email; // نخزن الإيميل القديم
        $user->email = $request->input('email');

        // ✅ Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // لو فيه صورة قديمة → امسحها
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // خزن الصورة الجديدة
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        // ✅ لو الإيميل اتغير → اعمل reset للـ verification وابعث لينك جديد
        if ($oldEmail !== $user->email) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($oldEmail !== $user->email) {
            event(new Registered($user)); // Laravel هيبعت Verify Email جديد
            return redirect()->route('verification.notice')
                             ->with('success', 'Profile updated! Please verify your new email.');
        }

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }
}
