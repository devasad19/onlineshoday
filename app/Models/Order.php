<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Point;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

   

protected $fillable = [

    'user_id',

    'customer_id',

    'rider_id',

    'order_code',

    'package_id',

    'total_amount',

    'delivery_charge',

    'delivery_charge_details',

    'payment_method',

    'delivery_address',

    'status',
        'type',

    'delivery_time',

    'delivered_at',

    'delivery_at',

    'delivered_status',

    'notes',

];





    protected $casts = [
        'delivery_charge_details' => 'array',
        'delivery_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

 
public function package()
{
    return $this->belongsTo(Package::class);
}

public function referralCustomer()
{
    return $this->belongsTo(User::class, 'referral_customer_id');
}

    public function customProducts()
{
    return $this->hasMany(CustomProduct::class, 'order_id');
}

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
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function custom_products()
    {
        return $this->hasMany(CustomProduct::class);
    }


public function customer()
{
    return $this->belongsTo(User::class, 'customer_id');
}

private function grantPackageOrderPoints(Order $order)
{


    /*
    |--------------------------------------------------------------------------
    | Only Package Orders
    |--------------------------------------------------------------------------
    */

    if (!$order->package_id) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Already granted
    |--------------------------------------------------------------------------
    */

    $alreadyGranted = Point::where(
        'order_id',
        $order->id
    )
    ->where('type', 'earn')
    ->exists();


    if ($alreadyGranted) {
        return;
    }



    /*
    |--------------------------------------------------------------------------
    | Already granted?
    |--------------------------------------------------------------------------
    */

    $alreadyGranted = Point::where(
        'order_id',
        $order->id
    )
    ->where('type', 'earn')
    ->exists();


    if ($alreadyGranted) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Purchaser
    |--------------------------------------------------------------------------
    */

    $purchaser = $order->user;


    /*
    |--------------------------------------------------------------------------
    | Recipient
    |--------------------------------------------------------------------------
    */

    $customer = $order->customer;


    if (!$purchaser || !$customer) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Purchaser always gets 10 points
    |--------------------------------------------------------------------------
    */

    $purchaserPoints = 10;


    /*
    |--------------------------------------------------------------------------
    | Customer points
    |--------------------------------------------------------------------------
    |
    | নিজের জন্য হলে একই user.
    |
    | তাই নিজের ক্ষেত্রে double points দেওয়া হবে না।
    |
    */

    $customerPoints = 0;


    /*
    |--------------------------------------------------------------------------
    | Other Customer হলে
    |--------------------------------------------------------------------------
    */

    if ($customer->id != $purchaser->id) {

        /*
        |--------------------------------------------------------------------------
        | Direct referral নিশ্চিত করা
        |--------------------------------------------------------------------------
        */

        if ((int) $customer->referrer_id === (int) $purchaser->id) {

            /*
            |--------------------------------------------------------------------------
            | আগে qualifying order আছে কি?
            |--------------------------------------------------------------------------
            */

            $previousQualifyingOrder = Order::where(
                'customer_id',
                $customer->id
            )
            ->where('id', '<>', $order->id)
            ->whereIn('status', [
                'delivered',
                'completed',
            ])
            ->exists();


            /*
            |--------------------------------------------------------------------------
            | First = 10
            | Reorder = 5
            |--------------------------------------------------------------------------
            */

            $customerPoints =
                $previousQualifyingOrder
                    ? 5
                    : 10;
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Transaction
    |--------------------------------------------------------------------------
    */

    DB::transaction(function () use (
        $order,
        $purchaser,
        $customer,
        $purchaserPoints,
        $customerPoints
    ) {

        /*
        |--------------------------------------------------------------------------
        | Purchaser points
        |--------------------------------------------------------------------------
        */

        $purchaser->increment(
            'points',
            $purchaserPoints
        );


        Point::create([

            'user_id' => $purchaser->id,

            'order_id' => $order->id,

            'points' => $purchaserPoints,

            'type' => 'earn',

            'description' =>
                'Package order থেকে points',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Recipient points
        |--------------------------------------------------------------------------
        |
        | নিজের জন্য হলে customer == purchaser
        | তাই আবার points দেওয়া হবে না।
        |
        */

        if (
            $customerPoints > 0 &&
            $customer->id != $purchaser->id
        ) {

            $customer->increment(
                'points',
                $customerPoints
            );


            Point::create([

                'user_id' => $customer->id,

                'order_id' => $order->id,

                'points' => $customerPoints,

                'type' => 'earn',

                'description' =>
                    'Referral Customer package purchase থেকে points',

            ]);

        }

    });
}

 

}




