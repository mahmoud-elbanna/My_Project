<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'image'];

    // العلاقة مع Orders (لو محتاج)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // العلاقة مع Reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // متوسط التقييم (لو مش جاي من withAvg)
    public function getAverageRatingAttribute()
    {
        return $this->reviews_avg_rating ?? $this->reviews()->avg('rating') ?? 0;
    }

    // عدد الريفيوز (لو مش جاي من withCount)
    public function getReviewsCountAttribute()
    {
        return $this->reviews_count ?? $this->reviews()->count();
    }
}
