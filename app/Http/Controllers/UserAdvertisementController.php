<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\AdvertisementComplaint;
use Illuminate\Validation\Rule;


class UserAdvertisementController extends Controller
{
  // My advertisements
    public function index()
    {
        $advertisements = Advertisement::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('backend.user-dashboard.advertisements.index', compact('advertisements'));
    }

    // Create form
    public function create()
    {
        return view('backend.user-dashboard.advertisements.create');
    }

    // Store advertisement
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:নাগরিক সেবা,বাসা ও মেরামত,খাবার ও মিল,ডিজিটাল ও আইটি,স্থানীয় বিজ্ঞাপন',

            'ad_type' => 'required|in:partner_service,general_ad',

            'provider_name' => 'required|string|max:255',
            'provider_type' => 'nullable|string|max:255',

            'short_description' => 'required|string|max:300',
            'description' => 'required|string',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'location' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'price_label' => 'nullable|string|max:100',
        ], [
            'title.required' => 'বিজ্ঞাপনের শিরোনাম লিখুন।',
            'category.required' => 'বিজ্ঞাপনের ক্যাটাগরি নির্বাচন করুন।',
            'ad_type.required' => 'বিজ্ঞাপনের ধরন নির্বাচন করুন।',
            'short_description.required' => 'সংক্ষিপ্ত বিবরণ লিখুন।',
            'description.required' => 'বিস্তারিত বিবরণ লিখুন।',
            'image.image' => 'সঠিক ছবি নির্বাচন করুন।',
            'image.max' => 'ছবির সাইজ সর্বোচ্চ ২ MB হতে পারবে।',
            'phone.required' => 'যোগাযোগের ফোন নম্বর দিন।',
            'location.required' => 'ঠিকানা বা এলাকার নাম লিখুন।',
        ]);

        // Upload image
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = fileUpload($request->file('image'), 'uploads/advertisements');
        }
        // Generate unique slug
        $slug = Str::slug($validated['title']);

        if (empty($slug)) {
            $slug = 'advertisement';
        }

        $slug .= '-' . Str::lower(Str::random(6));

        Advertisement::create([
            'user_id' => auth()->id(),

            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'ad_type' => $validated['ad_type'],

            'provider_name' => $validated['provider_name'],
            'provider_type' => $validated['provider_type'] ?? null,

            'short_description' => $validated['short_description'],
            'description' => $validated['description'],

            'image' => $imagePath,
            'location' => $validated['location'],
            'phone' => $validated['phone'],
            'price_label' => $validated['price_label'] ?? null,

            // Admin approval required
            'status' => 'pending',
            'is_featured' => false,
        ]);

        return redirect()
            ->route('user.advertisements.index')
            ->with('success', 'আপনার বিজ্ঞাপনটি জমা হয়েছে। Admin অনুমোদনের পর এটি প্রকাশিত হবে।');
    }






   /**
     * Show complaint form.
     */
    public function complaintcreate(Request $request)
    {
        $advertisements = Advertisement::published()
            ->with('user:id,name')
            ->orderBy('title')
            ->get(['id', 'user_id', 'title', 'slug']);

        $selectedAdvertisement = null;

        if ($request->filled('advertisement_id')) {
            $selectedAdvertisement = Advertisement::published()
                ->whereKey($request->advertisement_id)
                ->first();
        }

        return view(
            'backend.advertisement_complaints.create',
            compact('advertisements', 'selectedAdvertisement')
        );
    }

    /**
     * Store a new complaint.
     */
    public function complaintstore(Request $request)
    {
        $validated = $request->validate([
            'advertisement_id' => [
                'required',
                'integer',
                'exists:advertisements,id',
            ],

            'complaint_type' => [
                'required',
                Rule::in([
                    'service_not_received',
                    'fraud',
                    'wrong_information',
                    'extra_charge',
                    'bad_behavior',
                    'poor_service',
                    'other',
                ]),
            ],

            'description' => [
                'required',
                'string',
                'min:10',
                'max:5000',
            ],

            'desired_resolution' => [
                'nullable',
                Rule::in([
                    'get_service',
                    'refund',
                    'contact',
                    'investigation',
                    'other',
                ]),
            ],

            'evidence' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ], [
            'advertisement_id.required' => 'একটি বিজ্ঞাপন নির্বাচন করুন।',
            'complaint_type.required' => 'অভিযোগের ধরন নির্বাচন করুন।',
            'description.required' => 'অভিযোগের বিস্তারিত লিখুন।',
            'description.min' => 'অভিযোগের বিবরণ কমপক্ষে ১০ অক্ষরের হতে হবে।',
            'evidence.image' => 'প্রমাণ হিসেবে একটি বৈধ ছবি দিন।',
            'evidence.max' => 'ছবির সাইজ সর্বোচ্চ ৫ MB হতে পারবে।',
        ]);

        // Only allow complaints against currently published ads.
        $advertisement = Advertisement::published()
            ->whereKey($validated['advertisement_id'])
            ->firstOrFail();

        // Save optional evidence image.
        $evidencePath = null;

        if ($request->hasFile('evidence')) {
            $evidencePath = $request->file('evidence')
                ->store('advertisement-complaints', 'public');
        }

        // Generate unique complaint code.
        do {
            $complaintCode = 'OS-CMP-' . strtoupper(Str::random(8));
        } while (
            AdvertisementComplaint::where(
                'complaint_code',
                $complaintCode
            )->exists()
        );

        $complaint = AdvertisementComplaint::create([
            'complaint_code' => $complaintCode,
            'user_id' => auth()->id(),
            'advertisement_id' => $advertisement->id,
            'complaint_type' => $validated['complaint_type'],
            'description' => $validated['description'],
            'evidence' => $evidencePath,
            'desired_resolution' => $validated['desired_resolution'] ?? null,
            'status' => 'received',
        ]);

        return redirect()
            ->route('dashboard.advertisement-complaints.show', $complaint->id)
            ->with('success', 'আপনার অভিযোগ সফলভাবে জমা হয়েছে।');
    }

    /**
     * Customer's complaint list.
     */
    public function complaintindex()
    {
        $complaints = AdvertisementComplaint::with('advertisement')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view(
            'backend.advertisement_complaints.index',
            compact('complaints')
        );
    }

    /**
     * Show one complaint belonging to logged-in customer.
     */
    public function complaintshow($id)
    {
        $complaint = AdvertisementComplaint::with('advertisement')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view(
            'backend.advertisement_complaints.show',
            compact('complaint')
        );
    }














}
