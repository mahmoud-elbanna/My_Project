@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-indigo-900 via-purple-900 to-pink-800 px-4">
    <div class="w-full max-w-3xl bg-gray-900 p-10 rounded-2xl shadow-2xl text-gray-100">
        <h2 class="text-3xl font-bold mb-6 text-center">Create an Account</h2>

        <form method="POST" action="{{ route('register.post') }}" class="space-y-6">
            @csrf

            <!-- Name + Phone -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm mb-1">Name</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3">👤</span>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                            class="w-full pl-10 p-3 rounded-lg bg-gray-800 border border-gray-700 focus:ring-2 focus:ring-purple-500 focus:outline-none"
                            oninput="checkNameStrength()">
                    </div>
                    <div class="h-2 w-full bg-gray-700 rounded mt-2">
                        <div id="name-strength-bar" class="h-2 rounded"></div>
                    </div>
                    <p id="name-strength-text" class="text-xs mt-1"></p>
                    @error('name')
                        <div class="bg-red-600 text-white text-xs mt-2 p-2 rounded-md error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="phone" class="block text-sm mb-1">Phone</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3">📱</span>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                            class="w-full pl-10 p-3 rounded-lg bg-gray-800 border border-gray-700 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                    </div>
                    @error('phone')
                        <div class="bg-red-600 text-white text-xs mt-2 p-2 rounded-md error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Date of Birth + Gender -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="date_of_birth" class="block text-sm mb-1">Date of Birth</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3">📅</span>
                        <input id="date_of_birth" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                            class="w-full pl-10 p-3 rounded-lg bg-gray-800 border border-gray-700 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                    </div>
                    @error('date_of_birth')
                        <div class="bg-red-600 text-white text-xs mt-2 p-2 rounded-md error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="gender" class="block text-sm mb-1">Gender</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3">⚧️</span>
                        <select id="gender" name="gender"
                            class="w-full pl-10 p-3 rounded-lg bg-gray-800 border border-gray-700 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                            <option value="">-- Select --</option>
                            <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    @error('gender')
                        <div class="bg-red-600 text-white text-xs mt-2 p-2 rounded-md error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm mb-1">Email</label>
                <div class="relative">
                    <span class="absolute left-3 top-3">📧</span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        class="w-full pl-10 p-3 rounded-lg bg-gray-800 border border-gray-700 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>
                @error('email')
                    <div class="bg-red-600 text-white text-xs mt-2 p-2 rounded-md error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password + Confirm Password -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3">🔒</span>
                        <input id="password" type="password" name="password"
                            class="w-full pl-10 pr-10 p-3 rounded-lg bg-gray-800 border border-gray-700 focus:ring-2 focus:ring-purple-500 focus:outline-none"
                            oninput="checkPasswordStrength()">
                        <button type="button" onclick="togglePassword('password')" 
                            class="absolute right-3 top-3 text-gray-400">👁️</button>
                    </div>
                    <div class="h-2 w-full bg-gray-700 rounded mt-2">
                        <div id="password-strength-bar" class="h-2 rounded"></div>
                    </div>
                    <p id="password-strength-text" class="text-xs mt-1"></p>
                    @error('password')
                        <div class="bg-red-600 text-white text-xs mt-2 p-2 rounded-md error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm mb-1">Confirm Password</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3">🔒</span>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            class="w-full pl-10 pr-10 p-3 rounded-lg bg-gray-800 border border-gray-700 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                        <button type="button" onclick="togglePassword('password_confirmation')" 
                            class="absolute right-3 top-3 text-gray-400">👁️</button>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-600 text-white text-xs mt-4 p-2 rounded-md success-message">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Submit -->
            <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-purple-600 to-pink-500 rounded-lg font-semibold hover:opacity-90 transition">
                Register
            </button>
        </form>
    </div>
</div>

<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    input.type = input.type === "password" ? "text" : "password";
}

function checkPasswordStrength() {
    const pwd = document.getElementById("password").value;
    const bar = document.getElementById("password-strength-bar");
    const text = document.getElementById("password-strength-text");
    let strength = 0;

    if (pwd.length > 5) strength++;
    if (/[A-Z]/.test(pwd)) strength++;
    if (/[0-9]/.test(pwd)) strength++;
    if (/[^A-Za-z0-9]/.test(pwd)) strength++;

    bar.style.width = (strength * 25) + "%";

    if (strength <= 1) { bar.style.background = "red"; text.innerText = "Weak"; }
    else if (strength == 2) { bar.style.background = "orange"; text.innerText = "Medium"; }
    else if (strength == 3) { bar.style.background = "yellow"; text.innerText = "Strong"; }
    else { bar.style.background = "limegreen"; text.innerText = "Very Strong"; }
}

function checkNameStrength() {
    const name = document.getElementById("name").value;
    const bar = document.getElementById("name-strength-bar");
    const text = document.getElementById("name-strength-text");
    let strength = 0;

    if (name.length > 2) strength++;
    if (/\s/.test(name)) strength++; // فيه اسم + لقب
    if (/^[A-Z]/.test(name)) strength++;

    bar.style.width = (strength * 33) + "%";

    if (strength <= 1) { bar.style.background = "red"; text.innerText = "Weak"; }
    else if (strength == 2) { bar.style.background = "orange"; text.innerText = "Medium"; }
    else { bar.style.background = "limegreen"; text.innerText = "Strong"; }
}

// إخفاء الرسائل بعد 3 ثواني
setTimeout(() => {
    document.querySelectorAll('.error-message, .success-message').forEach(el => {
        el.style.display = 'none';
    });
}, 3000);
</script>
@endsection
