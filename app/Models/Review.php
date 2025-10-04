<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'product_id', 'rating', 'comment'];

    // الريفيو بيتكتب بواسطة يوزر
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // الريفيو بيتعلق ببرودكت
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}