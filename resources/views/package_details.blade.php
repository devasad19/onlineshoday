@extends('apps.front_master')
@section('content')


<!-- =========================================================
     PACKAGE DETAILS
========================================================= -->

<section class="bg-gray-50 min-h-screen py-6 sm:py-10">

    <div class="max-w-7xl mx-auto px-4 sm:px-6">


        <!-- Breadcrumb -->

        <div class="flex items-center gap-2 text-sm text-gray-500 mb-5">

            <a href="{{ url('/') }}"
               class="hover:text-green-600">
                🏠 হোম
            </a>

            <span>›</span>
            <a href="{{ url('/') }}"
               class="hover:text-green-600">
                প্যাকেজ
            </a>
            
            <span>›</span>
            <span class="text-gray-700">
                {{ $package->name }}
            </span>

        </div>



        <!-- =====================================================
             MAIN PACKAGE
        ====================================================== -->

        <div class="bg-white rounded-2xl shadow-sm
                    border border-gray-100
                    overflow-hidden">

            <div class="grid grid-cols-1 lg:grid-cols-2">


                <!-- ================= IMAGE ================= -->

                <div class="relative bg-gray-100">

                    <img src="{{ url('uploads/packages/'.$package->image) }}"
                         alt="{{ $package->name }}"
                         class="w-full h-full min-h-[300px]
                                lg:min-h-[480px]
                                object-cover">


                    <!-- Discount -->

                    @if($discountPercent > 0)

                        <div class="absolute top-5 left-5
                                    bg-red-500
                                    text-white
                                    px-4 py-2
                                    rounded-full
                                    font-bold
                                    shadow-lg">

                            🏷️ {{ bnNum($discountPercent) }}% ছাড়

                        </div>

                    @endif


                    <!-- Favorite -->

                    <button type="button"
                            class="absolute top-5 right-5
                                   w-11 h-11
                                   bg-white
                                   rounded-full
                                   shadow-md
                                   flex items-center justify-center
                                   hover:scale-110
                                   transition">

                        <span class="text-2xl text-gray-500">
                            ♡
                        </span>

                    </button>

                </div>



                <!-- ================= PACKAGE INFO ================= -->

                <div class="p-5 sm:p-7 lg:p-9">


                    <!-- Package Name -->

                    <h1 class="text-2xl sm:text-3xl
                               font-bold
                               text-gray-800
                               leading-tight">

                        {{ $package->name }}

                    </h1>



                    <!-- Package Short Info -->

                    <div class="flex flex-wrap items-center gap-3 mt-4">


                        <!-- Products -->

                        <div class="flex items-center gap-2
                                    bg-green-50
                                    text-green-700
                                    px-3 py-1.5
                                    rounded-full
                                    text-sm">

                            <span>📦</span>

                            <span>
                                {{ bnNum($package->package_items->count()) }}
                                টি পণ্য
                            </span>

                        </div>


                        @if($package->availability > 0)

                            <div class="flex items-center gap-2
                                        bg-blue-50
                                        text-blue-700
                                        px-3 py-1.5
                                        rounded-full
                                        text-sm">

                                <span>✓</span>

                                <span>
                                    বর্তমানে পাওয়া যাচ্ছে
                                </span>

                            </div>

                        @endif

                    </div>



                    <!-- Description -->

                    @if($package->description)

                        <div class="mt-5">

                            <p class="text-gray-600
                                      leading-7
                                      text-sm sm:text-base">

                                {{ $package->description }}

                            </p>

                        </div>

                    @endif



                    <!-- ================= PRICE ================= -->

                    <div class="mt-6
                                bg-green-50
                                rounded-xl
                                p-4 sm:p-5">


                        <div class="flex items-end
                                    gap-3
                                    flex-wrap">


                            <!-- Discount Price -->

                            <span class="text-3xl sm:text-4xl
                                         font-bold
                                         text-green-700">

                                ৳{{ bnNum($discountPrice) }}.০০

                            </span>


                            <!-- Old Price -->

                            @if($discountPercent > 0)

                                <span class="text-lg
                                             text-gray-400
                                             line-through
                                             mb-1">

                                    ৳{{ bnNum($oldPrice) }}.০০

                                </span>

                            @endif

                        </div>


                        @if($discountPercent > 0)

                            <p class="text-sm
                                      text-red-500
                                      mt-1">

                                🎉 আপনি
                                {{ bnNum($discountPercent) }}%
                                সাশ্রয় করছেন

                            </p>

                        @endif

                    </div>



                    <!-- ================= CART BUTTON ================= -->

                    <div class="mt-6">

                        <button type="button"

                                class="addToCartBtn
                                       w-full
                                       bg-green-600
                                       hover:bg-green-700
                                       text-white
                                       font-bold
                                       py-3.5
                                       rounded-xl
                                       shadow-sm
                                       transition
                                       flex
                                       items-center
                                       justify-center
                                       gap-2"

                                data-id="{{ $package->id }}"
                                data-name="{{ $package->name }}"
                                data-price="{{ $discountPrice }}"
                                data-image="{{ url('uploads/packages/'.$package->image) }}">


                            <span class="text-xl">
                                🛒
                            </span>

                            <span>
                                প্যাকেজটি কার্টে যোগ করুন
                            </span>

                        </button>

                    </div>


                    <!-- Small Note -->

                    <div class="flex items-start gap-2
                                mt-4
                                text-sm
                                text-gray-500">

                        <span>🔒</span>

                        <p>
                            পুরো প্যাকেজটি একসাথে অর্ডার হবে।
                            প্যাকেজের ভিতরের পণ্য আলাদাভাবে
                            quantity পরিবর্তন করা যাবে না।
                        </p>

                    </div>

                </div>

            </div>

        </div>



        <!-- =====================================================
             PACKAGE PRODUCTS
        ====================================================== -->

        <div class="mt-8 sm:mt-10">

    <!-- Heading -->
    <div class="flex items-center justify-between mb-4">

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                📦 প্যাকেজে যা যা থাকছে
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                এই প্যাকেজের সম্পূর্ণ পণ্য তালিকা
            </p>
        </div>

        <div class="hidden sm:block bg-green-50 text-green-700
                    px-3 py-1.5 rounded-full text-sm font-medium">

            {{ bnNum($package->package_items->count()) }} টি পণ্য

        </div>

    </div>


    <!-- Products List -->
    <div class="bg-yellow-50 rounded-2xl border border-gray-100
                shadow-sm overflow-hidden">

        <div class="grid grid-cols-1 md:grid-cols-2">

            @forelse($package->package_items as $item)

                <div class="flex items-center gap-3
                            px-3 py-3 sm:px-4
                            border-b border-gray-100
                            md:odd:border-r
                            hover:bg-gray-50
                            transition">

                    <!-- Product Image -->
                    <div class="w-12 h-12 sm:w-14 sm:h-14
                                flex-shrink-0
                                rounded-lg overflow-hidden
                                bg-gray-100 border">

                        @if($item->product && $item->product->image)

                            <img src="{{ url('uploads/products/'.$item->product->image) }}"
                                 alt="{{ $item->product->name }}"
                                 class="w-full h-full object-cover">

                        @else

                            <div class="w-full h-full flex items-center
                                        justify-center text-xl">
                                📦
                            </div>

                        @endif

                    </div>


                    <!-- Product Name -->
                    <div class="flex-1 min-w-0">

                        <h3 class="font-semibold text-gray-800
                                   text-sm sm:text-base
                                   truncate">

                            {{ $item->product->name ?? 'Product not found' }}

                        </h3>

                        <div class="flex items-center gap-1
                                    text-xs sm:text-sm
                                    text-gray-500 mt-0.5">

                            <span>⚖️</span>

                            <span>
                                {{ bnNum($item->quantity) }}
                                {{ $item->unit ?: ($item->product->unit ?? '') }}
                            </span>

                        </div>

                    </div>


                    <!-- Price -->
                    <div class="text-right flex-shrink-0">

                        @if(isset($item->price))

                            <div class="font-bold text-green-700
                                        text-sm sm:text-base">

                                ৳{{ bnNum($item->price * $item->quantity) }}

                            </div>

                            <div class="text-[10px] sm:text-xs text-gray-400">

                                ৳{{ bnNum($item->price) }}/{{ $item->unit }}

                            </div>

                        @endif

                    </div>

                </div>

            @empty

                <div class="col-span-full text-center
                            text-gray-500 py-10">

                    📦 এই প্যাকেজে কোনো পণ্য নেই।

                </div>

            @endforelse

        </div>

    </div>

