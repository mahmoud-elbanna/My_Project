@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <h1 class="text-3xl font-bold mb-6">All Products</h1>

    <div class="grid grid-cols-3 gap-6">
        @foreach($products as $product)
            <div class="bg-white shadow rounded-lg p-4">
                <h3 class="text-xl font-semibold">{{ $product->name }}</h3>
                <p class="text-gray-600">{{ Str::limit($product->description, 50) }}</p>
                <p class="text-green-600 font-bold mt-2">${{ $product->price }}</p>
                <a href="{{ route('products.show', $product->id) }}" 
                   class="inline-block mt-3 text-blue-500 hover:underline">View</a>
            </div>
        @endforeach
    </div>
@endsection
