<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * عرض كل الطلبات مع بيانات اليوزر والفورم كاملة.
     */
    public function index()
    {
        $orders = Order::with(['user', 'product'])->get(); // جلب كل بيانات اليوزر والمنتج
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * تعديل حالة الطلب مباشرة من الادمن.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,review,confirmed,shipped,delivered',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}
