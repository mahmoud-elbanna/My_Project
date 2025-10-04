<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // الحالات الخاصة بالـ order
    const STATUS_PENDING   = 'pending';
    const STATUS_REVIEW    = 'review';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_SHIPPED   = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELED  = 'canceled'; // حالة جديدة للأوردر الملغى

    // Array فيه كل الـ statuses
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
        'quantity',
        'status',
        'full_name',
        'phone',
        'address',
        'payment_method',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // -------- العلاقات -------- //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // -------- Scopes -------- //
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

    // -------- Accessors -------- //
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
