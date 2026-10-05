<?php
// app/Http/Controllers/Admin/RiderController.php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rider;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use App\Models\Product;
use App\Models\Bazar;
use App\Models\OrderItem;
use App\Models\CustomProduct;
use App\Models\RiderProduct;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;
use Carbon\Carbon;
use App\Models\RiderDelivery;
 

class RiderController extends Controller
{

    public function riderDashboard()
    {
        $rider = auth()->user()->rider;
        $user_id = auth()->user()->id;

        $data['rider'] = $rider;
 
        // Rider Recent Orders
        $data['recentOrders'] = Order::where('rider_id', $user_id)
            ->latest()
            ->take(5)
            ->get();
 
        // Pending Orders (যেগুলো Rider নিতে পারবে)
        $data['orders'] = Order::where('status', 'pending')
            ->latest()
            ->get();

        // Dashboard Stats
        $data['totalDelivered'] = RiderDelivery::where('rider_id', $user_id)
            ->where('status', 'delivered')
            ->count();

        $data['onTimeDelivery'] = RiderDelivery::where('rider_id', $user_id)
            ->where('delivery_status', 'on_time')
            ->count();

        $data['pendingOrders'] = Order::where('rider_id', $user_id)
            ->whereIn('status', ['accepted', 'rider_modified_accepted'])
            ->count();

        $data['cancelDelivery'] = RiderDelivery::where('rider_id', $user_id)
            ->where('status', 'cancelled')
            ->count();

        $data['lateDelivery'] = RiderDelivery::where('rider_id', $user_id)
            ->where('delivery_status', 'late')
            ->count();

        $data['totalLateMinutes'] = RiderDelivery::where('rider_id', $user_id)
            ->sum('late_time');


            
        return view('backend.riders.index', $data);
    }


    public function riderProducts()
    {
        $data['riders'] = Rider::orderBy('id', 'desc')->get();
        
        $data['products'] = Product::all();
        $data['riderProducts'] = RiderProduct::with('product')
        ->where('user_id', auth()->id())
        ->get();
        
        return view('backend.riders.my_products', $data);
    }



 

public function riderProductStore(Request $request)
{

    if(auth()->user()->rider == null){
        return response()->json(['message' => 'রাইডারের প্রোফাইল পূরন করেন।']);
    }


    RiderProduct::updateOrCreate(
        [
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
        ],
        ['price' => $request->price]
    );

    return response()->json(['message' => 'পণ্যটি সফলভাবে যোগ হয়েছে!']);
}

public function productdestroy($id)
{
    RiderProduct::where('id', $id)->where('user_id', auth()->id())->delete();
    return response()->json(['message' => 'পণ্যটি মুছে ফেলা হয়েছে!']);
}


 

    public function index()
    {
        $riders = Rider::orderBy('id', 'desc')->get();
        return view('backend.pages.riders.index', compact('riders'));
    }


    public function riderRegForm()
    {
        
        $data['bazars'] = Bazar::where('status', 'Active')->get();
        return view('rider_register', $data);
    }

    /**
     * Rider Registration Data সংরক্ষণ
     */
    public function riderStore(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:100',
            'father_name'       => 'required|string|max:100',
            'age'               => 'required|integer|min:18|max:70',
            'edu_qualification' => 'required|string',
            'institute'         => 'nullable|string|max:255',
            'phone'             => 'required|string|max:15',
            'father_phone'      => 'required|string|max:15',
            'address'           => 'required|string|max:500',
            'vehicle_type'      => 'required|string',
            'nid_image'         => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'photo'             => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // === File Upload ===
        $nidPath = null;
        $photoPath = null;

        if ($request->hasFile('nid_image')) {
            $nidPath = fileUpload($request->file('nid_image'), 'uploads/riders/nid');
        }

        if ($request->hasFile('photo')) {
            $photoPath = fileUpload($request->file('photo'), 'uploads/riders');
        }



        $role = Role::where('name', 'rider')->first();

        // ✅ Create user record
       $user =  User::create([
            'role_id'       => $role? $role->id: 3,
            'name'              => $request->name,
            'father_name'       => $request->father_name,
            'phone'             => $request->phone,
            'father_phone'      => $request->father_phone,
            'address'           => $request->address,
            'photo'             => $photoPath,
            'bazar_id'      => $request->bazar_id,
            'password'      => Hash::make($request->password), 
        ]);

        // === Save to Database ===
        Rider::create([
            'user_id'              =>  $user? $user->id: '',
            'name'              => $request->name,
            'age'               => $request->age,
            'edu_qualification' => $request->edu_qualification,
            'institute'         => $request->institute,
            'vehicle_type'      => $request->vehicle_type,
            'nid_image'         => $nidPath,
            'available'            => 1,
            'status'            => 'active',
        ]);



        return redirect()->back()->with('success', '✅ রাইডার রেজিস্ট্রেশন সফলভাবে সম্পন্ন হয়েছে!');
    }

 

