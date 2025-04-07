<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'grand_total',
        'subtotal',
        'tax_amount',
        'shipping_amount',
        'coupon_code',
        'discount_amount',
        'payment_method',
        'payment_status',
        'payment_id',
        'notes',
        'shipping_name',
        'shipping_email',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_country',
        'billing_name',
        'billing_email',
        'billing_phone',
        'billing_address',
        'billing_city',
        'billing_country'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function generateOrderNumber()
    {
        return 'ORD-' . strtoupper(uniqid());
    }
}