</div>


        <!-- =====================================================
             RELATED / OTHER PACKAGES
        ====================================================== -->

        @if($relatedPackages->count())

            <div class="mt-10 sm:mt-14">


                <!-- Heading -->

                <div class="flex items-center
                            justify-between
                            mb-5">

                    <div>

                        <h2 class="text-xl sm:text-2xl
                                   font-bold
                                   text-gray-800">

                            🛍️ আরও কিছু প্যাকেজ

                        </h2>

                        <p class="text-sm
                                  text-gray-500
                                  mt-1">

                            আপনার পছন্দ হতে পারে

                        </p>

                    </div>

                </div>



                <!-- Related Grid -->

                <div class="grid grid-cols-1
                            sm:grid-cols-2
                            lg:grid-cols-3
                            gap-5">


                    @foreach($relatedPackages as $related)

                        @php

                            $relatedOldPrice =
                                (float) $related->price;

                            $relatedDiscount =
                                (float) ($related->discount ?? 0);

                            $relatedPrice =
                                $relatedOldPrice -
                                (
                                    $relatedOldPrice *
                                    $relatedDiscount / 100
                                );

                        @endphp


                        <div class="bg-white
                                    rounded-2xl
                                    border border-gray-100
                                    shadow-sm
                                    overflow-hidden
                                    group
                                    hover:shadow-xl
                                    transition">


                            <!-- Image -->

                            <div class="relative overflow-hidden">

                                <img src="{{ url('uploads/packages/'.$related->image) }}"
                                     alt="{{ $related->name }}"
                                     class="w-full h-48
                                            object-cover
                                            group-hover:scale-105
                                            transition duration-500">


                                @if($relatedDiscount > 0)

                                    <div class="absolute top-3 left-3
                                                bg-red-500
                                                text-white
                                                px-3 py-1
                                                rounded-full
                                                text-xs
                                                font-bold">

                                        🏷️
                                        {{ bnNum($relatedDiscount) }}%
                                        ছাড়

                                    </div>

                                @endif

                            </div>



                            <!-- Content -->

                            <div class="p-4">


                                <a href="{{ route('home.package.details', $related->id) }}"
                                   class="font-bold
                                          text-gray-800
                                          hover:text-green-700
                                          line-clamp-1">

                                    {{ $related->name }}

                                </a>


                                <div class="flex items-center
                                            gap-2
                                            mt-2
                                            text-sm
                                            text-gray-500">

                                    <span>📦</span>

                                    <span>
                                        {{ bnNum($related->package_items->count()) }}
                                        টি পণ্য
                                    </span>

                                </div>



                                <!-- Price -->

                                <div class="flex items-center
                                            gap-2
                                            mt-3">


                                    <span class="text-xl
                                                 font-bold
                                                 text-green-700">

                                        ৳{{ bnNum($relatedPrice) }}

                                    </span>


                                    @if($relatedDiscount > 0)

                                        <span class="text-sm
                                                     text-gray-400
                                                     line-through">

                                            ৳{{ bnNum($relatedOldPrice) }}

                                        </span>

                                    @endif

                                </div>



                                <!-- Details -->

                                <a href="{{ route('home.package.details', $related->id) }}"
                                   class="mt-3
                                          w-full
                                          border
                                          border-green-600
                                          text-green-700
                                          hover:bg-green-600
                                          hover:text-white
                                          py-2.5
                                          rounded-xl
                                          text-sm
                                          font-semibold
                                          flex
                                          items-center
                                          justify-center
                                          gap-2
                                          transition">

                                    👁️
                                    বিস্তারিত দেখুন

                                </a>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        @endif
