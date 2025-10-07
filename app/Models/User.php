<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'phone',
        'date_of_birth',
        'gender',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'terms',
        'privacy',
        'email_verified_at',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'terms' => 'boolean',
            'privacy' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'remember_token' => 'string',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function defaultAddress()
    {
        return $this->hasOne(Address::class)->where('is_default', true);
    }

    public function loyaltyPoints()
    {
        return $this->hasOne(LoyaltyPoint::class);
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function getOrCreateLoyaltyPoints()
    {
        return $this->loyaltyPoints()->firstOrCreate([
            'user_id' => $this->id,
        ], [
            'points' => 0,
            'lifetime_points' => 0,
            'tier' => 'bronze',
        ]);
    }
}
