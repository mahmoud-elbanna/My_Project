<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyPoint extends Model
{
    protected $fillable = [
        'user_id',
        'points',
        'lifetime_points',
        'tier',
    ];

    protected $casts = [
        'points' => 'integer',
        'lifetime_points' => 'integer',
    ];

    const TIERS = [
        'bronze' => ['min' => 0, 'max' => 999],
        'silver' => ['min' => 1000, 'max' => 4999],
        'gold' => ['min' => 5000, 'max' => 9999],
        'platinum' => ['min' => 10000, 'max' => PHP_INT_MAX],
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(LoyaltyTransaction::class, 'user_id', 'user_id');
    }

    public function addPoints($points, $orderId = null, $description = null)
    {
        $this->increment('points', $points);
        $this->increment('lifetime_points', $points);
        $this->updateTier();

        LoyaltyTransaction::create([
            'user_id' => $this->user_id,
            'order_id' => $orderId,
            'points' => $points,
            'type' => 'earned',
            'description' => $description ?? "Earned {$points} points",
        ]);
    }

    public function redeemPoints($points, $description = null)
    {
        if ($this->points < $points) {
            return false;
        }

        $this->decrement('points', $points);

        LoyaltyTransaction::create([
            'user_id' => $this->user_id,
            'points' => -$points,
            'type' => 'redeemed',
            'description' => $description ?? "Redeemed {$points} points",
        ]);

        return true;
    }

    protected function updateTier()
    {
        $lifetimePoints = $this->lifetime_points;

        foreach (self::TIERS as $tier => $range) {
            if ($lifetimePoints >= $range['min'] && $lifetimePoints <= $range['max']) {
                $this->tier = $tier;
                $this->save();
                break;
            }
        }
    }
}
