<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
        'name' => 'Laptop X1',
        'description' => 'High performance laptop for work and gaming',
        'price' => 1500.00,
        'image' => 'https://via.placeholder.com/300x200.png?text=Laptop+X1',
    ]);

    Product::create([
        'name' => 'Smartphone Pro',
        'description' => 'Latest smartphone with powerful features',
        'price' => 999.99,
        'image' => 'https://via.placeholder.com/300x200.png?text=Smartphone+Pro',
    ]);

    Product::create([
        'name' => 'Wireless Headphones',
        'description' => 'Noise-cancelling over-ear headphones',
        'price' => 199.99,
        'image' => 'https://via.placeholder.com/300x200.png?text=Headphones',
    ]);
    }
}
