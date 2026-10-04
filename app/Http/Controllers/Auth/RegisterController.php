<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bazar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the registration form.
     */
    public function create()
    { 

        $data['bazars'] = Bazar::where('status', 'Active')->get();
       
        return view('auth.register', $data);
    }



    /**
     * Store user data from registration form.
     */
    public function store(Request $request)
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
            ->route('login')
            ->with('success', '✅ নিবন্ধন সফল হয়েছে! আপনার Customer ID: ' . $customerId);
    }






}
