<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class PackageController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);

        return view('backend.admin-dashboard.packages.index', compact('products'));
    }








    
}
