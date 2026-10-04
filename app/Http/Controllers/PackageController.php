<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Bazar;
use App\Models\Category;
use App\Models\Rider;
use App\Models\Order;
use App\Models\Package;
use App\Models\PackageItem;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    public function index()
    { 
        $data['packages'] = Package::with('package_items')
            ->latest()->get();

        $data['products'] = Product::where('status', 'active')->get();

        return view('backend.admin-dashboard.packages.index', $data);
    }

    public function createPkg()
    {

        return view('backend.admin-dashboard.packages.create_pkg');
    }

    public function packageAll()
    {        
        $data['packages'] = Package::with('package_items')
            ->latest()->get();

        return view('packages.packages', $data);
    }

   public function packageDetails($id)
    {
         
        $package = Package::with([
            'package_items.product'
            ])
            ->where('status', 'active')
            ->findOrFail($id);
             
         
        $packages = Package::with('package_items')
            ->whereNot('id', $id)
            ->latest()->get();
             

        // Discount calculation
        $oldPrice = (float) $package->price;

        $discountPercent = (float) ($package->discount ?? 0);

        $discountPrice = (int) ($oldPrice - (
            $oldPrice * $discountPercent / 100
        ));


        // Other packages
        $relatedPackages = Package::with('package_items')
            ->where('id', '!=', $package->id)
            ->where('status', 1)
            ->latest()
            ->take(6)
            ->get();


        return view('packages.package_details', compact(
            'packages',
            'package',
            'relatedPackages',
            'oldPrice',
            'discountPercent',
            'discountPrice'
        ));
    }

    // ✅ Store Product
    public function packagePointsDetails(Request $request){


        return view('packages.package_points_details');

    }





    // ✅ Store Product
    public function storePkg(Request $request)
    {
 
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'status'      => 'required|string',
            'image'       => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = fileUpload($request->file('image'), 'uploads/packages');
        }

        Package::create([
            'name'        => $request->name,
            'price'       => $request->price,
            'discount'       => $request->discount,
            'status'      => $request->status,
            'description' => $request->description,
            'image'       => $imagePath,
        ]);

        return redirect()->back()->with('success', '✅ প্যাকেজ সফলভাবে সংরক্ষণ করা হয়েছে!');
    }

    public function updatePkg(Request $request)
{
    $request->validate([
        'id'          => 'required|exists:packages,id',
        'name'        => 'required|string|max:255',
        'price'       => 'required|numeric|min:0',
        'discount'    => 'nullable|numeric|min:0',
        'status'      => 'required|string',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $package = Package::findOrFail($request->id);

    $imagePath = $package->image;

    // নতুন image দিলে
    if ($request->hasFile('image')) {

        $imagePath = fileUpload(
            $request->file('image'),
            'uploads/packages'
        );
    }

    $package->update([
        'name'        => $request->name,
        'price'       => $request->price,
        'discount'    => $request->discount ?? 0,
        'status'      => $request->status,
        'description' => $request->description,
        'image'       => $imagePath,
    ]);

    return response()->json([
        'status'  => true,
        'message' => '✅ প্যাকেজ সফলভাবে আপডেট করা হয়েছে!'
    ]);
}
    
public function getPkgItems(Request $request)
{
    $items = PackageItem::with('product')
        ->where('package_id', $request->package_id)
        ->get();

    return response()->json([
        'items' => $items
    ]);
}

public function storePackageItem(Request $request)
{
    $request->validate([
        'package_id' => 'required|exists:packages,id',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required',
    ]);

    // Package আছে কিনা
    $package = Package::findOrFail($request->package_id);

    // Product বের করা
    $product = Product::findOrFail($request->product_id);

    // একই product এই package-এ আগে আছে কিনা
    $exists = PackageItem::where('package_id', $package->id)
        ->where('product_id', $product->id)
        ->exists();

    if ($exists) {
        return response()->json([
            'status' => false,
            'message' => 'এই প্রোডাক্টটি ইতোমধ্যে এই প্যাকেজে যোগ করা হয়েছে!'
        ], 422);
    }

    // Package item তৈরি
    $item = PackageItem::create([
        'package_id' => $package->id,
        'product_id' => $product->id,
        'quantity'   => $request->quantity,
        'status'     => 1,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'প্রোডাক্ট সফলভাবে প্যাকেজে যোগ হয়েছে!',
        'data' => $item
    ]);
}



   /**
     * Package purchase page
     */
    public function purchase(Package $package)
    {
        
        // Package active কিনা
        
        // Package items
        $package->load([
            'items.product'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Referral Customers
        |--------------------------------------------------------------------------
        |
        | এখানে আপনার referral relationship অনুযায়ী query পরিবর্তন করতে হতে পারে।
        | আপাতত logged-in customer যাদের refer করেছে তাদের customer_id দিয়ে ধরা হচ্ছে।
        |
        */

        $referralCustomers = User::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('frontend.packages.purchase', compact(
            'package',
            'referralCustomers'
        ));
    }


    public function storePurchase(Request $request, Package $package)
{
    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    $request->validate([
        'customer_id' => [
            'required',
            'integer',
            'exists:users,id',
        ],
    ]);


    /*
    |--------------------------------------------------------------------------
    | Logged-in purchaser
    |--------------------------------------------------------------------------
    */

    $purchaser = auth()->user();


    /*
    |--------------------------------------------------------------------------
    | Selected customer
    |--------------------------------------------------------------------------
    */

    $customer = User::findOrFail($request->customer_id);

    if($customer->referrer_id == null){
        $customer->referrer_id = $purchaser->id;
        $customer->update();
    }

    /*
    |--------------------------------------------------------------------------
    | Security:
    | অন্য Customer হলে অবশ্যই purchaser-এর direct referral হতে হবে
    |--------------------------------------------------------------------------
    */
 

    if ($customer->id != $purchaser->id) {

    if ( $customer->referrer_id !== $purchaser->id) {

        return back()
            ->with('error', 'এই Customer আপনার Referral Customer নন।')
            ->withInput();
    }
}
 
 
    /*
    |--------------------------------------------------------------------------
    | Package price calculation
    |--------------------------------------------------------------------------
    */

    $packagePrice = (float) $package->price;

    $discountPercent = (float) ($package->discount ?? 0);

    $discountAmount =
        ($packagePrice * $discountPercent) / 100;

    $finalAmount =
        $packagePrice - $discountAmount;


    /*
    |--------------------------------------------------------------------------
    | Safety
    |--------------------------------------------------------------------------
    */

    if ($finalAmount < 0) {
        $finalAmount = 0;
    }


    /*
    |--------------------------------------------------------------------------
    | Order Code
    |--------------------------------------------------------------------------
    */

    do {

        $orderCode =
            'PKG-' .
            now()->format('ymd') .
            '-' .
            strtoupper(Str::random(6));

    } while (
        Order::where('order_code', $orderCode)->exists()
    );


    /*
    |--------------------------------------------------------------------------
    | Delivery Address
    |--------------------------------------------------------------------------
    */

    $deliveryAddress =
        $customer->address ?: 'ঠিকানা দেওয়া হয়নি';


    /*
    |--------------------------------------------------------------------------
    | Create Order
    |--------------------------------------------------------------------------
    */

    $order = DB::transaction(function () use (
        $purchaser,
        $customer,
        $package,
        $finalAmount,
        $deliveryAddress,
        $orderCode
    ) {

        return Order::create([

            /*
            | যিনি package কিনছেন
            */
            'user_id' => $purchaser->id,

            /*
            | যার জন্য package
            */
            'customer_id' => $customer->id,

            /*
            | Package
            */
            'package_id' => $package->id,

            /*
            | Final discounted amount
            */
            'total_amount' => $finalAmount,

            /*
            | Package order-এর জন্য এখন delivery charge 0
            */
            'delivery_charge' => 0,

            'delivery_charge_details' => null,

            /*
            | COD
            */
            'payment_method' => 'Cash On Delivery',

            /*
            | Recipient address
            */
            'delivery_address' => $deliveryAddress,

            /*
            | Initial status
            */
            'type' => 'package',
            'status' => 'pending',

            /*
            | আপনার existing fields
            */
            'order_code' => $orderCode,

            'rider_id' => null,

            'delivery_time' => null,

            'delivered_at' => null,

            'delivery_at' => null,

            'delivered_status' => 'pending',

            'notes' => 'Package Order',

        ]);

    });


    /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    */
 if ($customer->id != $purchaser->id) {

    return redirect()
        ->route('packages.purchase', ['package' => $package->id])
        ->with('success', 'অন্য Customer-এর জন্য Package Order সফল হয়েছে।');
}

    return redirect()
        ->route('user.my_orders')
        ->with(
            'success',
            'প্যাকেজ অর্ডার সফল হয়েছে। Order Code: ' . $order->order_code
        );
}

    
}
