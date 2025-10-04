<aside id="sidebar"
    class="w-64 bg-gray-900 text-white flex flex-col min-h-screen shadow-lg transform -translate-x-full md:translate-x-0 transition-transform duration-300 fixed md:static z-50">

    <!-- Logo / App Name -->
    <div class="p-4 text-2xl font-bold border-b border-gray-700">
        MyApp
    </div>

    <!-- User Profile -->
    <div class="p-6 flex flex-col items-center border-b border-gray-700">
        <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : 'https://via.placeholder.com/120' }}" 
             alt="Profile" 
             class="w-24 h-24 border-4 border-gray-600 shadow-md rounded-lg object-cover">
        <p class="mt-3 font-semibold text-lg">{{ Auth::user()->name }}</p>
    </div>

    <!-- Nav Links -->
    <nav class="flex-1 overflow-y-auto p-4 space-y-2">
        <a href="{{ route('dashboard') }}" 
           class="flex items-center gap-3 px-3 py-2 rounded-lg transition hover:bg-blue-700 hover:text-white">
            <i class="fas fa-home w-5"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('products.index') }}" 
           class="flex items-center gap-3 px-3 py-2 rounded-lg transition hover:bg-blue-700 hover:text-white">
            <i class="fas fa-box-open w-5"></i>
            <span>Products</span>
        </a>

        <a href="{{ route('orders.index') }}" 
           class="flex items-center gap-3 px-3 py-2 rounded-lg transition hover:bg-blue-700 hover:text-white">
            <i class="fas fa-shopping-cart w-5"></i>
            <span>Orders</span>
        </a>

        <a href="{{ route('profile.edit') }}" 
           class="flex items-center gap-3 px-3 py-2 rounded-lg transition hover:bg-blue-700 hover:text-white">
            <i class="fas fa-user-edit w-5"></i>
            <span>Update Profile</span>
        </a>

        <a href="{{ route('password.edit') }}" 
           class="flex items-center gap-3 px-3 py-2 rounded-lg transition hover:bg-blue-700 hover:text-white">
            <i class="fas fa-key w-5"></i>
            <span>Change Password</span>
        </a>

        {{-- Logout Button --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full text-left flex items-center gap-3 px-3 py-2 rounded-lg transition hover:bg-red-600 hover:text-white">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span>Logout</span>
            </button>
        </form>
    </nav>

    <!-- Footer -->
    <div class="p-4 border-t border-gray-700 text-sm text-gray-400">
        © {{ date('Y') }} MyApp
    </div>
</aside>
