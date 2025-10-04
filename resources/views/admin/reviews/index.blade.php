@extends('admin.layouts.app')
@section('title', 'Reviews')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">All Reviews</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="min-w-full border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">User</th>
                <th class="py-2 px-4 border-b">Product</th>
                <th class="py-2 px-4 border-b">Rating</th>
                <th class="py-2 px-4 border-b">Review</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reviews as $review)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $review->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $review->user->name ?? 'Guest' }}</td>
                    <td class="py-2 px-4 border-b">{{ $review->product->name }}</td>
                    <td class="py-2 px-4 border-b text-yellow-500 font-bold">{{ $review->rating }}/5</td>
                    <td class="py-2 px-4 border-b">{{ $review->comment }}</td>
                    <td class="py-2 px-4 border-b">
                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:underline" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-4 px-4 text-center text-gray-500">No reviews found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
