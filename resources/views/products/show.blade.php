@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="flex min-h-screen bg-gray-100">
    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Main Content --}}
    <main class="flex-1 p-10">
        <div class="max-w-3xl mx-auto">

            {{-- Product Card --}}
            <div class="bg-gray-900 text-white rounded-lg shadow-lg p-6 mb-8">
                <img src="{{ $product->image ?? 'https://via.placeholder.com/150' }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-64 object-cover rounded-lg mb-4">

                <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>
                <p class="text-gray-300 mb-4">{{ $product->description }}</p>
                <p class="text-green-400 font-bold text-lg">${{ number_format($product->price, 2) }}</p>

                <div class="mt-4 flex space-x-3">
                    {{-- Buy Now --}}
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg flex items-center space-x-2">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Buy now</span>
                        </button>
                    </form>

                    {{-- Scroll to Review --}}
                    <button onclick="document.getElementById('review-form').scrollIntoView({ behavior: 'smooth' })"
                        class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg flex items-center space-x-2">
                        <i class="fas fa-star"></i>
                        <span>Add Review</span>
                    </button>
                </div>
            </div>

            {{-- Reviews Section --}}
            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Customer Reviews</h2>

                @forelse($product->reviews as $review)
                    <div class="border-b pb-4 mb-4">
                        <div class="flex items-center mb-2">
                            {{-- Stars --}}
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                            @endfor
                        </div>
                        <p class="text-gray-700">{{ $review->comment ?? 'No comment provided.' }}</p>
                        <small class="text-gray-500">
                            By {{ $review->user->name }} • {{ $review->created_at->diffForHumans() }}
                        </small>
                    </div>
                @empty
                    <p class="text-gray-500">No reviews yet. Be the first to review!</p>
                @endforelse
            </div>

            {{-- Add Review Form --}}
            <div id="review-form" class="bg-gray-50 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Add Your Review</h3>

                <form action="{{ route('reviews.create') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                {{-- Rating --}}
                <div class="block">
                <span class="text-gray-700">Rating</span>
            <div class="flex space-x-1 mt-1">
             @for($i = 1; $i <= 5; $i++)
                    <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" class="hidden peer">
                    <label for="star{{ $i }}" 
                class="cursor-pointer text-2xl text-gray-300 
                peer-checked:text-yellow-400
                hover:text-yellow-400">
                ★
            </label>
              @endfor
            </div>
            </div>




                    {{-- Comment --}}
                    <label class="block">
                        <span class="text-gray-700">Comment</span>
                        <textarea name="comment" rows="3" class="w-full border-gray-300 rounded-lg mt-1"></textarea>
                    </label>

                    {{-- Submit --}}
                    <button type="submit" 
                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">
                        Submit Review
                    </button>
                </form>
            </div>

        </div>
    </main>
</div>
@endsection
