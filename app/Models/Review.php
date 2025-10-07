<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
        'is_verified_purchase',
        'is_approved',
        'helpful_count',
        'unhelpful_count',
        'images',
    ];

    protected $casts = [
        'is_verified_purchase' => 'boolean',
        'is_approved' => 'boolean',
        'images' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function votes()
    {
        return $this->hasMany(ReviewVote::class);
    }

    public function markAsHelpful($userId)
    {
        $vote = $this->votes()->updateOrCreate(
            ['user_id' => $userId],
            ['is_helpful' => true]
        );

        if ($vote->wasRecentlyCreated || $vote->wasChanged()) {
            $this->recalculateVotes();
        }
    }

    public function markAsUnhelpful($userId)
    {
        $vote = $this->votes()->updateOrCreate(
            ['user_id' => $userId],
            ['is_helpful' => false]
        );

        if ($vote->wasRecentlyCreated || $vote->wasChanged()) {
            $this->recalculateVotes();
        }
    }

    protected function recalculateVotes()
    {
        $this->helpful_count = $this->votes()->where('is_helpful', true)->count();
        $this->unhelpful_count = $this->votes()->where('is_helpful', false)->count();
        $this->save();
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeVerifiedPurchase($query)
    {
        return $query->where('is_verified_purchase', true);
    }
}
