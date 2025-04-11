<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subtotal',
        'discount',
        'tax',
        'total',
        'name',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'zip',
        'payment_method',
        'payment_status',
        'transaction_id',
        'payment_details',
        'status',
        // Champs optionnels
        'locality',
        'landmark',
        'type',
        'is_shipping_different',
        'delivered_date',
        'canceled_date'
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
    
    protected $attributes = [
        'tax' => 0,
        'discount' => 0,
        'status' => 'ordered',
        'payment_status' => 'pending',
        'type' => 'home',
        'is_shipping_different' => 0,
        'locality' => '', // Valeur par défaut vide
        'landmark' => null // Valeur par défaut null
    ];

    
public function payment()
{
    return $this->hasOne(Payment::class);
}


}