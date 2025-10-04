<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // نجيب أحدث بيانات من الداتا بيز
        $user = $request->user()->fresh();

        // نجيب كل المنتجات ومعاها الـ reviews لتفادي مشكلة N+1
        $products = Product::withAvg('reviews', 'rating')
        ->withCount('reviews')
        ->latest()
        ->get();


        // نرجع الـ view ومعاه اليوزر والبرودكتس
        return view('dashboard', compact('user', 'products'));
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->back()->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

