@extends('apps.dashboard_master')

@section('content')

@include('backend.patrials.top_bar')

<div class="max-w-4xl mx-auto px-4 py-6">

    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('dashboard.advertisement-complaints.index') }}"
           class="text-sm text-green-700 hover:underline">
            ← আমার অভিযোগসমূহ
        </a>

        <h2 class="text-2xl font-bold text-gray-800 mt-3">
            অভিযোগ জমা দিন
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Online Shoday-এর কোনো সেবা বা বিজ্ঞাপন নিয়ে সমস্যা হলে বিস্তারিত জানান।
        </p>
    </div>

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-5">
            <p class="font-semibold mb-2">অনুগ্রহ করে নিচের বিষয়গুলো ঠিক করুন:</p>

            <ul class="list-disc pl-5 text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dashboard.advertisement-complaints.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 sm:p-7 space-y-5">

        @csrf

        {{-- Advertisement --}}


<div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">
        সংশ্লিষ্ট বিজ্ঞাপন <span class="text-red-500">*</span>
    </label>

    <select name="advertisement_id"
            required
            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500">

        <option value="">বিজ্ঞাপন নির্বাচন করুন</option>

        @foreach($advertisements as $ad)

            <option value="{{ $ad->id }}"
                {{ old('advertisement_id', $selectedAdvertisement?->id) == $ad->id ? 'selected' : '' }}>

                {{ $ad->title }}
                — বিজ্ঞাপনদাতা:
                {{ $ad->user?->name ?? $ad->provider_name ?? 'তথ্য পাওয়া যায়নি' }}

            </option>

        @endforeach

    </select>

    @error('advertisement_id')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>


        {{-- Complaint Type --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                অভিযোগের ধরন <span class="text-red-500">*</span>
            </label>

            <select name="complaint_type"
                    required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500">

                <option value="">অভিযোগের ধরন নির্বাচন করুন</option>

                <option value="service_not_received" @selected(old('complaint_type') == 'service_not_received')>
                    সেবা না পাওয়া
                </option>

                <option value="fraud" @selected(old('complaint_type') == 'fraud')>
                    প্রতারণা বা জালিয়াতি
                </option>

                <option value="wrong_information" @selected(old('complaint_type') == 'wrong_information')>
                    বিজ্ঞাপনে ভুল তথ্য
                </option>

                <option value="extra_charge" @selected(old('complaint_type') == 'extra_charge')>
                    অতিরিক্ত টাকা দাবি
                </option>

                <option value="bad_behavior" @selected(old('complaint_type') == 'bad_behavior')>
                    খারাপ ব্যবহার
                </option>

                <option value="poor_service" @selected(old('complaint_type') == 'poor_service')>
                    নিম্নমানের সেবা
                </option>

                <option value="other" @selected(old('complaint_type') == 'other')>
                    অন্যান্য
                </option>

            </select>

            @error('complaint_type')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                অভিযোগের বিস্তারিত <span class="text-red-500">*</span>
            </label>

            <textarea name="description"
                      rows="5"
                      required
                      minlength="10"
                      maxlength="5000"
                      placeholder="আপনার সমস্যাটি বিস্তারিত লিখুন..."
                      class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500">{{ old('description') }}</textarea>

            <p class="text-xs text-gray-400 mt-1">
                কী ঘটেছে, কখন ঘটেছে এবং কার সঙ্গে ঘটেছে তা লিখুন।
            </p>

            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Evidence --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                প্রমাণের ছবি (ঐচ্ছিক)
            </label>

            <input type="file"
                   name="evidence"
                   accept="image/jpeg,image/png,image/webp"
                   class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm">

            <p class="text-xs text-gray-400 mt-1">
                JPG, PNG অথবা WEBP; সর্বোচ্চ ৫ MB।
            </p>

            @error('evidence')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Desired Resolution --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                আপনি কী ধরনের সমাধান চান?
            </label>

            <select name="desired_resolution"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500">

                <option value="">নির্বাচন করুন (ঐচ্ছিক)</option>

                <option value="get_service" @selected(old('desired_resolution') == 'get_service')>
                    প্রতিশ্রুত সেবা পেতে চাই
                </option>

                <option value="refund" @selected(old('desired_resolution') == 'refund')>
                    টাকা ফেরত চাই
                </option>

                <option value="contact" @selected(old('desired_resolution') == 'contact')>
                    আমার সঙ্গে যোগাযোগ করা হোক
                </option>

                <option value="investigation" @selected(old('desired_resolution') == 'investigation')>
                    বিষয়টি তদন্ত করা হোক
                </option>

                <option value="other" @selected(old('desired_resolution') == 'other')>
                    অন্যান্য
                </option>

            </select>
        </div>

        {{-- Notice --}}
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
            <div class="flex gap-2">
                <span class="text-xl">ℹ️</span>
                <p class="text-sm text-yellow-800">
                    সঠিক তথ্য দিয়ে অভিযোগ জমা দিন। Online Shoday অভিযোগটি যাচাই করে প্রয়োজনীয় ব্যবস্থা নেওয়ার চেষ্টা করবে।
                </p>
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-xl transition">
            অভিযোগ জমা দিন
        </button>

    </form>

</div>

@endsection