    public function destroy($id)
    {
        $rider = Rider::findOrFail($id);
        $rider->delete();

        return response()->json(['success' => true, 'message' => 'Rider deleted successfully']);
    }


    public function markAsDelivered($id)
    {
        $order = Order::where('rider_id', auth()->id())
            ->where('id', $id)
            ->where('status', 'accepted')
            ->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'অর্ডার পাওয়া যায়নি বা ইতিমধ্যে সম্পন্ন হয়েছে।'], 404);
        }

    

        $order->status='delivered';
        $order->delivered_at=Carbon::now('Asia/Dhaka');
        $lateTime=0;

        if($order->delivery_at){
            $now=Carbon::now('Asia/Dhaka');
            if($now->lessThanOrEqualTo($order->delivery_at)){
                $order->delivered_status='on_time';
            }else{
                $order->delivered_status='late';
                $lateTime=$order->delivery_at->diffInMinutes($now);
            }
        }

        $order->save();

        RiderDelivery::create([
            'rider_id'=>$order->rider_id,
            'order_id'=>$order->id,
            'status'=>'delivered',
            'delivery_status'=>$order->delivered_status,
            'late_time'=>$lateTime,
            'delivered_at'=>$order->delivered_at
        ]);



        return response()->json([
            'success' => true,
            'message' => '✅ অর্ডার সফলভাবে সম্পন্ন হয়েছে!',
            'order_id' => $id,
            'delivered_status' => $order->delivered_status,
        ]);
    }


    // ✅ Show Order Board Page
