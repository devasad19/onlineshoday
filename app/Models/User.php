<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'father_name',
        'phone',
        'father_phone',
        'address',
        'photo',
        'bazar_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function rider(){
        return $this->hasOne(Rider::class);
    }

    public function bazar(){
        return $this->belongsTo(Bazar::class);
    }

    // User model
    public function riderProducts()
    {
        return $this->hasMany(RiderProduct::class, 'rider_id');
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,        // Final model
            RiderProduct::class,   // Intermediate model
            'user_id',            // Foreign key on RiderProduct
            'id',                  // Foreign key on Product table
            'id',                  // Local key on User
            'product_id'           // Local key on RiderProduct
        );
    }


}
