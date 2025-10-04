@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="flex min-h-screen bg-gray-100">

    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Main Content --}}
    <main class="flex-1 p-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Dashboard</h1>

        {{-- Products Section --}}
        <section>
            <h2 class="text-xl font-semibold text-gray-700 mb-6 flex items-center">
                <i class="fas fa-box-open mr-2 text-blue-500"></i> Products
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="bg-white shadow-lg rounded-xl p-5 hover:shadow-xl transition">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300' }}"
                             alt="{{ $product->name }}"
                             class="w-full h-40 object-cover rounded-lg">

                        <h3 class="mt-4 text-lg font-semibold text-gray-800">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm">{{ $product->description }}</p>
                        <p class="mt-2 text-blue-600 font-bold">${{ number_format($product->price, 2) }}</p>

                        {{-- ⭐ Rating --}}
                        @php
                            $avgRating = $product->reviews_avg_rating ?? $product->average_rating;
                            $reviewsCount = $product->reviews_count ?? $product->reviews->count();
                        @endphp
                        <div class="flex items-center mt-2">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                            @endfor
                            <span class="ml-2 text-sm text-gray-600">
                                {{ number_format($avgRating ?? 0, 1) }} / 5
                                ({{ $reviewsCount }} reviews)
                            </span>
                        </div>

                        <a href="{{ route('products.show', $product->id) }}"
                           class="inline-block mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                            View
                        </a>

                        <a href="#"
                           onclick="openOrderModal({{ $product->id }}, '{{ $product->name }}')"
                           class="inline-block mt-4 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition ml-2">
                            Order Now
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
</div>

<!-- Order Modal -->
<div id="orderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Place Order</h2>
        
        <form id="orderForm" action="{{ route('orders.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" id="orderProductId">

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Product</label>
                <input type="text" id="orderProductName" class="w-full border-gray-300 rounded-lg p-2" disabled>
            </div>

            <div class="mb-4">
                <label for="quantity" class="block text-gray-700 font-semibold">Quantity</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1" 
                       class="w-full border-gray-300 rounded-lg p-2" required>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeOrderModal()" 
                        class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    Confirm Order
                </button>
            </div>
        </form>
    </div>
</div>

<x-order-modal />
@endsection