public function riderOrders(Request $request)
{
    $orders = Order::with([
    'user',
    'customer',
    'items.product',
    'package.items.product',
        'custom_products',
        'rider'
])
    ->where('rider_id', auth()->id())
    ->whereIn('status', [
        'accepted',
        'rider_modified_accepted',
        'delivered'
    ]);

    // Date

    if($request->date_filter=="today"){

        $orders->whereDate('created_at', today());

    }
    elseif($request->date_filter=="yesterday"){

        $orders->whereDate('created_at', today()->subDay());

    }
    elseif(
        $request->date_filter=="range" &&
        $request->from_date &&
        $request->to_date
    ){

        $orders->whereBetween('created_at',[
            $request->from_date.' 00:00:00',
            $request->to_date.' 23:59:59'
        ]);

    }

    // Status

    if($request->filled('status')){

        $orders->where('status',$request->status);

    }

    // Search

    if($request->filled('search')){

        $search = $request->search;

        $orders->whereHas('user',function($q) use($search){

            $q->where('name','like',"%{$search}%")
              ->orWhere('phone','like',"%{$search}%");

        });

    }

$orders = $orders
    ->orderByRaw("
        CASE
            WHEN status IN ('accepted','rider_modified_accepted') THEN 0
            ELSE 1
        END
    ")
    ->orderByDesc('accepted_at')
    ->orderByDesc('created_at')
    ->get();

    return view(
        'backend.riders.rider_orders',
        compact('orders')
    );
}
   
 
public function pendingOrders()
{
    $orders = Order::with([
        'user',
        'custom_products',
        'customer',
        'items.product',
        'package.items.product',
    ])->where('status', 'pending')->latest()->get();

    // প্রতিটা product image কে full URL বানানো
    $orders->each(function ($order) {
        $order->items->each(function ($i) {
            $i->product->full_image = $i->product->image 
                ? asset('uploads/products/' . $i->product->image)
                : asset('default-product.png');
        });
    });

    return response()->json(['orders' => $orders]);
}

 public function acceptOrder(Request $request)
{
    $order = Order::with([
        'items',
        'package.items.product',
    ])->findOrFail($request->id);

    /*
    |--------------------------------------------------------------------------
    | Only these orders can be accepted
    |--------------------------------------------------------------------------
    */

    if (!in_array($order->status, [
        'pending',
        'rider_modified_accepted',
    ])) {

        return response()->json([
            'success' => false,
            'message' => 'এই অর্ডারটি এখন গ্রহণ করা যাবে না। বর্তমান status: ' . $order->status
        ], 400);
    }


    /*
    |--------------------------------------------------------------------------
    | Delivery Time
    |--------------------------------------------------------------------------
    */

    $request->validate([
        'delivery_time' => 'required|integer|min:1',
    ]);

    DB::beginTransaction();

    try {

        /*
        |--------------------------------------------------------------------------
        | Current Rider
        |--------------------------------------------------------------------------
        */

        $riderId = auth()->id();

        if (!$riderId) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Rider login পাওয়া যায়নি। আবার login করুন।'
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | PACKAGE ORDER
        |--------------------------------------------------------------------------
        */

        if (
            $order->type === 'package' ||
            !empty($order->package_id)
        ) {

            /*
            |--------------------------------------------------------------------------
            | Assign Rider
            |--------------------------------------------------------------------------
            */

            $order->rider_id = $riderId;

            /*
            |--------------------------------------------------------------------------
            | IMPORTANT:
            | Accept করার সময় status অবশ্যই accepted হবে
            |--------------------------------------------------------------------------
            */

            $order->status = 'accepted';

            $order->delivery_time = $request->delivery_time;

            $order->save();


            DB::commit();


            return response()->json([
                'success' => true,
                'message' => 'প্যাকেজ অর্ডার সফলভাবে গ্রহণ করা হয়েছে।',

                'order' => [
                    'id' => $order->id,
                    'rider_id' => $order->rider_id,
                    'total_amount' => (float) $order->total_amount,
                    'status' => $order->status,
                    'delivery_time' => $order->delivery_time,
                ]
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | NORMAL ORDER
        |--------------------------------------------------------------------------
        */

        $payload = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
            'items.*.price' => 'required|numeric|min:0',
        ]);


        $total = 0;


        foreach ($payload['items'] as $data) {

            $item = $order->items
                ->where('id', $data['id'])
                ->first();


            if (!$item) {
                continue;
            }


            $newPrice = (float) $data['price'];


            /*
            |--------------------------------------------------------------------------
            | Rider Price
            |--------------------------------------------------------------------------
            */

            if ($newPrice > (float) $item->price) {

                $item->rider_price = $newPrice;

                $item->save();
            }


            $finalPrice = (float) (
                $item->rider_price ??
                $item->price
            );


            $total +=
                $finalPrice *
                (float) $item->quantity;
        }


        /*
        |--------------------------------------------------------------------------
        | Update Normal Order
        |--------------------------------------------------------------------------
        */

        $order->rider_id = $riderId;

        $order->total_amount = $total;

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT:
        | Rider accept করলে accepted হবে
        |--------------------------------------------------------------------------
        */

        $order->status = 'accepted';

        $order->delivery_time = $request->delivery_time;

        $order->save();


        DB::commit();


        return response()->json([
            'success' => true,
            'message' => 'অর্ডার সফলভাবে গ্রহণ করা হয়েছে।',

            'order' => [
                'id' => $order->id,
                'rider_id' => $order->rider_id,
                'total_amount' => (float) $order->total_amount,
                'status' => $order->status,
                'delivery_time' => $order->delivery_time,
            ]
        ]);


    } catch (\Throwable $e) {

        DB::rollBack();

        \Log::error('Rider accept order error', [
            'order_id' => $request->id,
            'rider_id' => auth()->id(),
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ]);


        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage(),
        ], 500);
    }
}
 


public function pending()
{
    $rider = auth()->user()->rider;

    $orders = Order::with([
        'user',
        'customer',

        // Normal order
        'items.product',

        // Package order
        'package.items.product',
    ])
    ->where(function ($query) use ($rider) {

        $query->whereNull('type')
              ->orWhere('type', '!=', 'package');

    })
    ->orWhere(function ($query) use ($rider) {

        $query->where('type', 'package');

    })
    ->whereIn('status', [
        'pending',
        'rider_modified_accepted',
    ])
    ->latest()
    ->get();


    /*
    |--------------------------------------------------------------------------
    | যদি rider_id দিয়ে pending order assign করা হয়
    |--------------------------------------------------------------------------
    |
    | আপনার existing rider filtering condition থাকলে
    | সেটি অবশ্যই এখানে রাখবেন।
    |
    */


    return response()->json([
        'success' => true,
        'orders' => $orders,
    ]);
}



    
}
