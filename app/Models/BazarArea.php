<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BazarArea extends Model
{
    use HasFactory;

    protected $fillable = ['bazar_id', 'name'];

    

    public function bazar()
    {
        return $this->belongsTo(Bazar::class);
    }







}
