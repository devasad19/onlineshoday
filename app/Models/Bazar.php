<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bazar extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status'];


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function riders()
    {
        return $this->hasMany(User::class);
    }

    public function areas()
    {
        return $this->hasMany(BazarArea::class);
    }






}
