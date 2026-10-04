<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\CartItem;
use DB;
use Auth;


class UserDashboardController extends Controller
{

    public function userDashboard()
    {
        $userId = auth()->id();

        // Total Orders
        $totalOrders = Order::where('user_id', $userId)->count();

        // Pending Orders
        $pendingOrders = Order::where('user_id', $userId)->where('status', 'pending')->count();

        // Completed Orders
        $completedOrders = Order::where('user_id', $userId)->where('status', 'delivered')->count();

        // Recent Orders
        $recentOrders = Order::with(['items'])
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('backend.user-dashboard.index', compact(
            'totalOrders', 'pendingOrders', 'completedOrders', 'recentOrders'
        ));
    }



    public function myOrders()
    {
        $data['orders'] = Order::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->with([
                'user',
                'customer',
                'rider',
                'custom_products',
                'items.product',
                'package.items.product',
            ])
            ->get();
 

        return view('backend.user-dashboard.my_orders', $data);
    }

    public function mySettings(){
        
        return view('backend.user-dashboard.my_settings');
    }

    public function myCart_old(){
        
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'অর্ডার দিতে হলে আগে লগইন করুন!');
        }

        $user = Auth::user();
        // ✅ ডাটাবেস থেকে কার্ট আইটেম আনা
        $cartItems = CartItem::with(['user', 'product'])
            ->where('user_id', $user->id)
            ->get();
         

        $total = collect($cartItems)->sum(function($item){
            return $item['price'] * $item['quantity'];
        });

        return view('backend.user-dashboard.my_cart', compact('cartItems', 'user', 'total'));
    }

    
public function myCart()
{

    if (!auth()->check()) {
        session(['url.intended' => url()->current()]);
        return redirect('/login');
    }


    $user = Auth::user();
    // ✅ ডাটাবেস থেকে কার্ট আইটেম আনা
 

    $cartItems = auth()->check()
        ? CartItem::where('user_id', auth()->id())->with(['user', 'product'])->get()
        : collect(session()->get('cart', []));
    
    $extraProducts = [];
    $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

    return view('backend.user-dashboard.my_cart', compact('cartItems', 'total', 'user', 'extraProducts'));
}

 

public function details(Request $request)
{
    $request->validate([
        'id' => 'required|integer',
    ]);

    $order = Order::with([
        'user',
        'items.product'
    ])->findOrFail($request->id);


    /*
    |--------------------------------------------------------------------------
    | Security
    |--------------------------------------------------------------------------
    | User যেন অন্য User-এর order দেখতে না পারে।
    | আপনার order structure অনুযায়ী user_id = purchaser.
    |--------------------------------------------------------------------------
    */

    if ((int) $order->user_id !== (int) Auth::id()) {
        return response()->json([
            'success' => false,
            'message' => 'এই অর্ডার দেখার অনুমতি আপনার নেই।'
        ], 403);
    }


    $items = $order->items->map(function ($item) {

        return [
            'id' => $item->id,

            'product_id' => $item->product_id,

            'product_name' => optional($item->product)->name ?? 'N/A',

            'product_image' => optional($item->product)->image
                ? url('uploads/products/' . $item->product->image)
                : null,

            'unit' => optional($item->product)->unit ?? '',

            'qty' => (float) $item->quantity,

            'price' => (float) $item->price,

            'rider_price' => (float) (
                $item->rider_price ?? $item->price
            ),
        ];
    });


    return response()->json([
        'success' => true,

        'order' => [
            'id' => $order->id,

            'order_code' => $order->order_code,

            'total_amount' => (float) $order->total_amount,

            'delivery_address' => $order->delivery_address,

            'status' => $order->status,

            'items' => $items,
        ]
    ]);
}



public function accept(Request $request)
{
    $request->validate([
        'id' => 'required|integer',

        'items' => 'nullable|array',

        'items.*.id' => 'required|integer',

        'items.*.price' => 'required|numeric|min:0',
    ]);


    $order = Order::with('items')
        ->findOrFail($request->id);


    /*
    |--------------------------------------------------------------------------
    | Security
    |--------------------------------------------------------------------------
    */

    if ((int) $order->user_id !== (int) Auth::id()) {

        return response()->json([
            'success' => false,
            'message' => 'এই অর্ডার গ্রহণ করার অনুমতি আপনার নেই।'
        ], 403);
    }


    /*
    |--------------------------------------------------------------------------
    | Which status can be accepted?
    |--------------------------------------------------------------------------
    |
    | pending
    |     -> User accepts normal order
    |
    | rider_modified_accepted
    |     -> Rider changed price, user accepts new price
    |
    */

    if (!in_array($order->status, [
        'pending',
        'rider_modified_accepted'
    ])) {

        return response()->json([
            'success' => false,
            'message' => 'এই অর্ডারটি এখন গ্রহণ করা যাবে না।'
        ], 400);
    }


    DB::beginTransaction();

    try {

        /*
        |--------------------------------------------------------------------------
        | Rider modified price accept
        |--------------------------------------------------------------------------
        */

        if (
            $order->status === 'rider_modified_accepted'
            && $request->has('items')
        ) {

            $total = 0;


            foreach ($request->items as $data) {

                $item = $order->items
                    ->where('id', $data['id'])
                    ->first();


                if (!$item) {
                    continue;
                }


                $acceptedPrice = (float) $data['price'];


                /*
                | User যে price accept করেছে
                | সেটাই final price হবে।
                */

                $item->price = $acceptedPrice;

                $item->rider_price = $acceptedPrice;

                $item->save();


                $total += $acceptedPrice * (float) $item->quantity;
            }


            /*
            | যদি items পাঠানো হয় তাহলে নতুন total।
            */

            if ($total > 0) {
                $order->total_amount = $total;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Final status
        |--------------------------------------------------------------------------
        */

        $order->status = 'accepted';

        $order->save();


        DB::commit();


        return response()->json([
            'success' => true,

            'message' => 'অর্ডার সফলভাবে গ্রহণ করা হয়েছে।',

            'order' => [
                'id' => $order->id,

                'total_amount' => (float) $order->total_amount,

                'status' => $order->status,
            ]
        ]);


    } catch (\Throwable $e) {

        DB::rollBack();


        return response()->json([
            'success' => false,

            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}



public function orderCancell(Request $request)
{
    $request->validate([
        'id' => 'required|integer',
    ]);


    $order = Order::findOrFail($request->id);


    /*
    |--------------------------------------------------------------------------
    | Security
    |--------------------------------------------------------------------------
    */

    if ((int) $order->user_id !== (int) Auth::id()) {

        return response()->json([
            'success' => false,
            'message' => 'এই অর্ডার বাতিল করার অনুমতি আপনার নেই।'
        ], 403);
    }


    /*
    |--------------------------------------------------------------------------
    | User can cancel only when rider modified price
    |--------------------------------------------------------------------------
    */

    if ($order->status !== 'rider_modified_accepted') {

        return response()->json([
            'success' => false,
            'message' => 'এই অর্ডারটি এখন বাতিল করা যাচ্ছে না।'
        ], 400);
    }


    DB::beginTransaction();

    try {

        $order->status = 'cancelled';

        $order->save();


        DB::commit();


        return response()->json([
            'success' => true,

            'message' => 'অর্ডার সফলভাবে বাতিল করা হয়েছে।',

            'order' => [
                'id' => $order->id,

                'total_amount' => (float) $order->total_amount,

                'status' => $order->status,
            ]
        ]);


    } catch (\Throwable $e) {

        DB::rollBack();


        return response()->json([
            'success' => false,

            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}
 






}
