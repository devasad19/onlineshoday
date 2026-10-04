<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryChargeRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_type',
        'min_quantity',
        'max_quantity',
        'charge',
        'status',
    ];

    protected $casts = [
        'min_quantity' => 'decimal:2',
        'max_quantity' => 'decimal:2',
        'charge' => 'decimal:2',
        'status' => 'boolean',
    ];
}