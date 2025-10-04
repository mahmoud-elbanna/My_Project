<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Admin</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f5f6fa;
        }
        .sidebar {
            width: 220px;
            background: #fff;
            padding: 20px;
            min-height: 100vh;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar a {
            display: block;
            padding: 10px 15px;
            margin-bottom: 5px;
            border-radius: 8px;
            text-decoration: none;
            color: #333;
            transition: 0.2s;
        }
        .sidebar a.active, .sidebar a:hover {
            background: #3490dc;
            color: white;
        }
        .content {
            flex: 1;
            padding: 30px;
        }
        .card {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            color: white;
            background: #3490dc;
            transition: 0.2s;
        }
        button:hover {
            background: #2779bd;
        }
        .flex-container {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }
        .btn-cancel {
            background: #aaa;
        }
        .btn-cancel:hover {
            background: #888;
        }
    </style>
</head>
<body>
<div style="display: flex;">

    {{-- Sidebar --}}
    <div class="sidebar">
        <h2 style="font-weight:bold;margin-bottom:20px;">Admin Panel</h2>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">📦 Products</a>
        <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">⭐ Reviews</a>
        <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">📝 Orders</a>
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">👤 Users</a>
        <form action="{{ route('admin.logout') }}" method="POST" style="margin-top:20px;">
            @csrf
            <button type="submit" style="width:100%; background:#e3342f;">🔒 Logout</button>
        </form>
    </div>

    {{-- Content --}}
    <div class="content">
        <div class="card">
            <h1 style="margin-bottom:20px;">Edit Product</h1>

            {{-- رسائل نجاح / خطأ --}}
            @if(session('success'))
                <div style="background:#d4edda; color:#155724; padding:10px; border-radius:8px; margin-bottom:10px;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background:#f8d7da; color:#721c24; padding:10px; border-radius:8px; margin-bottom:10px;">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div style="margin-bottom:10px;">
                    <input type="text" name="name" placeholder="Product Name" value="{{ old('name', $product->name) }}" required>
                </div>

                <div style="margin-bottom:10px;">
                    <textarea name="description" placeholder="Description">{{ old('description', $product->description) }}</textarea>
                </div>

                <div style="margin-bottom:10px;">
                    <input type="number" name="price" placeholder="Price" value="{{ old('price', $product->price) }}" step="0.01" required>
                </div>

                <div style="margin-bottom:10px;">
                    <input type="text" name="image" placeholder="Image URL" value="{{ old('image', $product->image) }}">
                </div>

                <div class="flex-container">
                    <button type="submit">Update Product</button>
                    <a href="{{ route('admin.products.index') }}" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
