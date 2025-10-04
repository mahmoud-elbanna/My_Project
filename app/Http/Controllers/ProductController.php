<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    // عرض كل المنتجات
    public function index()
    {
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
    }

   
    // تخزين منتج جديد (لو محتاجه بعدين)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

     public function show(Product $product)
       {
        // Eager load reviews + user
        $product->load(['reviews.user']);

        return view('products.show', compact('product'));
       }
}
