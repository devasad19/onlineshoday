<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Role;
use App\Models\CartItem;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

 

    /**
     * Override the username field to use phone.
     */
    public function username()
    {
        return 'phone';
    }

public function login(Request $request)
{
    $credentials = $request->validate([
        'phone' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();
        $user = Auth::user();

        // ✅ 1. পুরনো DB cart clear করুন
        CartItem::where('user_id', $user->id)->delete();

        // ✅ 2. Session cart → DB তে sync করুন (exact same)
        $sessionCart = session()->get('cart', []);
        if (!empty($sessionCart)) {
            foreach ($sessionCart as $productId => $item) {
                CartItem::create([
                    'user_id' => $user->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
        }

        // ✅ 3. Login সফল হলে session clear করতে পারেন বা রাখতে পারেন
        // session()->forget('cart'); // optional

        // ✅ 4. Redirect logic
        if (session()->has('url.intended')) {
            $intendedUrl = session('url.intended');
            session()->forget('url.intended');
            return redirect()->to($intendedUrl);
        }

        switch ($user->role->name ?? '') {
            case 'rider':
                return redirect('rider/dashboard');
            case 'user':
                return redirect('user/dashboard');
            case 'admin':
                return redirect('admin/dashboard');
            default:
                return redirect('/');
        }
    }

    throw ValidationException::withMessages([
        'phone' => 'ফোন নম্বর বা পাসওয়ার্ড সঠিক নয়।',
    ]);
}

public function logout(Request $request)
{
    $user = Auth::user();

    // ✅ যদি user লগইন থাকে → তার DB cart session এ save করুন
    if ($user) {
        $dbCart = \App\Models\CartItem::where('user_id', $user->id)->get();

        $sessionCart = [];
        foreach ($dbCart as $item) {
            $sessionCart[$item->product_id] = [
                'quantity' => $item->quantity,
                'price' => $item->price,
            ];
        }

        // ✅ Save to session before logout
        session(['cart' => $sessionCart]);
    }

    // ✅ Logout safely
    Auth::logout();
    $request->session()->regenerateToken();

    // ❌ invalidate ব্যবহার করলে session মুছে যাবে, তাই বাদ দিন
    // $request->session()->invalidate();

    return redirect('/login');
}









}
