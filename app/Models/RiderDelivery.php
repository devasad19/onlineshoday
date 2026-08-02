<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderDelivery extends Model
{
    protected $fillable=[
        'rider_id',
        'order_id',
        'status',
        'delivery_status',
        'late_time',
        'delivered_at'
    ];

    public function rider()
    {
        return $this->belongsTo(User::class,'rider_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}