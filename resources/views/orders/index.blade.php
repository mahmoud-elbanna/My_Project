@extends('layouts.app')
@section('title', 'My Orders')

@section('content')
<div class="flex min-h-screen bg-gray-100">

    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Main Content --}}
    <main class="flex-1 p-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">My Orders</h1>

        {{-- Success Message --}}
        @if(session('success'))
            <div id="flash-message" class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if($errors->any())
            <div id="flash-error" class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Product</th>
                    <th class="py-3 px-6 text-left">Quantity</th>
                    <th class="py-3 px-6 text-left">Date</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($orders as $order)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $order->product->name ?? 'N/A' }}</td>
                        <td class="py-3 px-6">{{ $order->quantity }}</td>
                        <td class="py-3 px-6">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="py-3 px-6">
                            @php
                                $statusClasses = [
                                    App\Models\Order::STATUS_PENDING   => 'bg-yellow-100 text-yellow-700',
                                    App\Models\Order::STATUS_REVIEW    => 'bg-blue-100 text-blue-700',
                                    App\Models\Order::STATUS_CONFIRMED => 'bg-purple-100 text-purple-700',
                                    App\Models\Order::STATUS_SHIPPED   => 'bg-orange-100 text-orange-700',
                                    App\Models\Order::STATUS_DELIVERED => 'bg-green-100 text-green-700',
                                    App\Models\Order::STATUS_CANCELED  => 'bg-red-100 text-red-700',
                                ];
                            @endphp

                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-6">
                            @if($order->isPending())
                                {{-- زرار يكمل الطلب ويفتح المودال --}}
                                <button onclick="openCheckoutModal({{ $order->id }})"
                                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded-lg transition">
                                    Complete Order
                                </button>
                            @elseif($order->isReview())
                                {{-- زرار إلغاء الطلب --}}
                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                        class="bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded-lg transition">
                                        Cancel Order
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif

                            {{-- زرار Track Order يظهر من أول Pending لحد قبل Canceled --}}
                            @if(!$order->isCanceled())
                                <a href="{{ route('orders.track', $order->id) }}" 
                                   class="ml-2 bg-indigo-500 hover:bg-indigo-600 text-white text-sm px-4 py-2 rounded-lg transition inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13M9 5v6m0 0H3m6 0h6" />
                                    </svg>
                                    Track Order
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</div>

{{-- Order Modal (بتاع Order Now) --}}
@include('components.order-modal')

{{-- Checkout Modal (بتاع إتمام الشراء) --}}
@include('components.checkout-modal')

{{-- Auto-hide flash messages + Modal control --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const flashMessage = document.getElementById('flash-message');
        const flashError = document.getElementById('flash-error');

        [flashMessage, flashError].forEach(msg => {
            if (msg) {
                setTimeout(() => {
                    msg.style.transition = "opacity 0.5s ease";
                    msg.style.opacity = "0";
                    setTimeout(() => msg.remove(), 500);
                }, 3000);
            }
        });
    });

    function openCheckoutModal(orderId) {
        document.getElementById('checkoutOrderId').value = orderId;
        const modal = document.getElementById('checkoutModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeCheckoutModal() {
        const modal = document.getElementById('checkoutModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>
@endsection