<!-- Package Benefits -->
<div class="mt-8 sm:mt-10">

    <div class="mb-4">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
            💚 এই প্যাকেজের সুবিধা
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            একসাথে প্যাকেজ নিলে যেসব সুবিধা পাবেন
        </p>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

        <!-- Benefit 1 -->
        <div class="bg-white border border-gray-100
                    rounded-xl p-4
                    shadow-sm
                    hover:shadow-md
                    transition">

            <div class="w-10 h-10 rounded-full
                        bg-green-50
                        flex items-center justify-center
                        text-xl mb-3">
                🛒
            </div>

            <h3 class="font-semibold text-gray-800 text-sm sm:text-base">
                প্রয়োজনীয় পণ্য একসাথে
            </h3>

            <p class="text-xs sm:text-sm text-gray-500 mt-1 leading-5">
                এক প্যাকেজেই প্রয়োজনীয় কয়েকটি পণ্য একসাথে পাওয়া যাবে।
            </p>

        </div>


        <!-- Benefit 2 -->
        <div class="bg-white border border-gray-100
                    rounded-xl p-4
                    shadow-sm
                    hover:shadow-md
                    transition">

            <div class="w-10 h-10 rounded-full
                        bg-orange-50
                        flex items-center justify-center
                        text-xl mb-3">
                💰
            </div>

            <h3 class="font-semibold text-gray-800 text-sm sm:text-base">
                সাশ্রয়ী প্যাকেজ মূল্য
            </h3>

            <p class="text-xs sm:text-sm text-gray-500 mt-1 leading-5">
                আলাদা আলাদা করে কেনার বদলে প্যাকেজে পেতে পারেন সাশ্রয়ী দাম।
            </p>

        </div>


        <!-- Benefit 3 -->
        <div class="bg-white border border-gray-100
                    rounded-xl p-4
                    shadow-sm
                    hover:shadow-md
                    transition">

            <div class="w-10 h-10 rounded-full
                        bg-blue-50
                        flex items-center justify-center
                        text-xl mb-3">
                📦
            </div>

            <h3 class="font-semibold text-gray-800 text-sm sm:text-base">
                পণ্য বাছাইয়ের ঝামেলা নেই
            </h3>

            <p class="text-xs sm:text-sm text-gray-500 mt-1 leading-5">
                প্রয়োজনীয় পণ্যগুলো আগে থেকেই একটি প্যাকেজে সাজানো থাকে।
            </p>

        </div>


        <!-- Benefit 4 -->
        <div class="bg-white border border-gray-100
                    rounded-xl p-4
                    shadow-sm
                    hover:shadow-md
                    transition">

            <div class="w-10 h-10 rounded-full
                        bg-purple-50
                        flex items-center justify-center
                        text-xl mb-3">
                🏠
            </div>

            <h3 class="font-semibold text-gray-800 text-sm sm:text-base">
                ঘরে বসেই অর্ডার
            </h3>

            <p class="text-xs sm:text-sm text-gray-500 mt-1 leading-5">
                অনলাইনে অর্ডার করুন, আপনার ঠিকানায় পণ্য পৌঁছে যাবে।
            </p>

        </div>

    </div>

