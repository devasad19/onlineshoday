
@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    {{-- Title --}}
    <div class="md:col-span-2">
        <label class="block font-medium mb-2">বিজ্ঞাপনের শিরোনাম *</label>
        <input type="text" name="title"
               value="{{ old('title', $advertisement->title ?? '') }}"
               required
               class="w-full border rounded-lg p-3">
    </div>

    {{-- Category --}}
    <div>
    <label class="block font-medium mb-2">ক্যাটাগরি নির্বাচন করুন *</label>
<select name="category" required class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500">
    <option value="">নির্বাচন করুন</option>

    @foreach(
        \App\Models\AdvertisementCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get() as $category
    )
        <option value="{{ $category->name }}"
            {{ old('category', $advertisement->category ?? '') == $category->name ? 'selected' : '' }}>
            {{ $category->icon }} {{ $category->name }}
        </option>
    @endforeach
</select>
</div>
    {{-- Advertisement Type --}}
<div>
    <label class="block font-medium mb-2">বিজ্ঞাপনের ধরন *</label>

    <select name="ad_type" id="ad_type" required
        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500">

        <option value="own_service"
            @selected(old('ad_type', $advertisement->ad_type ?? '') == 'own_service')>
            Online Shoday-এর নিজস্ব সেবা
        </option>

        <option value="partner_service"
            @selected(old('ad_type', $advertisement->ad_type ?? '') == 'partner_service')>
            পার্টনার সেবা
        </option>

        <option value="general_ad"
            @selected(old('ad_type', $advertisement->ad_type ?? '') == 'general_ad')>
            সাধারণ বিজ্ঞাপন
        </option>

    </select>
</div>

    {{-- Provider --}}
    <div>
        <label class="block font-medium mb-2">সেবা প্রদানকারী / প্রতিষ্ঠানের নাম</label>

    <input type="text"
        name="provider_name"
        id="provider_name"
        value="{{ old('provider_name', $advertisement->provider_name ?? '') }}"
        class="form-input w-full border rounded-lg p-3"
        placeholder="বিজ্ঞাপনদাতার নাম লিখুন"
        required>

@error('provider_name')
    <span class="text-red-500 text-sm">{{ $message }}</span>
@enderror
    </div>

{{-- প্রদানকারীর পরিচয় --}}
<div>
    <label class="block font-medium mb-2">প্রদানকারীর পরিচয়</label>

    <input type="text" name="provider_type" id="provider_type"
        value="{{ old('provider_type', $advertisement->provider_type ?? '') }}"
        class="w-full border rounded-lg p-3"
        placeholder="যেমন: নিজস্ব / পার্টনার / বিজ্ঞাপনদাতা">
</div>

    {{-- Short Description --}}
    <div class="md:col-span-2">
        <label class="block font-medium mb-2">সংক্ষিপ্ত বিবরণ *</label>

        <textarea name="short_description" rows="2"
                  class="w-full border rounded-lg p-3" required>{{ old('short_description', $advertisement->short_description ?? '') }}</textarea>
    </div>

    {{-- Description --}}
    <div class="md:col-span-2">
        <label class="block font-medium mb-2">বিস্তারিত বিবরণ *</label>

        <textarea name="description" rows="6"
                  class="w-full border rounded-lg p-3" required>{{ old('description', $advertisement->description ?? '') }}</textarea>
    </div>

    {{-- Image --}}
    <div>
        <label class="block font-medium mb-2">বিজ্ঞাপনের ছবি *</label>

        <input type="file" name="image"
               accept="image/jpeg,image/png,image/webp"
               class="w-full border rounded-lg p-3" required>

        @if(isset($advertisement) && $advertisement->image)
            <img src="{{ asset('uploads/advertisements/'.$advertisement->image) }}"
                 class="w-24 h-20 object-cover mt-2 rounded">
        @endif
    </div>

{{-- ঠিকানা / সেবার এলাকা --}}
<div>
    <label class="block font-medium mb-2">ঠিকানা / সেবার এলাকা</label>

    <input type="text" name="location" id="location"
        value="{{ old('location', $advertisement->location ?? '') }}"
        class="w-full border rounded-lg p-3">
</div>

{{-- যোগাযোগ নম্বর --}}
<div>
    <label class="block font-medium mb-2">যোগাযোগ নম্বর</label>

    <input type="text" name="phone" id="phone"
        value="{{ old('phone', $advertisement->phone ?? '') }}"
        class="w-full border rounded-lg p-3">
</div>

    {{-- Price --}}
    <div>
        <label class="block font-medium mb-2">মূল্য / চার্জ</label>

        <input type="text" name="price_label"
               value="{{ old('price_label', $advertisement->price_label ?? 'কাজ অনুযায়ী আলোচনা করে নির্ধারণ।') }}"
               class="w-full border rounded-lg p-3"
               placeholder="যেমন: কাজ অনুযায়ী / ৳500">
    </div>

    {{-- Expiry --}}
    <div>
        <label class="block font-medium mb-2">বিজ্ঞাপনের মেয়াদ শেষ</label>

        <input type="datetime-local" name="expires_at"
               value="{{ old('expires_at', isset($advertisement) && $advertisement->expires_at ? $advertisement->expires_at->format('Y-m-d\TH:i') : '') }}"
               class="w-full border rounded-lg p-3">
        <p class="text-xs text-gray-500 mt-1">খালি রাখলে মেয়াদ শেষ হবে না।</p>
    </div>

    {{-- Featured --}}
    <div class="md:col-span-2">
        <label class="flex items-center gap-2">
            <input type="checkbox" name="is_featured" value="1"
                @checked(old('is_featured', $advertisement->is_featured ?? false))>
            <span>Featured Advertisement হিসেবে দেখান</span>
        </label>
    </div>

</div>

<div class="mt-6 flex gap-3">

    <button type="submit"
            class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
        Save & Publish
    </button>

    <a href="{{ route('admin.advertisements.index') }}"
       class="bg-gray-200 px-6 py-3 rounded-lg">
        Cancel
    </a>

</div>
