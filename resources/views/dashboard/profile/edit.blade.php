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

        <!-- Header -->
        <div class="flex flex-col items-center mb-6">
            <div class="relative">
                <img id="profilePreview"
                     src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : 'https://via.placeholder.com/100x100.png?text=Avatar' }}"
                     alt="Profile Image" 
                     class="w-24 h-24 rounded-full border-4 border-purple-600 shadow-md object-cover">

                <label for="profileImageInput" 
                       class="absolute bottom-0 right-0 bg-purple-600 p-2 rounded-full text-white text-xs shadow-md cursor-pointer hover:bg-purple-500 transition">
                    ✎
                </label>
            </div>
            <h2 class="text-2xl font-bold mt-4">Update Profile</h2>
            <p class="text-sm text-gray-400">Keep your profile information up to date</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT') 
            <!-- Profile Image -->
            <input type="file" name="profile_image" id="profileImageInput" class="hidden">

            <!-- Name -->
            <div>
                <label class="block mb-2 text-sm font-medium">Name</label>
                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                       class="w-full p-3 rounded-xl bg-gray-900 border @error('name') border-red-500 @else border-gray-700 @enderror focus:border-purple-500 focus:ring-2 focus:ring-purple-600 outline-none transition">
                @error('name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block mb-2 text-sm font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                       class="w-full p-3 rounded-xl bg-gray-900 border @error('email') border-red-500 @else border-gray-700 @enderror focus:border-purple-500 focus:ring-2 focus:ring-purple-600 outline-none transition">
                @error('email')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-purple-600 to-pink-500 hover:opacity-90 rounded-xl font-semibold shadow-md transition">
                💾 Save Changes
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
    // Preview for profile image
    document.getElementById('profileImageInput').addEventListener('change', function (event) {
        let reader = new FileReader();
        reader.onload = function () {
            document.getElementById('profilePreview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });

    // Auto-hide success message after 3s
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.opacity = '0';
            successAlert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => successAlert.remove(), 500);
        }, 3000);
    }
</script>
@endsection
