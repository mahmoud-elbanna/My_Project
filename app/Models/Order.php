<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_PENDING   = 'pending';
    const STATUS_REVIEW    = 'review';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_SHIPPED   = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELED  = 'canceled';

    public const STATUSES = [
        self::STATUS_PENDING   => 'Pending',
        self::STATUS_REVIEW    => 'Review',
        self::STATUS_CONFIRMED => 'Confirmed',
        self::STATUS_SHIPPED   => 'Shipped',
        self::STATUS_DELIVERED => 'Delivered',
        self::STATUS_CANCELED  => 'Canceled',
    ];

    protected $fillable = [
        'user_id',
        'product_id',
        'coupon_id',
        'quantity',
        'status',
        'full_name',
        'phone',
        'address',
        'payment_method',
        'total_price',
        'discount_amount',
        'subtotal',
        'tracking_number',
    ];

    protected $casts = [
        'status' => 'string',
        'total_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function loyaltyTransactions()
    {
        return $this->hasMany(LoyaltyTransaction::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeReview($query)
    {
        return $query->where('status', self::STATUS_REVIEW);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    public function scopeShipped($query)
    {
        return $query->where('status', self::STATUS_SHIPPED);
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', self::STATUS_DELIVERED);
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isReview(): bool
    {
        return $this->status === self::STATUS_REVIEW;
    }

    public function isCanceled(): bool
    {
        return $this->status === self::STATUS_CANCELED;
    }

    public function isConfirmed(): bool
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    public function isShipped(): bool
    {
        return $this->status === self::STATUS_SHIPPED;
    }

    public function isDelivered(): bool
    {
        return $this->status === self::STATUS_DELIVERED;
    }
}
