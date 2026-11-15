
@extends('apps.front_master')

@section('content')

@php
    $adTypeLabels = [
        'own_service' => 'অনলাইন সদায়ের নিজস্ব সেবা',
        'partner_service' => 'পার্টনার সেবা',
        'general_ad' => 'সাধারণ বিজ্ঞাপন',
    ];

    $adTypeColors = [
        'own_service' => 'bg-green-100 text-green-700',
        'partner_service' => 'bg-blue-100 text-blue-700',
        'general_ad' => 'bg-orange-100 text-orange-700',
    ];

    $phone = preg_replace('/[^0-9+]/', '', $advertisement->phone ?? '');
@endphp

<div class="bg-gray-50 min-h-screen py-8 sm:py-10">

    <div class="max-w-7xl mx-auto px-4 sm:px-6">

        {{-- Breadcrumb --}}
        <div class="text-sm text-gray-500 mb-6">
            <a href="{{ url('/') }}" class="hover:text-green-600">হোম</a>
            <span class="mx-2">/</span>
            <span>স্থানীয় সেবা ও বিজ্ঞাপন</span>
            <span class="mx-2">/</span>
            <span class="text-green-700">{{ $advertisement->title }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

            {{-- Main Advertisement --}}
            <div class="lg:col-span-2">

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                    {{-- Image --}}
                    @if($advertisement->image)
                        <img
                            src="{{ asset('uploads/advertisements/'.$advertisement->image) }}"
                            alt="{{ $advertisement->title }}"
                            class="w-full h-64 sm:h-96 object-cover"
                        >
                    @else
                        <div class="w-full h-64 bg-green-50 flex items-center justify-center">
                            <span class="text-6xl">📢</span>
                        </div>
                    @endif

                    <div class="p-5 sm:p-8">

                        {{-- Category and Type --}}
                        <div class="flex flex-wrap items-center gap-2 mb-4">

                            <span class="bg-gray-100 text-gray-700 px-3 py-1.5 rounded-full text-xs font-semibold">
                                {{ $advertisement->category }}
                            </span>

                            <span class="px-3 py-1.5 rounded-full text-xs font-semibold
                                {{ $adTypeColors[$advertisement->ad_type] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $adTypeLabels[$advertisement->ad_type] ?? 'বিজ্ঞাপন' }}
                            </span>

                            @if($advertisement->is_featured)
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1.5 rounded-full text-xs font-semibold">
                                    ⭐ বিশেষ বিজ্ঞাপন
                                </span>
                            @endif

                        </div>

                        {{-- Title --}}
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 leading-snug">
                            {{ $advertisement->title }}
                        </h1>

                        {{-- Short Description --}}
                        @if($advertisement->short_description)
                            <p class="text-gray-600 text-base sm:text-lg mt-4 leading-7">
                                {{ $advertisement->short_description }}
                            </p>
                        @endif

                        <div class="border-t border-gray-100 my-6"></div>

                        {{-- Price --}}
                        @if($advertisement->price_label)
                            <div class="bg-green-50 rounded-xl p-4 mb-6">
                                <p class="text-sm text-gray-500 mb-1">মূল্য / সার্ভিস চার্জ</p>
                                <p class="text-xl font-bold text-green-700">
                                    {{ $advertisement->price_label }}
                                </p>
                            </div>
                        @endif

                        {{-- Full Description --}}
                        <div>
                            <h2 class="text-lg font-bold text-gray-800 mb-3">
                                📝 বিজ্ঞাপনের বিস্তারিত
                            </h2>

                            <div class="text-gray-600 leading-8 whitespace-pre-line">
                                {{ $advertisement->description ?: 'এই বিজ্ঞাপনের বিস্তারিত তথ্য দেওয়া হয়নি।' }}
                            </div>
                        </div>

                        <div class="border-t border-gray-100 my-7"></div>

                        {{-- Provider Information --}}
                        <div>
                            <h2 class="text-lg font-bold text-gray-800 mb-4">
                                👤 সেবাদাতা / বিজ্ঞাপনদাতার তথ্য
                            </h2>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                                @if($advertisement->provider_name)
                                    <div class="bg-gray-50 rounded-xl p-4">
                                        <p class="text-xs text-gray-500 mb-1">নাম / প্রতিষ্ঠানের নাম</p>
                                        <p class="font-semibold text-gray-800">
                                            {{ $advertisement->provider_name }}
                                        </p>
                                    </div>
                                @endif

                                @if($advertisement->provider_type)
                                    <div class="bg-gray-50 rounded-xl p-4">
                                        <p class="text-xs text-gray-500 mb-1">সেবাদাতার পরিচয়</p>
                                        <p class="font-semibold text-gray-800">
                                            {{ $advertisement->provider_type }}
                                        </p>
                                    </div>
                                @endif

                                @if($advertisement->location)
                                    <div class="bg-gray-50 rounded-xl p-4">
                                        <p class="text-xs text-gray-500 mb-1">ঠিকানা / সেবার এলাকা</p>
                                        <p class="font-semibold text-gray-800">
                                            📍 {{ $advertisement->location }}
                                        </p>
                                    </div>
                                @endif

                                <div class="bg-gray-50 rounded-xl p-4">
                                    <p class="text-xs text-gray-500 mb-1">প্রকাশের তারিখ</p>
                                    <p class="font-semibold text-gray-800">
                                        {{ $advertisement->created_at->format('d-m-Y') }}
                                    </p>
                                </div>

                            </div>
                        </div>

                        {{-- Contact --}}
                        <div class="border-t border-gray-100 my-7"></div>

                        <div class="bg-green-50 border border-green-100 rounded-2xl p-5 sm:p-6">

                            <h2 class="text-lg font-bold text-gray-800 mb-2">
                                📞 যোগাযোগ করুন
                            </h2>

                            @if($phone)
                                <p class="text-gray-600 text-sm mb-4">
                                    বিজ্ঞাপনদাতার সঙ্গে সরাসরি যোগাযোগ করতে নিচের বাটনে ক্লিক করুন।
                                </p>

                                <a href="tel:{{ $phone }}"
                                   class="inline-flex items-center justify-center gap-2 w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-bold px-7 py-3 rounded-xl transition">
                                    📞 কল করুন: {{ $advertisement->phone }}
                                </a>
                            @else
                                <p class="text-sm text-gray-600">
                                    দুঃখিত, এই বিজ্ঞাপনে যোগাযোগের ফোন নম্বর দেওয়া হয়নি।
                                </p>
                            @endif

                        </div>

                    </div>
                </div>

            </div>

            {{-- Right Sidebar: Other Ads --}}
            <aside class="lg:col-span-1">

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">

                    <h2 class="text-lg font-bold text-gray-800 mb-5 flex items-center gap-2">
                        📢 অন্যান্য বিজ্ঞাপন
                    </h2>

                    <div class="space-y-5">

                        @forelse($otherAds as $otherAd)

                            <a href="{{ route('advertisement.show', $otherAd->slug) }}"
                               class="flex gap-3 group">

                                <div class="w-24 h-20 flex-shrink-0 rounded-xl overflow-hidden bg-gray-100">

                                    @if($otherAd->image)
                                        <img src="{{ asset('uploads/advertisements/'.$otherAd->image) }}"
                                             alt="{{ $otherAd->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-2xl">
                                            📢
                                        </div>
                                    @endif

                                </div>

                                <div class="min-w-0">
                                    <h3 class="font-semibold text-gray-800 text-sm leading-5 group-hover:text-green-700 line-clamp-2">
                                        {{ $otherAd->title }}
                                    </h3>

                                    <p class="text-xs text-gray-500 mt-2">
                                        📍 {{ $otherAd->location ?: 'এলাকা উল্লেখ নেই' }}
                                    </p>

                                    @if($otherAd->price_label)
                                        <p class="text-sm font-bold text-green-700 mt-1">
                                            {{ $otherAd->price_label }}
                                        </p>
                                    @endif
                                </div>

                            </a>

                            @if(!$loop->last)
                                <div class="border-b border-gray-100"></div>
                            @endif

                        @empty
                            <p class="text-sm text-gray-500">
                                আপাতত অন্য কোনো বিজ্ঞাপন নেই।
                            </p>
                        @endforelse

                    </div>

                    <a href="{{ url('/advertisements') }}"
                       class="block text-center mt-6 bg-green-50 hover:bg-green-600 text-green-700 hover:text-white font-semibold text-sm py-3 rounded-xl transition">
                        সব বিজ্ঞাপন দেখুন →
                    </a>

                </div>

            </aside>

        </div>

        {{-- Related Ads --}}
        @if($relatedAds->count())

            <div class="mt-10">

                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                        🔎 সম্পর্কিত বিজ্ঞাপন
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                    @foreach($relatedAds as $relatedAd)

                        <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition">

                            <a href="{{ route('advertisement.show', $relatedAd->slug) }}">

                                @if($relatedAd->image)
                                    <img src="{{ asset('uploads/advertisements/'.$relatedAd->image) }}"
                                         alt="{{ $relatedAd->title }}"
                                         class="w-full h-44 object-cover">
                                @else
                                    <div class="w-full h-44 bg-green-50 flex items-center justify-center text-4xl">
                                        📢
                                    </div>
                                @endif

                                <div class="p-4">

                                    <h3 class="font-bold text-gray-800 hover:text-green-700 line-clamp-2 min-h-12">
                                        {{ $relatedAd->title }}
                                    </h3>

                                    <p class="text-xs text-gray-500 mt-2">
                                        📍 {{ $relatedAd->location ?: 'এলাকা উল্লেখ নেই' }}
                                    </p>

                                    @if($relatedAd->price_label)
                                        <p class="font-bold text-green-700 mt-3">
                                            {{ $relatedAd->price_label }}
                                        </p>
                                    @endif

                                    <span class="block mt-4 text-center bg-green-50 text-green-700 font-semibold text-sm py-2.5 rounded-lg">
                                        বিস্তারিত দেখুন →
                                    </span>

                                </div>

                            </a>

                        </div>

                    @endforeach

                </div>

            </div>

        @endif

    </div>
</div>

@endsection
