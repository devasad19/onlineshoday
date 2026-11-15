
@extends('apps.front_master')

@section('content')

@php
    $adTypeLabels = [
        'own_service' => 'নিজস্ব সেবা',
        'partner_service' => 'পার্টনার সেবা',
        'general_ad' => 'সাধারণ বিজ্ঞাপন',
    ];

    $adTypeColors = [
        'own_service' => 'bg-green-100 text-green-700',
        'partner_service' => 'bg-blue-100 text-blue-700',
        'general_ad' => 'bg-orange-100 text-orange-700',
    ];
@endphp

<div class="bg-gray-50 min-h-screen py-8 sm:py-10">

    <div class="max-w-7xl mx-auto px-4 sm:px-6">

        {{-- Page Heading --}}
        <div class="mb-7">
            <p class="text-sm text-green-600 font-semibold mb-2">
                🏪 Online Shoday
            </p>

            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
                স্থানীয় সেবা ও বিজ্ঞাপন
            </h1>

            <p class="text-gray-500 mt-2">
                আপনার এলাকার প্রয়োজনীয় সেবা, পণ্য ও বিজ্ঞাপন এক জায়গায়।
            </p>
        </div>

        {{-- Notice / Offer Banner --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-green-700 to-green-500 rounded-2xl p-5 sm:p-7 mb-8 text-white">

            <div class="relative z-10 max-w-3xl">

                <span class="inline-block bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full mb-3">
                    📣 স্থানীয় ব্যবসায়ীদের জন্য
                </span>

                <h2 class="text-xl sm:text-2xl font-bold mb-2">
                    আপনার ব্যবসা বা সেবার প্রচার করুন Online Shoday-তে!
                </h2>

                <p class="text-sm sm:text-base text-green-50 leading-7">
                    আপনার দোকান, পণ্য, বাসা ভাড়া, চাকরি কিংবা যেকোনো স্থানীয় সেবার বিজ্ঞাপন
                    আমাদের মাধ্যমে এলাকার মানুষের কাছে পৌঁছে দিন।
                </p>

                <p class="text-xs text-green-100 mt-3">
                    বিজ্ঞাপন প্রকাশের আগে Online Shoday কর্তৃপক্ষ যাচাই করবে।
                </p>

            </div>

            <div class="absolute -right-5 -bottom-10 text-white/10 text-9xl">
                📢
            </div>

        </div>

 
{{-- Search and Filters --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-5 mb-7">

    <form id="adFilterForm"
          action="{{ route('advertisements.index') }}"
          method="GET">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-2">
                    বিজ্ঞাপন খুঁজুন
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="নাম, সেবা বা এলাকা লিখুন..."
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                >
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-2">
                    ক্যাটাগরি
                </label>

                <select name="category"
                        class="w-full border border-gray-200 rounded-xl px-3 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-green-500">

                    <option value="">সকল ক্যাটাগরি</option>

                    @foreach($categories as $category)
                        <option value="{{ $category }}"
                            {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-2">
                    বিজ্ঞাপনের ধরন
                </label>

                <select name="ad_type"
                        class="w-full border border-gray-200 rounded-xl px-3 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-green-500">

                    <option value="">সকল ধরন</option>
                    <option value="own_service" {{ request('ad_type') == 'own_service' ? 'selected' : '' }}>
                        নিজস্ব সেবা
                    </option>
                    <option value="partner_service" {{ request('ad_type') == 'partner_service' ? 'selected' : '' }}>
                        পার্টনার সেবা
                    </option>
                    <option value="general_ad" {{ request('ad_type') == 'general_ad' ? 'selected' : '' }}>
                        সাধারণ বিজ্ঞাপন
                    </option>

                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-2">
                    সাজান
                </label>

                <select name="sort"
                        class="w-full border border-gray-200 rounded-xl px-3 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-green-500">

                    <option value="featured" {{ request('sort', 'featured') == 'featured' ? 'selected' : '' }}>
                        গুরুত্বপূর্ণ আগে
                    </option>
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                        নতুন আগে
                    </option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                        পুরাতন আগে
                    </option>

                </select>
            </div>

        </div>

        <div class="flex flex-wrap gap-3 mt-4">

            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold text-sm px-6 py-3 rounded-xl transition">
                🔍 খুঁজুন
            </button>

            <button type="reset"
                    id="resetAdFilters"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-sm px-6 py-3 rounded-xl transition">
                ফিল্টার মুছুন
            </button>

        </div>

    </form>
</div>


{{-- Results --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">

    <div>
        <h2 class="text-xl font-bold text-gray-800">
            সকল বিজ্ঞাপন
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            মোট <span id="adResultCount">{{ $advertisements->total() }}</span>টি বিজ্ঞাপন পাওয়া গেছে
        </p>
    </div>

    <span id="adLoading"
          class="hidden text-sm text-green-600 font-semibold">
        <span class="animate-pulse">●</span> খোঁজা হচ্ছে...
    </span>
<div id="adResultCount">
    {{ $advertisements->total() }}
</div>
</div>

<div id="adResults">
    @include('advertisements.partials.cards')
</div>

    

         


    </div>

</div>

@endsection
@section('scripts')

 
<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('adFilterForm');
    const results = document.getElementById('adResults');
    const count = document.getElementById('adResultCount');
    const loading = document.getElementById('adLoading');
    const resetBtn = document.getElementById('resetAdFilters');

    if (!form || !results) return;

    let timer;
    let controller;

    function loadAds(url = null, updateHistory = true) {

        if (controller) controller.abort();
        controller = new AbortController();

        const requestUrl = url || (
            form.action + '?' + new URLSearchParams(
                new FormData(form)
            ).toString()
        );

        loading?.classList.remove('hidden');
        results.style.opacity = '0.5';

        fetch(requestUrl, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            signal: controller.signal
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Server error: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            results.innerHTML = data.html;
            if (count) count.textContent = data.count;

            if (updateHistory) {
                history.pushState({}, '', requestUrl);
            }
        })
        .catch(error => {
            if (error.name !== 'AbortError') {
                console.error(error);
                alert('বিজ্ঞাপন লোড করা যায়নি। আবার চেষ্টা করুন।');
            }
        })
        .finally(() => {
            loading?.classList.add('hidden');
            results.style.opacity = '1';
        });
    }

    // Search
    const searchInput = form.querySelector('[name="search"]');

    searchInput?.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(() => loadAds(), 400);
    });

    // Select filters
    form.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', () => loadAds());
    });

    // Prevent normal form submission
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        loadAds();
    });

    // Reset filters
    resetBtn?.addEventListener('click', function () {
        form.reset();
        loadAds();
    });

    // AJAX pagination
    results.addEventListener('click', function (e) {
        const link = e.target.closest('#adPagination a');

        if (!link) return;

        e.preventDefault();
        loadAds(link.href);
    });

    // Browser back/forward
    window.addEventListener('popstate', function () {
        const params = new URLSearchParams(location.search);

        form.querySelectorAll('[name]').forEach(input => {
            input.value = params.get(input.name) || '';
        });

        loadAds(location.href, false);
    });

});
</script>

 
@endsection
