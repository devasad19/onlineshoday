<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rider;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use App\Models\Product;
use App\Models\Package;
use App\Models\Bazar;
use App\Models\User;
use App\Models\CartItem;
use App\Models\Contact;
use App\Models\RiderProduct;
use Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{

    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function ourPolicy()
    {
        return view('our_policy');
    }

    public function ourBazarList()
    {
        $data['bazars'] = Bazar::get();

        return view('bazars', $data);
    }

    public function privacyPolicy()
    {
        return view('privacy-policy');
    }

    public function contactUs()
    {
        return view('contact_us');
    }

    public function termsAndConditions()
    {
        return view('terms-and-conditions');
    }

    public function frontdHome(){
        $data['bazars'] = Bazar::where('status', 'Active')->get();
        $data['categories'] = Category::where('status', 'Active')->get();
        $data['riders'] = Rider::where('status', 'Active')->take(4)->get();

        
        $data['user'] = Auth::user();
        $data['rider'] = Auth::user()->rider?? '';


        $data['products'] = Product::where('status', 'active')
                                    ->with(['category'])
                                    ->where('ecom', 0)
                                    ->latest()
                                    ->take(12)
                                    ->get();

        $data['packages'] = Package::where('status', 'active')
                                    ->latest()
                                    ->take(6)
                                    ->get();

        $data['ecommece_products'] = Product::where('status', 'active')
                                    ->with(['category'])
                                    ->where('ecom', 1)
                                    ->latest()
                                    ->take(12)
                                    ->get();

        // Session::flush();
        // Auth::logout();
        // return redirect('/login');


        return view('front_index', $data);
    }

 // 🎯 Product Filter Function
    public function filterProducts(Request $request)
    {
        $query = Product::query()->with(['bazar', 'category'])->where('status', 'active');
 
        $data['keyword'] = '';
        $data['bazar_id'] = '';
        $data['category_id'] = '';
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
            $data['category_id'] = $request->category_id;
        }
 
        if ($request->filled('bazar_id')) {
            $query->where('bazar_id', $request->bazar_id);
            $data['bazar_id'] = $request->bazar_id;
        }

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
            
            $data['keyword'] = $request->keyword;
        }

        $data['products'] = $query->latest()->get();
        $data['bazars'] = Bazar::where('status', 'Active')->get();
        $data['categories'] = Category::where('status', 'Active')->get();
        $data['riders'] = Rider::where('status', 'Active')->get();

        return view('products_all', $data);
    }

public function allProducts(Request $request)
{
    $query = Product::query()->with(['category'])->where('status', 'active');

    if ($request->filled('keyword')) {
        $query->where('name', 'like', '%' . $request->keyword . '%');
    }

    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    if ($request->filled('bazar_id')) {
        $query->where('bazar_id', $request->bazar_id);
    }

    if ($request->filled('rider_id')) {
        $query->where('rider_id', $request->rider_id);
    }

    if ($request->filled('price_range')) {
        [$min, $max] = explode('-', $request->price_range);
        $query->whereBetween('price', [(int)$min, (int)$max]);
    }

    $products = $query->latest()->paginate(12);

    return view('products_all', [
        'products' => $products,
        'categories' => \App\Models\Category::where('status', 'Active')->get(),
        'bazars' => \App\Models\Bazar::where('status', 'Active')->get(),
        'riders' => \App\Models\Rider::where('status', 'Active')->get(),
        'filters' => $request->all()
    ]);
}


public function frontdProductDetails($id)
{
    $data['product'] = Product::with(['category', 'bazar'])->findOrFail($id);

    // ধরুন orders টেবিলে rider_id আছে
    $data['recentOrders'] = Order::where('rider_id', $id)
                        ->latest()
                        ->take(5)
                        ->get();

            
            $data['othersProducts'] = Product::where('bazar_id', $data['product']->bazar_id)
                ->where('category_id', '!=', $data['product']->category_id)
                ->where('id', '!=', $data['product']->id)
                ->take(4)
                ->get();


    // সম্পর্কিত পণ্য (same bazar এর)
    $data['relatedProducts'] = Product::where(['bazar_id' => $data['product']->bazar_id, 'category_id' => $data['product']->category_id])
                        ->where('id', '!=', $data['product']->id)
                        ->take(4)
                        ->get();

 
    return view('details', $data);
}

