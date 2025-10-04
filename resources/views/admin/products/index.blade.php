@extends('admin.layouts.app')
@section('title','All Products')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <h1 class="text-3xl font-bold mb-6">All Products</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
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
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="col-span-full text-gray-500 text-center">No products found.</p>
        @endforelse
    </div>
</div>
@endsection
