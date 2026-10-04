<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DeliveryChargeRule;
use Illuminate\Http\Request;

class DeliveryChargeRuleController extends Controller
{
    public function index()
    {
        $rules = DeliveryChargeRule::orderBy('unit_type')
            ->orderBy('min_quantity')
            ->get();

        return view('backend.admin-dashboard.delivery_charge_rules.index', compact('rules'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'unit_type' => 'required|string|max:50',
            'min_quantity' => 'required|numeric|min:0',
            'max_quantity' => 'required|numeric|gt:min_quantity',
            'charge' => 'required|numeric|min:0',
        ]);

        DeliveryChargeRule::create([
            'unit_type' => $request->unit_type,
            'min_quantity' => $request->min_quantity,
            'max_quantity' => $request->max_quantity,
            'charge' => $request->charge,
            'status' => true,
        ]);

        return back()->with('success', 'Delivery charge rule যোগ হয়েছে।');
    }


    public function update(Request $request, DeliveryChargeRule $deliveryChargeRule)
    {
        $request->validate([
            'unit_type' => 'required|string|max:50',
            'min_quantity' => 'required|numeric|min:0',
            'max_quantity' => 'required|numeric|gt:min_quantity',
            'charge' => 'required|numeric|min:0',
        ]);

        $deliveryChargeRule->update([
            'unit_type' => $request->unit_type,
            'min_quantity' => $request->min_quantity,
            'max_quantity' => $request->max_quantity,
            'charge' => $request->charge,
        ]);

        return back()->with('success', 'Delivery charge rule আপডেট হয়েছে।');
    }


    public function destroy(DeliveryChargeRule $deliveryChargeRule)
    {
        $deliveryChargeRule->delete();

        return back()->with('success', 'Delivery charge rule মুছে ফেলা হয়েছে।');
    }


    public function toggleStatus(DeliveryChargeRule $deliveryChargeRule)
    {
        $deliveryChargeRule->update([
            'status' => !$deliveryChargeRule->status
        ]);

        return back()->with('success', 'Status পরিবর্তন হয়েছে।');
    }
}