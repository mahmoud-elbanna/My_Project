<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class AdminDashboardController extends Controller
{
    // عرض جميع المنتجات
    public function index()
    {
        // جلب المنتجات مع الـ reviews، متوسط التقييم وعدد الـ reviews
        $products = Product::with('reviews')
         
        ->withAvg('reviews','rating')
        ->withCount('reviews')
        ->get();

    return view('admin.dashboard', ['products' => $products]);

    }

    // إنشاء منتج جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string',
        ]);

        Product::create($request->all());

        return redirect()->back()->with('success', 'Product added successfully.');
    }

    // تعديل المنتج
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string',
        ]);

        $product->update($request->all());

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    // حذف المنتج
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
