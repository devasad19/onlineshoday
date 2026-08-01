<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rider_id',
        'order_code',
        'total_amount',
        'payment_method',
        'delivery_address',
        'status',
        'delivery_time',
        'delivered_at',
        'delivery_at',
        'delivered_status',
        'notes',
    ];

// app/Models/Order.php

    protected $casts = [
        'delivered_at' => 'datetime',
    ];

     public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function rider()
    {
        return $this->belongsTo(User::class);
    }

     public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function custom_products()
    {
        return $this->hasMany(CustomProduct::class);
    }








}