</div>

    </div>

</section>


 <!-- 🛍️ Package Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 pb-14 sm:pb-16">

    <!-- ================= HEADER ================= -->
    <div class="flex flex-col sm:flex-row justify-between items-center
                mb-6 sm:mb-8 gap-3">

        <h3 class="text-xl sm:text-2xl font-bold text-green-700
                   text-center sm:text-left">

            <span class="text-green-600 mr-1">🛒</span>
            আরো বিশেষ কম্বো প্যাক — একসাথে নিন, সাশ্রয় করুন

        </h3>

        <div class="flex items-center gap-2
                    bg-green-50
                    text-green-700
                    px-4 py-2
                    rounded-full
                    text-sm
                    font-medium">

            <span class="text-base">🌿</span>

            <span>সুস্থ থাকুন, ভালো থাকুন</span>

        </div>

    </div>


    <!-- ================= PACKAGE GRID ================= -->

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3
                gap-5 sm:gap-6">

        @forelse($packages as $package)

@php
    $oldPrice =  $package->price;

    // Admin থেকে দেওয়া discount percentage
    $discountPercent = $package->discount;

    // Discount বাদ দেওয়ার পরের selling price
    $discountPrice = (int) ($oldPrice - ($oldPrice * $discountPercent / 100));
@endphp
  
            <!-- ================= CARD ================= -->

            <div class="bg-white
                        rounded-2xl
                        border border-gray-100
                        overflow-hidden
                        shadow-sm
                        hover:shadow-xl
                        transition-all duration-300
                        group">


                <!-- ================= IMAGE ================= -->

                <div class="relative overflow-hidden">

                    <img src="{{ url('uploads/packages/'.$package->image) }}"
                         alt="{{ $package->name }}"
                         class="w-full
                                h-52 sm:h-56
                                object-cover
                                group-hover:scale-105
                                transition-transform
                                duration-500">


                    <!-- DISCOUNT BADGE -->

