<?php
// app/Http/Controllers/CartController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\CustomProduct;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    // 🛒 Add to Cart
 

    // 🛒 Add to Cart
    public function addToCart(Request $request)
{
    $request->validate([
        'product_id' => 'required|integer',
        'quantity' => 'required|integer|min:1',
    ]);

    $product = Product::findOrFail($request->product_id);
    $userId = Auth::id();

    $cartitem = CartItem::where('user_id', $userId)
            ->first();


    if($cartitem){
        $existingBazarId = $cartitem->product->bazar_id;
        $currentBazarId = $product->bazar_id;

        if ($existingBazarId && $existingBazarId != $currentBazarId) {

                return response()->json([
                    'status' => 'confirm_clear',
                    'message' => 'আপনার ব্যাগে <b style="color:#ef4444;">' . e($cartitem->product->bazar->name) . '</b> এর পণ্য আছে। 
                                আপনি কি নতুন করে <b style="color:#16a34a;">' . e($product->bazar->name) . '</b> থেকে শুরু করতে চান?',
                ]);

        }
    }


    if ($userId) {
        // Logged in user → Save in DB
        $existing = CartItem::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $existing->quantity += $request->quantity;
            $existing->save();
        } else {
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }
    } else {
        // Guest user → store in session
        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'image' => $product->image
            ];
        }
        session()->put('cart', $cart);
    }

    return response()->json([
        'success' => true,
        'message' => 'পণ্যটি আপনার ব্যাগে যোগ হয়েছে!',
    ]);
}

 

public function clearAndAdd(Request $request)
{
    $userId = Auth::id();
    $product = Product::findOrFail($request->product_id);
     CartItem::where('user_id', $userId)
            ->delete();
 

    if ($userId) {
        // Logged in user → Save in DB
        $existing = CartItem::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $existing->quantity += $request->quantity;
            $existing->save();
        } else {
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => $request->quantity?? 22,
                'price' => $product->price,
            ]);
        }
    } else {
        // Guest user → store in session
        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'image' => $product->image
            ];
        }
        session()->put('cart', $cart);
    }

    return response()->json(['status' => 'success', 'message' => 'নতুন বাজার ('.$product->bazar->name.') থেকে পণ্য যোগ হয়েছে!']);
}


    // 🔢 Count total items
    public function count()
    {
        if (Auth::check()) {
            $count = CartItem::where('user_id', Auth::id())->sum('quantity');
        } else {
            $count = collect(session('cart', []))->sum('quantity');
        }

        return response()->json(['count' => $count]);
    }

    // 📦 Show cart items (optional)
public function index()
{
    if (auth()->check()) {
        $items = \App\Models\CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();
    } else {
        $items = collect();
    }

    return response()->json([
        'items' => $items,
        'count' => $items->sum('quantity'),
        'total' => $items->sum(fn($item) => $item->price * $item->quantity),
    ]);
}

    // 📦 Show cart items (optional)
public function viewCardItems()
{
    if (auth()->check()) {
        $userId = auth()->id();
        $items = CartItem::with('product')->where('user_id', $userId)->get();
        return response()->json([
            'source' => 'database',
            'items' => $items,
            'count' => $items->sum('quantity')
        ]);
    } else {
        $sessionCart = session('cart', []);
 

        $productIds = array_keys($sessionCart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $cartItems = [];

        foreach ($sessionCart as $productId => $item) {
            if (isset($products[$productId])) {
                $product = $products[$productId];
                $cartItems[] = [
                    'product_id' => $productId,
                    'name' => $product->name,
                    'image' => $product->image ?? null,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'unit' => $product->unit ?? '',
                ];
            }
        }
       

        return response()->json([
            'source' => 'session',
            'items' => $cartItems,
            'count' => collect($cartItems)->sum('quantity')
        ]);
    }

}

// 🗑️ Remove item from session cart
public function removeSessionItem($productId)
{

    if (auth()->check()) {
        $userId = auth()->id();
        CartItem::where('user_id', $userId)
        ->where('product_id', $productId)
        ->delete();
         
        $cart = CartItem::where('user_id', $userId)
            ->get();

    } else {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]); // পণ্যটা কার্ট থেকে মুছে ফেলো
            session()->put('cart', $cart);
        }
    }

    return response()->json([
        'success' => true,
        'message' => '🗑️ পণ্যটি ব্যাগ থেকে সরিয়ে ফেলা হয়েছে!',
        'cart' => $cart
    ]);
}


public function update(Request $request)
{

    $cart = CartItem::findOrFail($request->id);
    $cart->quantity = $request->quantity;
    $cart->save();

    $total = CartItem::where('user_id', auth()->id())
                ->get()
                ->sum(fn($c) => $c->price * $c->quantity);

    return response()->json([
        'success' => true,
        'itemTotal' => $cart->price * $cart->quantity,
        'cartTotal' => $total
    ]);
}

public function destroy(Request $request)
{
    $cart = CartItem::findOrFail($request->id);
    $cart->delete();

    $total = CartItem::where('user_id', auth()->id())
                ->get()
                ->sum(fn($c) => $c->price * $c->quantity);

    return response()->json([
        'success' => true,
        'cartTotal' => $total
    ]);
}

public function saveOrder(Request $request)
{
    if (!auth()->check()) {
        session(['url.intended' => url()->current()]);
        return redirect('/login');
    }

    $user = Auth::user();

    $cartItems = CartItem::where('user_id', $user->id)->get();

    if ($cartItems->isEmpty()) {
        return back()->with('error', 'আপনার ব্যাগ খালি।');
    }

    $totalAmount = $cartItems->sum(function ($item) {
        return $item->price * $item->quantity;
    });

    $customTotal = (float) ($request->customTotal ?? 0);

    $total = $totalAmount + $customTotal;


    // ==========================================
    // Create Order
    // ==========================================

    $order = Order::create([
        'user_id' => $user->id,
        'order_code' => 'ORD-' . strtoupper(Str::random(8)),
        'total_amount' => $total,
        'payment_method' => 'Cash On Delivery',
        'delivery_address' => $request->address,
        'created_at' => now('Asia/Dhaka'),
        'updated_at' => now('Asia/Dhaka'),
    ]);


    // ==========================================
    // Save Order Items
    // ==========================================

    foreach ($cartItems as $cart) {

        $order->items()->create([
            'product_id' => $cart->product_id,
            'quantity' => $cart->quantity,
            'price' => $cart->price,
        ]);
    }


    // ==========================================
    // Save Custom Products
    // ==========================================

    if ($request->filled('custom_products')) {

        $customProducts =
            $request->input('custom_products', []);

        foreach ($customProducts as $product) {

            $name =
                $product['name'] ?? null;

            $qty =
                $product['qty'] ?? null;

            $unit =
                $product['unit'] ?? null;

            $price =
                $product['price'] ?? null;


            if ($name && $unit) {

                CustomProduct::create([
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'name' => $name,
                    'quantity' => $qty,
                    'unit' => $unit,
                    'price' => $price,
                ]);
            }
        }
    }


    // ==========================================
    // Clear Cart
    // ==========================================

    CartItem::where('user_id', $user->id)->delete();

    session()->forget([
        'cart',
        'bazar_id'
    ]);


    // ==========================================
    // Redirect
    // ==========================================

    return redirect()
        ->route('home.order.done')
        ->with([
            'success' => 'অর্ডার সফলভাবে সেভ হয়েছে!',
            'orderId' => $order->order_code,
            'total' => $total,
            'address' => $request->address,
            'phone' => $user->phone,
        ]);
}






    
}
