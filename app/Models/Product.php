<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bazar_id',
        'category_id',
        'price',
        'unit',
        'image',
        'description',
        'available',
        'status',
    ];


protected $casts = [
    'price_updated_at' => 'datetime',
];



    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bazar()
    {
        return $this->belongsTo(Bazar::class);
    }
    
    // User model
    public function riderProducts()
    {
        return $this->hasOne(RiderProduct::class, 'product_id');
    }

 
    



}

