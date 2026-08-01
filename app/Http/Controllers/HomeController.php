<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rider;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use App\Models\Product;
use App\Models\Bazar;
use App\Models\CartItem;
use App\Models\Contact;
use App\Models\RiderProduct;
use Auth;

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



}
