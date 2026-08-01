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



    public function myOrders(){
         

        $data['orders'] = Order::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->with(['user', 'rider', 'custom_products', 'items.product'])
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
        $order = Order::with(['user', 'items.product'])->findOrFail($request->id);

        // Only allow rider to view if pending or assigned appropriately (adjust logic as needed)
        // if you want to restrict: if($order->status !== 'pending' && $order->rider_id && $order->rider_id !== Auth::id()) abort(403);

        // prepare items to send
        $items = $order->items->map(function($it) {
            return [
                'id' => $it->id,
                'product_id' => $it->product_id,
                'product_name' => optional($it->product)->name ?? 'N/A',
                'product_image' => optional($it->product)->image ? url('uploads/products/' . $it->product->image) : null,
                'unit' => optional($it->product)->unit ?? '',
                'qty' => $it->quantity,
                'price' => (float) $it->price,         // original order price per unit
                'rider_price' => (float) ($it->rider_price ?? $it->price) // if rider proposed price stored per item
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

    // POST /rider/order/{id}/accept
    public function accept(Request $request){
            
        $order = Order::with('items')->findOrFail($request->id);

        if(!in_array($order->status, ['rider_modified_accepted', 'acctedped'])){
            return response()->json(['success'=>false,'message'=>'Cannot accept this order.'], 400);
        }

        $payload = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
            try {
                $total = 0;

                foreach($payload['items'] as $it){
                    $item = $order->items->where('id', $it['id'])->first();
            
                    if(!$item) continue;
 
                    // Update only if rider_price > current price
                    if($it['price'] > $item->price){
                        $item->price = $item->rider_price;
                        $item->rider_price = $it['price'];
                        $item->save();
                    }

                    $total += $item->rider_price * $item->quantity;
                }

                $order->total_amount = $total;
                $order->status = 'accepted';
                $order->save();

                DB::commit();

                return response()->json([
                    'success'=>true,
                    'message'=>'অর্ডার সফলভাবে গ্রহণ করা হয়েছে।',
                    'order'=>[
                        'id'=>$order->id,
                        'total_amount'=>(float)$order->total_amount,
                        'status'=>$order->status
                    ]
                ]);

            } catch(\Exception $e){
                DB::rollBack();
                return response()->json(['success'=>false,'message'=>'Server error: '.$e->getMessage()],500);
            }
    }

    // POST /rider/order/{id}/accept
    public function orderCancell(Request $request){
        $order = Order::with('items')->findOrFail($request->id);

        if(!in_array($order->status, ['rider_modified_acctedped'])){
            return response()->json(['success'=>false,'message'=>'অর্ডার বাতিল করা যাচ্ছে না।.'], 400);
        }

        DB::beginTransaction();
        try { 
 
            $order->status = 'cancelled';
            $order->save();

            DB::commit();

            return response()->json([
                'success'=>true,
                'message'=>'অর্ডার সফলভাবে বাতিল করা হয়েছে।',
                'order'=>[
                    'id'=>$order->id,
                    'total_amount'=>(float)$order->total_amount,
                    'status'=>$order->status
                ]
            ]);

        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>'Server error: '.$e->getMessage()],500);
        }
    }






}
