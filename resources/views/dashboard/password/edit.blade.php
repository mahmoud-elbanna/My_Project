@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-black text-gray-100 flex items-center justify-center px-4">
    <div class="bg-gray-800/80 backdrop-blur-xl p-8 rounded-2xl shadow-2xl w-full max-w-lg border border-gray-700">
        
        <!-- Success Alert -->
        @if(session('success'))
            <div id="successAlert" class="mb-6 p-4 rounded-xl bg-green-700/80 text-green-100 shadow-lg text-center font-medium animate-fadeIn">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Error Alert -->
        @if(session('error'))
            <div id="errorAlert" class="mb-6 p-4 rounded-xl bg-red-700/80 text-red-100 shadow-lg text-center font-medium animate-fadeIn">
                ❌ {{ session('error') }}
            </div>
        @endif

        <!-- Header -->
        <div class="flex flex-col items-center mb-6">
            <div class="relative">
                <div class="w-24 h-24 flex items-center justify-center rounded-full border-4 border-purple-600 shadow-md bg-gray-900 text-4xl">
                    🔒
                </div>
            </div>
            <h2 class="text-2xl font-bold mt-4">Change Password</h2>
            <p class="text-sm text-gray-400">Keep your account secure</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Current Password -->
            <div>
                <label class="block mb-2 text-sm font-medium">Current Password</label>
                <div class="relative">
                    <input type="password" name="current_password" id="current_password"
                           class="w-full p-3 rounded-xl bg-gray-900 border @error('current_password') border-red-500 @else border-gray-700 @enderror focus:border-purple-500 focus:ring-2 focus:ring-purple-600 outline-none transition">
                    <button type="button" onclick="togglePassword('current_password')" 
                            class="absolute right-3 top-3 text-gray-400 hover:text-gray-200 text-sm">👁</button>
                </div>
                @error('current_password')
                    <p class="error-message text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Password -->
            <div>
                <label class="block mb-2 text-sm font-medium">New Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                           class="w-full p-3 rounded-xl bg-gray-900 border @error('password') border-red-500 @else border-gray-700 @enderror focus:border-purple-500 focus:ring-2 focus:ring-purple-600 outline-none transition">
                    <button type="button" onclick="togglePassword('password')" 
                            class="absolute right-3 top-3 text-gray-400 hover:text-gray-200 text-sm">👁</button>
                </div>
                @error('password')
                    <p class="error-message text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block mb-2 text-sm font-medium">Confirm New Password</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full p-3 rounded-xl bg-gray-900 border border-gray-700 focus:border-purple-500 focus:ring-2 focus:ring-purple-600 outline-none transition">
                    <button type="button" onclick="togglePassword('password_confirmation')" 
                            class="absolute right-3 top-3 text-gray-400 hover:text-gray-200 text-sm">👁</button>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-purple-600 to-pink-500 hover:opacity-90 rounded-xl font-semibold shadow-md transition">
                🔑 Update Password
            </button>
        </form>

        <!-- Back Button -->
        <a href="{{ route('dashboard') }}"
           class="mt-4 block text-center py-2 bg-gray-700 hover:bg-gray-600 rounded-xl transition">
            ← Back to Dashboard
        </a>
    </div>
</div>

<!-- JS -->
<script>
    // Auto-hide alerts after 3s
    ['successAlert','errorAlert'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            setTimeout(() => {
                el.style.opacity = '0';
                el.style.transition = 'opacity 0.5s ease';
                setTimeout(() => el.remove(), 500);
            }, 3000);
        }
    });

    // Auto-hide validation errors after 3s
    document.querySelectorAll('.error-message').forEach(el => {
        setTimeout(() => {
            el.style.opacity = '0';
            el.style.transition = 'opacity 0.5s ease';
            setTimeout(() => el.remove(), 500);
        }, 3000);
    });

    // Toggle password visibility
    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === "password" ? "text" : "password";
    }
</script>
@endsection
