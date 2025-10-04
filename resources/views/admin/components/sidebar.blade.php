<div class="w-64 bg-white shadow-lg rounded-r-2xl min-h-screen p-6 flex flex-col justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-8">Admin Panel</h2>
        <nav class="flex flex-col gap-4">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200 font-semibold' : '' }}">
                🏠 Dashboard
            </a>

            {{-- Products Section --}}
            <div class="flex flex-col gap-2">
                <span class="px-3 text-gray-500 uppercase text-sm">Products</span>
                <a href="{{ route('admin.products.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.products.index') ? 'bg-gray-200 font-semibold' : '' }}">
                    📦 All Products
                </a>
                <a href="{{ route('admin.products.create') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.products.create') ? 'bg-gray-200 font-semibold' : '' }}">
                    ➕ Add Product
                </a>
                <a href="{{ route('admin.products.top_rated') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.products.top_rated') ? 'bg-gray-200 font-semibold' : '' }}">
                    ⭐ Top Rated
                </a>
            </div>

            {{-- Reviews Section --}}
            <a href="{{ route('admin.reviews.index') }}"
               class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.reviews.*') ? 'bg-gray-200 font-semibold' : '' }}">
                📝 Reviews
            </a>

            {{-- Orders Section --}}
            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-200 font-semibold' : '' }}">
                📄 Orders
            </a>

            {{-- Users Section --}}
            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.users.*') ? 'bg-gray-200 font-semibold' : '' }}">
                👤 Users
            </a>
        </nav>
    </div>

    {{-- Logout --}}
    <div class="mt-6">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-2 px-3 py-2 rounded bg-red-500 text-white hover:bg-red-600">
                🔒 Logout
            </button>
        </form>
    </div>
</div>
