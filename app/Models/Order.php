<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'subtotal', 'discount', 'tax', 'total',
        'name', 'phone', 'locality', 'address', 'city', 'state',
        'country', 'landmark', 'zip', 'type', 'status',
        'is_shipping_different', 'delivered_date', 'canceled_date',
        'transaction_id', 'payment_method', 'payment_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}