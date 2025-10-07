<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'minimum_order',
        'usage_limit',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'minimum_order' => 'decimal:2',
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isValid($orderTotal = 0)
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->starts_at && Carbon::now()->isBefore($this->starts_at)) {
            return false;
        }

        if ($this->expires_at && Carbon::now()->isAfter($this->expires_at)) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        if ($this->minimum_order && $orderTotal < $this->minimum_order) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($orderTotal)
    {
        if ($this->type === 'fixed') {
            return min($this->value, $orderTotal);
        }

        return ($orderTotal * $this->value) / 100;
    }
}