public function frontdEcommerceProductDetails($id)
{
    $data['product'] = Product::with(['category', 'bazar'])->findOrFail($id);

    // ধরুন orders টেবিলে rider_id আছে
    $data['recentOrders'] = Order::where('rider_id', $id)
                        ->latest()
                        ->take(5)
                        ->get();

            
        $data['othersProducts'] = Product::where('ecom', 0)
            ->where('id', '!=', $data['product']->id)
            ->where('status', 'active')
            ->inRandomOrder()
            ->take(4)
            ->get();
 

    // সম্পর্কিত পণ্য (same bazar এর)
    $data['relatedProducts'] = Product::where(['bazar_id' => $data['product']->bazar_id, 'category_id' => $data['product']->category_id])
                        ->where('id', '!=', $data['product']->id)
                        ->where('ecom', 1)
                        ->take(4)
                        ->get();

 
    return view('ecom_details', $data);
}

public function riderProfile($id)
{
    $rider = Rider::findOrFail($id);

    // ধরুন orders টেবিলে rider_id আছে
    $recentOrders = Order::where('rider_id', $id)
                        ->latest()
                        ->take(5)
                        ->get();

    return view('rider_details', compact('rider', 'recentOrders'));
}



public function homePlaceOrder()
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

    return view('place-order', compact('cartItems', 'total', 'user', 'extraProducts'));
}

 

    public function homeOrderDone()
    {
        // যদি কার্ট session বা DB থেকে আনা হয়, এখানে fetch করুন
        $cartItems = session()->get('cart', []);
        $total = collect($cartItems)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('order_success', compact('cartItems', 'total'));
    }
 
        public function contactUsStore(Request $request)
        {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            // ডাটাবেজে সংরক্ষণ
            Contact::create($validated);

            return back()->with('success', '✅ আপনার বার্তা সফলভাবে পাঠানো হয়েছে! আমরা শীঘ্রই যোগাযোগ করব।');
        }

 

public function createCustomer(Request $request)
{
    $data['bazars'] = Bazar::where('status', 'Active')->get();

    // যে package থেকে customer registration শুরু হয়েছে
    $data['package_id'] = $request->package_id;

    return view('auth.new_customer_register', $data);
}
    /**
     * Store user data from registration form.
     */
    public function storeNewCustomer(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:100',
            'father_name'   => 'required|string|max:100',
            'phone'         => 'required|string|unique:users,phone',
            'father_phone'  => 'required|string',
            'address'       => 'nullable|string',
            'photo'         => 'nullable|image|max:2048',
            'bazar_id'      => 'required|exists:bazars,id',
            'password'      => 'required',
        ]);

        // Generate unique 6 digit customer ID
        do {
            $customerId = str_pad(random_int(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (User::where('customer_id', $customerId)->exists());


        // Upload photo if given
        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = fileUpload(
                $request->file('photo'),
                'uploads/users'
            );
        }
        // =====================================================
        // Save package ID temporarily
        // =====================================================

        session([
            'new_customer_package_id' => $request->package_id,
        ]);


        // Create user
        User::create([
            'customer_id'   => $customerId,
            'name'          => $data['name'],
            'father_name'   => $data['father_name'],
            'phone'         => $data['phone'],
            'father_phone'  => $data['father_phone'],
            'address'       => $data['address'] ?? null,
            'photo'         => $photoPath,
            'bazar_id'      => $data['bazar_id'],
            'status'      => 'active',
            'password'      => Hash::make($data['password']),
        ]);

            return redirect()
            ->route('show.new_customer.info', [
                'customer' => $customerId
            ])
            ->with('success', 'নিবন্ধন সফল হয়েছে! আপনার Customer ID: ' . $customerId);
    }

    public function showNewCustomerInfo($customer_id)
    {
        $packageId = session('new_customer_package_id');
        $customer = User::where('customer_id', $customer_id)->first();

        return view('auth.new_customer_info', compact(
            'customer',
            'packageId'
        ));
    }








}