@if($discountPercent > 0)

    <div class="absolute top-3 left-3
                bg-red-500 text-white
                px-3.5 py-1.5
                rounded-full
                shadow-md
                text-sm font-bold">

        🏷️ {{ bnNum($discountPercent) }}% ছাড়

    </div>

@endif


                    <!-- FAVORITE -->

                    <button type="button"
                            class="absolute top-3 right-3
                                   w-10 h-10
                                   rounded-full
                                   bg-white
                                   shadow-md
                                   flex items-center justify-center
                                   hover:scale-110
                                   transition">

                        <span class="text-xl text-gray-500
                                     hover:text-red-500">
                            ♡
                        </span>

                    </button>

                </div>


                <!-- ================= CARD CONTENT ================= -->

                <div class="p-4 sm:p-5">


                    <!-- PACKAGE NAME -->

                    <a href="{{ route('home.package.details', $package->id) }}"
                       class="block
                              text-lg sm:text-xl
                              font-bold
                              text-gray-800
                              hover:text-green-700
                              transition">

                        {{ $package->name }}

                    </a>


                    <!-- ================= DESCRIPTION ================= -->

                    @if($package->description)

                        <p class="mt-2
                                  text-sm
                                  text-gray-500
                                  leading-6
                                  min-h-[72px]">

                            {{ \Illuminate\Support\Str::words(
                                $package->description,
                                20,
                                '...'
                            ) }}

                        </p>

                    @else

                        <div class="min-h-[72px]"></div>

                    @endif


                    <!-- ================= PRODUCT COUNT ================= -->

                    <div class="flex items-center gap-2 mt-3">

                        <!-- Manual Icon -->
                        <span class="w-8 h-8
                                     rounded-full
                                     bg-green-50
                                     flex items-center justify-center
                                     text-green-600
                                     text-lg">

                            📦

                        </span>


                        <span class="text-sm
                                     text-gray-600
                                     font-medium">

                            {{ bnNum(count($package->package_items)) }}
                            টি পণ্য একসাথে

                        </span>

                    </div>


                    <!-- ================= PRICE ================= -->

<div class="flex items-center gap-2 mt-3">

    {{-- Discount Price --}}
    <span class="text-2xl sm:text-3xl
                 font-bold
                 text-green-700">

        ৳{{ bnNum($discountPrice) }}.০০

    </span>


    {{-- Old Price --}}
    @if($discountPercent > 0)

        <span class="text-sm sm:text-base
                     text-gray-400
                     line-through">

            ৳{{ bnNum($oldPrice) }}.০০

        </span>

    @endif

</div>


                    <!-- ================= BUTTONS ================= -->

                    <div class="flex items-center
                                gap-2
                                mt-4">


                        <!-- ADD TO CART -->
<button type="button"
        class="addToCartBtn
               flex-1
               bg-green-600
               hover:bg-green-700
               text-white
               font-semibold
               text-sm
               py-2.5
               px-3
               rounded-xl
               shadow-sm
               transition
               flex
               items-center
               justify-center
               gap-2"

        data-id="{{ $package->id }}"
        data-name="{{ $package->name }}"
        data-price="{{ $discountPrice }}"
        data-image="{{ url('uploads/packages/'.$package->image) }}">

    <span class="text-lg leading-none">🛒</span>

    <span>প্যাকেজ যোগ করুন</span>

</button>


                        <!-- DETAILS -->

                        <a href="{{ route('home.package.details', $package->id) }}"

                           class="border
                                  border-green-600
                                  text-green-700
                                  hover:bg-green-600
                                  hover:text-white
                                  font-semibold
                                  text-sm
                                  py-2.5
                                  px-3
                                  rounded-xl
                                  transition
                                  flex
                                  items-center
                                  justify-center
                                  gap-1.5">


                            <!-- Manual Eye Icon -->

                            <span class="text-base">
                                👁
                            </span>

                            <span>
                                বিস্তারিত
                            </span>

                        </a>

                    </div>

                </div>

            </div>


        @empty

            <!-- EMPTY -->

            <div class="col-span-full
                        text-center
                        text-gray-500
                        py-12">

                <div class="text-4xl mb-3">
                    📦
                </div>

                <p>
                    কোনো প্যাকেজ পাওয়া যায়নি।
                </p>

            </div>

        @endforelse


        
    </div>

</section>


@endsection