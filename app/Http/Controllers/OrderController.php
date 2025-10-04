<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\CompleteOrderRequest;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    /**
     * عرض كل الطلبات الخاصة باليوزر الحالي.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * إنشاء أوردر جديد (pending).
     */
    public function store(CreateOrderRequest $request)
    {
        $validated = $request->validated();

        $order = Order::create([
            'user_id'    => Auth::id(),
            'product_id' => $validated['product_id'],
            'quantity'   => $validated['quantity'],
            'status'     => Order::STATUS_PENDING,
        ]);

        return redirect()
            ->route('orders.index')
            ->with('success', "✅ Order #{$order->id} placed successfully!");
    }

    /**
     * إلغاء أوردر (مسموح فقط لو لسه pending أو review).
     */
    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('orders.index')
                ->with('error', '🚫 Unauthorized action.');
        }

        if (! $order->isPending() && ! $order->isReview()) {
            return redirect()->route('orders.index')
                ->with('error', '❌ Cannot cancel this order now.');
        }

         $order->update([
            'status' => Order::STATUS_PENDING
            
        ]);


        return redirect()->route('orders.index')
            ->with('success', "🛑 Order #{$order->id} cancelled successfully.");
    }

    /**
     * إتمام أوردر بشكل سريع (من pending إلى review).
     */
    public function complete(Order $order)
    {
        if ($order->user_id !== Auth::id() || ! $order->isPending()) {
            return redirect()->route('orders.index')
                ->with('error', '❌ You cannot complete this order.');
        }

        $order->update(['status' => Order::STATUS_REVIEW]);

        return redirect()->route('orders.index')
            ->with('success', "📦 Order #{$order->id} moved to Review stage.");
    }

    /**
     * إتمام أوردر مع بيانات checkout كاملة.
     */
    public function completeWithDetails(CompleteOrderRequest $request)
    {
        $validated = $request->validated();

        $order = Order::findOrFail($validated['order_id']);

        if ($order->user_id !== Auth::id() || ! $order->isPending()) {
            return redirect()->route('orders.index')
                ->with('error', '❌ You cannot complete this order.');
        }

        $order->update([
            'status'         => Order::STATUS_REVIEW,
            'full_name'      => $validated['full_name'],
            'phone'          => $validated['phone'],
            'address'        => $validated['address'],
            'payment_method' => $validated['payment_method'],
            'total_price'    => $order->product->price * $order->quantity,
        ]);

        return redirect()->route('orders.index')
            ->with('success', "✅ Order #{$order->id} checkout completed and moved to Review stage.");
    }
    /**
     * تتبع حالة الطلب.
     */
    public function track(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('orders.index')
                ->with('error', '🚫 Unauthorized action.');
        }

        return view('orders.track', compact('order'));
    }
}