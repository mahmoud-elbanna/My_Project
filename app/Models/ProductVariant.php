<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'size',
        'price',
        'stock',
        'sku',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function isInStock()
    {
        return $this->stock > 0;
    }

    public function decrementStock($quantity = 1)
    {
        $this->decrement('stock', $quantity);
    }

    public function incrementStock($quantity = 1)
    {
        $this->increment('stock', $quantity);
    }
}
