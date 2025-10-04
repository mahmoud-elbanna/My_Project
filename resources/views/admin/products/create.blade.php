@extends('admin.layouts.app')
@section('title','Create Product')

@section('content')
<div class="min-h-screen bg-gray-100 p-6 flex justify-center items-start">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Add New Product</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf
            <div class="flex flex-col gap-4">
                <input type="text" name="name" placeholder="Product Name" class="p-2 border rounded" required>
                <textarea name="description" placeholder="Description" class="p-2 border rounded"></textarea>
                <input type="number" name="price" placeholder="Price" class="p-2 border rounded" step="0.01" required>
                <input type="text" name="image" placeholder="Image URL" class="p-2 border rounded">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Product</button>
            </div>
        </form>
    </div>
</div>
@endsection
