
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
        <label class="block font-medium mb-2">ক্যাটাগরি *</label>

        <select name="category" required class="w-full border rounded-lg p-3">
            @foreach([
                'নাগরিক সেবা',
                'বাসা ও মেরামত',
                'খাবার ও মিল',
                'ডিজিটাল ও আইটি',
                'স্থানীয় বিজ্ঞাপন'
            ] as $category)

                <option value="{{ $category }}"
                    @selected(old('category', $advertisement->category ?? '') == $category)>
                    {{ $category }}
                </option>

            @endforeach
        </select>
    </div>

    {{-- Advertisement Type --}}
    <div>
        <label class="block font-medium mb-2">বিজ্ঞাপনের ধরন *</label>

        <select name="ad_type" required class="w-full border rounded-lg p-3">

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

        <input type="text" name="provider_name"
               value="{{ old('provider_name', $advertisement->provider_name ?? '') }}"
               class="w-full border rounded-lg p-3"
               placeholder="যেমন: Online Shoday">
    </div>

    {{-- Provider Type --}}
    <div>
        <label class="block font-medium mb-2">প্রদানকারীর পরিচয়</label>

        <input type="text" name="provider_type"
               value="{{ old('provider_type', $advertisement->provider_type ?? '') }}"
               class="w-full border rounded-lg p-3"
               placeholder="যেমন: নিজস্ব / পার্টনার / বিজ্ঞাপনদাতা">
    </div>

    {{-- Short Description --}}
    <div class="md:col-span-2">
        <label class="block font-medium mb-2">সংক্ষিপ্ত বিবরণ</label>

        <textarea name="short_description" rows="2"
                  class="w-full border rounded-lg p-3">{{ old('short_description', $advertisement->short_description ?? '') }}</textarea>
    </div>

    {{-- Description --}}
    <div class="md:col-span-2">
        <label class="block font-medium mb-2">বিস্তারিত বিবরণ</label>

        <textarea name="description" rows="6"
                  class="w-full border rounded-lg p-3">{{ old('description', $advertisement->description ?? '') }}</textarea>
    </div>

    {{-- Image --}}
    <div>
        <label class="block font-medium mb-2">বিজ্ঞাপনের ছবি</label>

        <input type="file" name="image"
               accept="image/jpeg,image/png,image/webp"
               class="w-full border rounded-lg p-3">

        @if(isset($advertisement) && $advertisement->image)
            <img src="{{ asset('storage/'.$advertisement->image) }}"
                 class="w-24 h-20 object-cover mt-2 rounded">
        @endif
    </div>

    {{-- Location --}}
    <div>
        <label class="block font-medium mb-2">ঠিকানা / সেবার এলাকা</label>

        <input type="text" name="location"
               value="{{ old('location', $advertisement->location ?? '') }}"
               class="w-full border rounded-lg p-3">
    </div>

    {{-- Phone --}}
    <div>
        <label class="block font-medium mb-2">যোগাযোগ নম্বর</label>

        <input type="text" name="phone"
               value="{{ old('phone', $advertisement->phone ?? '') }}"
               class="w-full border rounded-lg p-3">
    </div>

    {{-- Price --}}
    <div>
        <label class="block font-medium mb-2">মূল্য / চার্জ</label>

        <input type="text" name="price_label"
               value="{{ old('price_label', $advertisement->price_label ?? '') }}"
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
