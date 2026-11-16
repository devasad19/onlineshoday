
@extends('apps.dashboard_master')

@section('content')

<div class="max-w-4xl mx-auto px-4 py-6">

    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-bullhorn text-green-600 mr-2"></i>
            নতুন বিজ্ঞাপন জমা দিন
        </h2>
        <p class="text-sm text-gray-500 mt-2">
            আপনার পণ্য, প্রতিষ্ঠান অথবা সেবার বিজ্ঞাপন Online Shoday-এ প্রকাশ করুন।
        </p>
    </div>

    {{-- Notice --}}
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
        <div class="flex gap-3">
            <i class="fas fa-info-circle text-blue-600 mt-1"></i>
            <div class="text-sm text-blue-800">
                বিজ্ঞাপন জমা দেওয়ার পর Admin যাচাই করবেন।
                অনুমোদিত হলে ওয়েবসাইটে প্রকাশিত হবে।
            </div>
        </div>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-5">
            <ul class="list-disc pl-5 space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.advertisements.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm border p-5 md:p-7 space-y-5">

        @csrf

        {{-- Title --}}
        <div>
            <label class="block font-semibold text-gray-700 mb-2">
                বিজ্ঞাপনের শিরোনাম *
            </label>

            <input type="text"
                   name="title"
                   value="{{ old('title') }}"
                   placeholder="যেমন: বাসায় ইলেকট্রিক মেরামতের সেবা"
                   required
                   class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none">
        </div>

        {{-- Category --}}
        <div>
            <label class="block font-semibold text-gray-700 mb-2">
                বিজ্ঞাপনের ক্যাটাগরি *
            </label>

            <select name="category" required
                    class="w-full border rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-green-500 outline-none">

                <option value="">ক্যাটাগরি নির্বাচন করুন</option>

                @foreach([
                    'নাগরিক সেবা',
                    'বাসা ও মেরামত',
                    'খাবার ও মিল',
                    'ডিজিটাল ও আইটি',
                    'স্থানীয় বিজ্ঞাপন'
                ] as $category)

                    <option value="{{ $category }}"
                        {{ old('category') == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>

                @endforeach
            </select>
        </div>

        {{-- Advertisement Type --}}
        <div>
            <label class="block font-semibold text-gray-700 mb-2">
                বিজ্ঞাপনের ধরন *
            </label>

            <div class="grid sm:grid-cols-2 gap-3">

                <label class="border rounded-xl p-4 cursor-pointer hover:border-green-500">
                    <input type="radio"
                           name="ad_type"
                           value="general_ad"
                           {{ old('ad_type', 'general_ad') == 'general_ad' ? 'checked' : '' }}
                           required>

                    <span class="font-semibold text-gray-800 ml-2">
                        সাধারণ বিজ্ঞাপন
                    </span>

                    <p class="text-xs text-gray-500 mt-2">
                        পণ্য, দোকান, চাকরি, বাসা ভাড়া বা অন্যান্য বিজ্ঞাপন।
                    </p>
                </label>

                <label class="border rounded-xl p-4 cursor-pointer hover:border-green-500">
                    <input type="radio"
                           name="ad_type"
                           value="partner_service"
                           {{ old('ad_type') == 'partner_service' ? 'checked' : '' }}>

                    <span class="font-semibold text-gray-800 ml-2">
                        পার্টনার সার্ভিস
                    </span>

                    <p class="text-xs text-gray-500 mt-2">
                        Online Shoday-এর মাধ্যমে সমন্বয় করে সেবা প্রদান।
                    </p>
                </label>

            </div>
        </div>

        {{-- Provider --}}
        <div class="grid sm:grid-cols-2 gap-4">

            <div>
                <label class="block font-semibold text-gray-700 mb-2">
                    প্রতিষ্ঠান / সেবাদাতার নাম *
                </label>

                <input type="text"
                       name="provider_name"
                       value="{{ old('provider_name', auth()->user()->name) }}"
                       required
                       class="w-full border rounded-xl px-4 py-3">
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-2">
                    প্রতিষ্ঠানের ধরন
                </label>

                <input type="text"
                       name="provider_type"
                       value="{{ old('provider_type') }}"
                       placeholder="যেমন: দোকান, ব্যক্তিগত সেবা"
                       class="w-full border rounded-xl px-4 py-3">
            </div>

        </div>

        {{-- Short Description --}}
        <div>
            <label class="block font-semibold text-gray-700 mb-2">
                সংক্ষিপ্ত বিবরণ *
            </label>

            <textarea name="short_description"
                      rows="2"
                      maxlength="300"
                      required
                      placeholder="বিজ্ঞাপন সম্পর্কে সংক্ষেপে লিখুন"
                      class="w-full border rounded-xl px-4 py-3">{{ old('short_description') }}</textarea>

            <p class="text-xs text-gray-400 mt-1">
                সর্বোচ্চ ৩০০ অক্ষর।
            </p>
        </div>

        {{-- Full Description --}}
        <div>
            <label class="block font-semibold text-gray-700 mb-2">
                বিস্তারিত বিবরণ *
            </label>

            <textarea name="description"
                      rows="6"
                      required
                      placeholder="আপনার পণ্য বা সেবা সম্পর্কে বিস্তারিত লিখুন..."
                      class="w-full border rounded-xl px-4 py-3">{{ old('description') }}</textarea>
        </div>

        {{-- Image --}}
        <div>
            <label class="block font-semibold text-gray-700 mb-2">
                বিজ্ঞাপনের ছবি
            </label>

            <input type="file"
                   name="image"
                   accept="image/jpeg,image/png,image/webp"
                   class="w-full border rounded-xl px-4 py-3">

            <p class="text-xs text-gray-500 mt-2">
                JPG, PNG অথবা WEBP। সর্বোচ্চ ২ MB।
            </p>
        </div>

        {{-- Location and Phone --}}
        <div class="grid sm:grid-cols-2 gap-4">

            <div>
                <label class="block font-semibold text-gray-700 mb-2">
                    ঠিকানা / এলাকা *
                </label>

                <input type="text"
                       name="location"
                       value="{{ old('location') }}"
                       placeholder="যেমন: চেচুয়া বাজার"
                       required
                       class="w-full border rounded-xl px-4 py-3">
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-2">
                    যোগাযোগের ফোন নম্বর *
                </label>

                <input type="tel"
                       name="phone"
                       value="{{ old('phone', auth()->user()->phone ?? '') }}"
                       placeholder="01XXXXXXXXX"
                       required
                       class="w-full border rounded-xl px-4 py-3">
            </div>

        </div>

        {{-- Price --}}
        <div>
            <label class="block font-semibold text-gray-700 mb-2">
                মূল্য / সার্ভিস চার্জ
            </label>

            <input type="text"
                   name="price_label"
                   value="{{ old('price_label') }}"
                   placeholder="যেমন: ৫০০ টাকা / আলোচনা সাপেক্ষে / ফ্রি"
                   class="w-full border rounded-xl px-4 py-3">
        </div>

        {{-- Submit --}}
        <div class="pt-4 border-t flex flex-col sm:flex-row gap-3">

            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-7 py-3 rounded-xl transition">
                <i class="fas fa-paper-plane mr-2"></i>
                বিজ্ঞাপন জমা দিন
            </button>

            <a href="{{ route('user.advertisements.index') }}"
               class="text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-7 py-3 rounded-xl">
                বাতিল করুন
            </a>

        </div>

    </form>

</div>

@endsection
