@extends('admin.layouts.app')
@section('title','Top Rated Products')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <h1 class="text-3xl font-bold mb-6">Top Rated Products</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($topProducts as $product)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden p-4">
                <div class="h-40 bg-gray-200 flex items-center justify-center">
                    @if($product->image)
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                    @else
                        <span class="text-gray-400">No Image</span>
                    @endif
                </div>
                <h2 class="text-lg font-semibold mt-2">{{ $product->name }}</h2>
                <p class="text-gray-600">${{ $product->price }}</p>
                <div class="flex justify-between mt-2">
                    <span class="text-yellow-500 font-bold">⭐ {{ number_format($product->average_rating ?? 0,1) }}</span>
                    <span class="text-gray-500 text-sm">{{ $product->reviews_count ?? 0 }} Reviews</span>
                </div>
            </div>
        @empty
            <p class="col-span-full text-gray-500 text-center">No top rated products found.</p>
        @endforelse
    </div>
</div>
@endsection
