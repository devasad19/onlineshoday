<?php
// app/Http/Controllers/Admin/RiderController.php
namespace App\Http\Controllers;

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
use Carbon\Carbon;

class RiderController extends Controller
{
    public function riderDashboard()
    {
        $data['rider'] = auth()->user()->rider; // or session-based
        $data['recentOrders'] = Order::where('rider_id', $rider->id ?? 1)
            ->latest()
            ->take(5)
            ->get() ?? [];

        
        $data['orders'] = Order::where('status', 'pending')->orderBy('created_at', 'desc')->get();    
    
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

        $order->status = 'delivered';
        $order->delivered_at = Carbon::now('Asia/Dhaka'); // ✅ লোকাল টাইমে now()

        // ✅ Compare now() vs delivery_at
        if ($order->delivery_at) {
            $now = Carbon::now('Asia/Dhaka');
            if ($order->delivery_at > $now) {
                $order->delivered_status = 'on_time';
            } else {
                $order->delivered_status = 'late';
            }
        } else {
            $order->delivered_status = null;
        }

        $order->save();


        return response()->json([
            'success' => true,
            'message' => '✅ অর্ডার সফলভাবে সম্পন্ন হয়েছে!',
            'order_id' => $id,
            'delivered_status' => $order->delivered_status,
        ]);
    }


    // ✅ Show Order Board Page
    public function riderOrders()
    {
        // rider er accepted orders দেখানো হবে
        $orders = Order::where('rider_id', auth()->id())
            ->whereIn('status', ['accepted', 'rider_modified_accepted', 'delivered'])
            ->orderBy('created_at', 'desc')
            ->get();
 
        return view('backend.riders.rider_orders', compact('orders'));
    }
   
 
public function pendingOrders()
{
    $orders = Order::with(['user', 'custom_products', 'items.product'])->where('status', 'pending')->latest()->get();

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
   
    $order = Order::findOrFail($request->id);

    if ($order->total_amount < $request->total_amount) {
        $status = 'rider_modified_accepted';
    } else {
        $status = 'accepted';
    }
 
    // ⚡ Add delivery_time (in minutes) to current time
    $delivery_at = Carbon::now('Asia/Dhaka')->addMinutes($request->delivery_time);

    $order->status = $status;
    $order->rider_id = Auth::id();
    // $order->total_amount = $request->total_amount;
    $order->delivery_time = $request->delivery_time;
    $order->delivery_at = $delivery_at;
    $order->save();

    // 🧾 Update rider_price for each item
    foreach ($request->items as $item) {
        OrderItem::where('id', $item['id'])
            ->update(['rider_price' => $item['price']]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Order accepted successfully!',
        'delivery_at' => $delivery_at->format('Y-m-d H:i:s')
    ]);
}






    
}
