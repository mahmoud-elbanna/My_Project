@extends('layouts.app')
@section('title', 'Track Order')

@section('content')
<div class="flex min-h-screen bg-gray-100">

    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Main Content --}}
    <main class="flex-1 p-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Track Order #{{ $order->id }}</h1>

        {{-- Order Details --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <p><strong>Product:</strong> {{ $order->product->name ?? 'N/A' }}</p>
            <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>

            @php
                $statusClasses = [
                    \App\Models\Order::STATUS_PENDING   => 'bg-yellow-100 text-yellow-700',
                    \App\Models\Order::STATUS_REVIEW    => 'bg-blue-100 text-blue-700',
                    \App\Models\Order::STATUS_CONFIRMED => 'bg-purple-100 text-purple-700',
                    \App\Models\Order::STATUS_SHIPPED   => 'bg-orange-100 text-orange-700',
                    \App\Models\Order::STATUS_DELIVERED => 'bg-green-100 text-green-700',
                    \App\Models\Order::STATUS_CANCELED  => 'bg-red-100 text-red-700',
                ];
            @endphp

            <p>
                <strong>Status:</strong> 
                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ \App\Models\Order::STATUSES[$order->status] ?? ucfirst($order->status) }}
                </span>
            </p>
        </div>

        {{-- Progress Tracker --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Progress</h2>

            @php
                $steps = \App\Models\Order::STATUSES;
                // استبعد الـ canceled من الـprogress
                unset($steps[\App\Models\Order::STATUS_CANCELED]);

                $currentIndex = array_search($order->status, array_keys($steps));
            @endphp

            <div class="flex items-center justify-between">
                @foreach($steps as $key => $label)
                    <div class="flex-1 flex items-center">
                        <div class="relative flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center
                                @if(array_search($key, array_keys($steps)) <= $currentIndex)
                                    bg-green-500 text-white
                                @else
                                    bg-gray-300 text-gray-600
                                @endif">
                                {{ $loop->iteration }}
                            </div>
                            <span class="mt-2 text-sm font-medium">{{ $label }}</span>
                        </div>
                        @if(!$loop->last)
                            <div class="flex-1 h-1 mx-2
                                @if($loop->index < $currentIndex) bg-green-500 @else bg-gray-300 @endif">
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
@endsection
