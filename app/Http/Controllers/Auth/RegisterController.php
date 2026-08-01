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

        $bazars = Bazar::where('status', 'Active')->get();
        return view('auth.register', compact('bazars'));
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

        // ✅ Upload photo if given
        if ($request->hasFile('photo')) {
            $photoPath = fileUpload($request->file('photo'), 'uploads/users');
        }

        // ✅ Create user record
        User::create([
            'role_id'          => $data['role_id'],
            'name'          => $data['name'],
            'father_name'   => $data['father_name'],
            'phone'         => $data['phone'],
            'father_phone'  => $data['father_phone'],
            'address'       => $data['address'] ?? null,
            'photo'         => $data['photo'] ?? null,
            'bazar_id'      => $data['bazar_id'],
            'password'      => Hash::make($data['password']), 
        ]);

        return redirect()->route('login')->with('success', '✅ নিবন্ধন সফল হয়েছে!');
    }
}
