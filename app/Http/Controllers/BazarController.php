<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bazar;
use App\Models\BazarArea;
use Illuminate\Http\Request;

class BazarController extends Controller
{
    // বাজার লিস্ট দেখানো
    public function adminManageBazar ()
    {
        $data['bazars'] = Bazar::latest()->get();
         
        return view('backend.admin-dashboard.manage_bazar', $data);
    }

    // বাজার সংরক্ষণ (Add/Edit)
    public function store(Request $request)
    {
       
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        $bazar = Bazar::updateOrCreate(
            ['id' => $request->id],
            ['name' => $request->name, 'status' => $request->status]
        );

        return response()->json([
            'success' => true,
            'message' => $request->id ? 'বাজার তথ্য আপডেট হয়েছে ✅' : 'নতুন বাজার যোগ করা হয়েছে ✅',
            'bazar' => $bazar
        ]);
    }

    // বাজার সম্পাদনা ডেটা
    public function edit($id)
    {
        $bazar = Bazar::findOrFail($id);
        return response()->json($bazar);
    }

    // বাজার আপডেট (Ajax)
    public function bazarUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:Active,Inactive',
        ]);

        $bazar = Bazar::findOrFail($request->id);
        $bazar->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true, 'message' => '✅ বাজার সফলভাবে আপডেট হয়েছে!']);
    }

    // বাজার মুছে ফেলা
public function destroy($id)
{
    $bazar = Bazar::find($id);

    if (!$bazar) {
        return response()->json(['message' => 'বাজার পাওয়া যায়নি!'], 404);
    }

    $bazar->delete();

    return response()->json(['message' => '✅ বাজার সফলভাবে মুছে ফেলা হয়েছে']);
}




public function getAreas(Request $request)
{
    $areas = BazarArea::where('bazar_id', $request->bazar_id)->get();

    return response()->json(['areas' => $areas]);
}


 public function bazarAreastore(Request $request)
    {
        $request->validate([
            'bazar_id' => 'required|exists:bazars,id',
            'name' => 'required|string|max:255',
        ]);

        if ($request->id) {
            $area = BazarArea::findOrFail($request->id);
            $area->update([
                'name' => $request->name,
            ]);
            return response()->json(['message' => '✅ এলাকা সফলভাবে আপডেট হয়েছে!']);
        } else {
            BazarArea::create([
                'bazar_id' => $request->bazar_id,
                'name' => $request->name,
            ]);
            return response()->json(['message' => '✅ নতুন এলাকা সফলভাবে যোগ হয়েছে!']);
        }
    }

    public function bazarAreadestroy(Request $request)
    {
        $area = BazarArea::find($request->id);
        if (!$area) {
            return response()->json(['message' => '❌ এলাকা পাওয়া যায়নি!'], 404);
        }

        $area->delete();
        return response()->json(['message' => '✅ এলাকা সফলভাবে মুছে ফেলা হয়েছে!']);
    }








}
