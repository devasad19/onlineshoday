<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AdvertisementCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{

  
public function advertisements(\Illuminate\Http\Request $request)
{
    $query = Advertisement::published();

    // Category
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    // Advertisement type
    if ($request->filled('ad_type')) {
        $query->where('ad_type', $request->ad_type);
    }

    // Search
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('short_description', 'like', "%{$search}%")
              ->orWhere('provider_name', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%");
        });
    }

    // Sorting
    switch ($request->sort) {
        case 'oldest':
            $query->oldest();
            break;

        case 'latest':
            $query->latest();
            break;

        default:
            $query->orderByDesc('is_featured')->latest();
            break;
    }

    $advertisements = $query->paginate(12);

    // AJAX response
    if ($request->ajax()) {
        return response()->json([
            'html' => view(
                'frontend.advertisements.partials.cards',
                compact('advertisements')
            )->render(),
            'count' => $advertisements->total(),
        ]);
    }

    $categories = Advertisement::published()
        ->whereNotNull('category')
        ->distinct()
        ->orderBy('category')
        ->pluck('category');

    return view('advertisements.advertisements', compact(
        'advertisements',
        'categories'
    ));
}



 

   public function show($slug)
    {
        $advertisement = Advertisement::published()
            ->where('slug', $slug)
            ->firstOrFail();

        // ডান পাশের অন্যান্য বিজ্ঞাপন
        $otherAds = Advertisement::published()
            ->where('id', '!=', $advertisement->id)
            ->orderByDesc('is_featured')
            ->latest()
            ->take(5)
            ->get();

        // নিচের একই ক্যাটাগরির বিজ্ঞাপন
        $relatedAds = Advertisement::published()
            ->where('category', $advertisement->category)
            ->where('id', '!=', $advertisement->id)
            ->orderByDesc('is_featured')
            ->latest()
            ->take(4)
            ->get();

        return view('advertisements.show', compact(
            'advertisement',
            'otherAds',
            'relatedAds'
        ));
    }






    // Advertisement List
    public function index(Request $request)
    {
        $query = Advertisement::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('ad_type')) {
            $query->where('ad_type', $request->ad_type);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like',
                '%' . $request->search . '%');
        }

        $advertisements = $query->paginate(15)
            ->withQueryString();

        $counts = [
            'all' => Advertisement::count(),
            'pending' => Advertisement::where('status', 'pending')->count(),
            'approved' => Advertisement::where('status', 'approved')->count(),
            'rejected' => Advertisement::where('status', 'rejected')->count(),
        ];

        $categories = AdvertisementCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->pluck('name');

        return view(
            'backend.advertisements.index',
            compact('advertisements', 'counts', 'categories')
        );
    }

    // Create Form
    public function create()
    {
        return view('backend.advertisements.create');
    }

    // Store Advertisement
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => [
                'required',
                'string',
                Rule::exists('advertisement_categories', 'name')
                    ->where('is_active', true),
            ],

            'ad_type' => 'required|in:own_service,partner_service,general_ad',

            'provider_name' => 'nullable|string|max:255',
            'provider_type' => 'nullable|string|max:100',

            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'price_label' => 'nullable|string|max:100',

            'is_featured' => 'nullable|boolean',
            'expires_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title'])
            . '-' . Str::random(6);

        // Admin-created advertisements are approved directly.
        $validated['status'] = 'approved';

        $validated['approved_by'] = auth()->id();
        $validated['approved_at'] = now();

        $validated['user_id'] = null;

        $validated['is_featured'] = $request->boolean('is_featured');

 
        if ($request->hasFile('image')) {
            $validated['image'] = fileUpload($request->file('image'), 'uploads/advertisements');
        }

        Advertisement::create($validated);

        return redirect()
            ->route('admin.advertisements.index')
            ->with('success', 'বিজ্ঞাপন সফলভাবে প্রকাশ করা হয়েছে।');
    }

    // Edit Form
    public function edit(Advertisement $advertisement)
    {
        return view(
            'backend.advertisements.edit',
            compact('advertisement')
        );
    }

    // Update Advertisement
    public function update(Request $request, Advertisement $advertisement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',

            'ad_type' => 'required|in:own_service,partner_service,general_ad',

            'provider_name' => 'nullable|string|max:255',
            'provider_type' => 'nullable|string|max:100',

            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'price_label' => 'nullable|string|max:100',

            'is_featured' => 'nullable|boolean',
            'expires_at' => 'nullable|date',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {

            if ($advertisement->image) {
                Storage::disk('public')->delete($advertisement->image);
            }

            $validated['image'] = $request->file('image')
                ->store('advertisements', 'public');
        }

        // Keep the existing slug on edit.
        $advertisement->update($validated);

        return redirect()
            ->route('admin.advertisements.index')
            ->with('success', 'বিজ্ঞাপন আপডেট হয়েছে।');
    }

    // Approve Advertisement
    public function approve(Advertisement $advertisement)
    {
        $advertisement->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'বিজ্ঞাপন অনুমোদন করা হয়েছে।');
    }

    // Reject Advertisement
    public function reject(Request $request, Advertisement $advertisement)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $advertisement->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'বিজ্ঞাপন বাতিল করা হয়েছে।');
    }

    // Delete Advertisement
    public function destroy(Advertisement $advertisement)
    {
        if ($advertisement->image) {
            Storage::disk('public')->delete($advertisement->image);
        }

        $advertisement->delete();

        return back()->with('success', 'বিজ্ঞাপন মুছে ফেলা হয়েছে।');
    }



// Public Advertisement Submission
public function submit(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'category' => 'required|string|max:100',

        'ad_type' => 'required|in:partner_service,general_ad',

        'provider_name' => 'required|string|max:255',
        'short_description' => 'nullable|string|max:500',
        'description' => 'required|string',

        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        'location' => 'required|string|max:255',
        'phone' => 'required|string|max:30',
        'price_label' => 'nullable|string|max:100',
    ]);

    $validated['slug'] = Str::slug($validated['title'])
        . '-' . Str::random(6);

    // Public submission always requires admin approval.
    $validated['status'] = 'pending';

    $validated['user_id'] = auth()->id();

    $validated['is_featured'] = false;

    $validated['approved_by'] = null;
    $validated['approved_at'] = null;

 
 
        if ($request->hasFile('image')) {
            $validated['image'] = fileUpload($request->file('image'), 'uploads/advertisements');
        }

 


    Advertisement::create($validated);

    return back()->with(
        'success',
        'আপনার বিজ্ঞাপন জমা হয়েছে। Admin অনুমোদনের পর প্রকাশিত হবে।'
    );
}








}
