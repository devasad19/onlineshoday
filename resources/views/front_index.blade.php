@extends('apps.front_master')
@section('content')

<!-- 🌿 Hero Section -->
<!-- 🌿 Hero Section -->
<section class="bg-gradient-to-r from-green-100 via-green-50 to-white
                py-8 sm:py-10 lg:py-12">

    <div class="max-w-7xl mx-auto flex flex-col md:flex-row
                items-center justify-between
                px-4 sm:px-6 gap-8 lg:gap-12">

        <!-- ================= TEXT ================= -->
        <div class="md:w-[55%] text-center md:text-left">

            <!-- Small Badge -->
            <div class="inline-flex items-center gap-2
                        bg-green-100 border border-green-200
                        text-green-700
                        px-3 py-1.5 rounded-full
                        text-xs sm:text-sm font-semibold mb-4">

                🛒 Online Shoday

            </div>

            <!-- Heading -->
            <h1 class="text-3xl sm:text-4xl lg:text-5xl
                       font-extrabold text-green-700
                       leading-tight">

                আপনার স্থানীয় বাজার
                <br class="hidden sm:block">

                <span class="text-gray-800">
                    এখন ঘরে বসেই
                </span>

                🛒

            </h1>

            <!-- Description -->
            <p class="text-gray-600 mt-4 mb-6
                      text-sm sm:text-base lg:text-lg
                      leading-6 sm:leading-7
                      max-w-xl mx-auto md:mx-0">

                বাজারের প্রয়োজনীয় পণ্য সহজেই অর্ডার করুন।
                আমরা আপনার অর্ডার সংগ্রহ করে
                আপনার ঠিকানায় পৌঁছে দেব।

            </p>


            <!-- ================= BUTTONS ================= -->
            <div class="flex flex-wrap gap-3
                        justify-center md:justify-start">

                <!-- Products -->
                <a href="{{ route('products.filter') }}"
                   class="inline-flex items-center justify-center
                          gap-2
                          bg-green-600 hover:bg-green-700
                          text-white
                          px-5 py-2.5
                          rounded-xl
                          font-semibold text-sm
                          shadow-sm
                          transition
                          hover:-translate-y-0.5">

                    🛍️
                    <span>পণ্য দেখুন</span>

                </a>


                <!-- Combo -->
                <a href="#packages"
                   class="inline-flex items-center justify-center
                          gap-2
                          bg-orange-500 hover:bg-orange-600
                          text-white
                          px-5 py-2.5
                          rounded-xl
                          font-semibold text-sm
                          shadow-sm
                          transition
                          hover:-translate-y-0.5">

                    📦
                    <span>কম্বো প্যাক</span>

                </a>

            </div>


 
            <!-- ================= CONTACT / SOCIAL ================= -->
<div class="mt-6">

    <div class="flex flex-wrap items-center
                justify-center md:justify-start
                gap-2.5 sm:gap-3">


        <!-- ================= WEBSITE ================= -->
        <a href="https://www.onlineshoday.com"
           target="_blank"
           rel="noopener noreferrer"
           title="Online Shoday Website"
           class="group inline-flex items-center gap-2
                  h-11 sm:h-12
                  px-3
                  rounded-xl
                  bg-white
                  border border-green-200
                  text-green-700
                  shadow-sm
                  hover:bg-green-600
                  hover:text-white
                  hover:border-green-600
                  hover:shadow-md
                  transition-all duration-200">

            <span class="w-7 h-7 sm:w-8 sm:h-8
                         rounded-lg
                         bg-green-50
                         group-hover:bg-white/20
                         flex items-center justify-center
                         text-base sm:text-lg">

                🌐

            </span>

            <span class="text-xs sm:text-sm
                         font-semibold whitespace-nowrap">

                www.onlineshoday.com

            </span>

        </a>



        <!-- ================= WHATSAPP ================= -->
        <a href="https://wa.me/8801710121044"
           target="_blank"
           rel="noopener noreferrer"
           title="WhatsApp: +880 1710 121 044"
           class="group inline-flex items-center gap-2
                  h-11 sm:h-12
                  px-3
                  rounded-xl
                  bg-white
                  border border-green-200
                  text-green-700
                  shadow-sm
                  hover:bg-green-600
                  hover:text-white
                  hover:border-green-600
                  hover:shadow-md
                  transition-all duration-200">

            <span class="w-7 h-7 sm:w-8 sm:h-8
                         rounded-lg
                         bg-green-50
                         group-hover:bg-white/20
                         flex items-center justify-center">

                <svg xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24"
                     fill="currentColor"
                     class="w-5 h-5 sm:w-5.5 sm:h-5.5">

                    <path d="M12.04 2C6.5 2 2 6.48 2 12c0 1.77.46 3.43 1.34 4.91L2 22l5.2-1.36A9.96 9.96 0 0 0 12.04 22
                    C17.57 22 22 17.52 22 12S17.57 2 12.04 2Zm0 18.2c-1.58 0-3.12-.42-4.47-1.22l-.32-.19-3.09.81.83-3.01-.21-.31A8.15 8.15 0 0 1 3.8 12c0-4.53 3.69-8.2 8.24-8.2s8.16 3.67 8.16 8.2-3.62 8.2-8.16 8.2Zm4.5-6.13c-.25-.13-1.47-.73-1.7-.81-.23-.08-.4-.13-.57.13-.17.25-.65.81-.8.98-.15.17-.3.19-.55.06-.25-.13-1.04-.38-1.98-1.22-.73-.65-1.22-1.45-1.36-1.7-.14-.25-.02-.39.11-.52.12-.12.25-.3.38-.45.13-.15.17-.25.25-.42.08-.17.04-.32-.02-.45-.06-.13-.57-1.37-.78-1.88-.21-.5-.42-.43-.57-.44h-.49c-.17 0-.45.06-.68.32-.23.25-.88.86-.88 2.09 0 1.23.9 2.42 1.03 2.59.13.17 1.76 2.69 4.27 3.77.6.26 1.07.42 1.44.54.61.19 1.17.16 1.61.1.49-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.15-1.18-.06-.11-.23-.17-.48-.3Z"/>

                </svg>

            </span>

            <span class="text-xs sm:text-sm
                         font-semibold whitespace-nowrap">

                +880 1710 121 044

            </span>

        </a>



        <!-- ================= FACEBOOK ================= -->
        <a href="https://www.facebook.com/onlineshoday"
           target="_blank"
           rel="noopener noreferrer"
           title="Facebook: Online Shoday"
           class="group inline-flex items-center gap-2
                  h-11 sm:h-12
                  px-3
                  rounded-xl
                  bg-white
                  border border-blue-100
                  text-blue-600
                  shadow-sm
                  hover:bg-blue-600
                  hover:text-white
                  hover:border-blue-600
                  hover:shadow-md
                  transition-all duration-200">

            <span class="w-7 h-7 sm:w-8 sm:h-8
                         rounded-lg
                         bg-blue-50
                         group-hover:bg-white/20
                         flex items-center justify-center">

                <svg xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24"
                     fill="currentColor"
                     class="w-5 h-5 sm:w-5.5 sm:h-5.5">

                    <path d="M13.5 22v-8h2.7l.4-3h-3.1V9.1c0-.87.24-1.46 1.5-1.46h1.7V4.95c-.3-.04-1.34-.13-2.55-.13-2.52 0-4.25 1.54-4.25 4.37V11H7v3h2.9v8h3.6Z"/>

                </svg>

            </span>

            <span class="text-xs sm:text-sm
                         font-semibold whitespace-nowrap">

                Fb / onlineshoday

            </span>

        </a>

    </div>


    <!-- Small trust line -->
    <div class="flex flex-wrap items-center
                justify-center md:justify-start
                gap-x-4 gap-y-1
                mt-3
                text-[11px] sm:text-xs
                text-gray-500">

        <span>🌿 প্রয়োজনীয় পণ্য</span>

        <span></span>

        <span>🚚 ঘরে ডেলিভারি</span>

        <span></span>

        <span>🤝 বিশ্বস্ত সেবা</span>

    </div>

</div>

        </div>


        <!-- ================= IMAGE ================= -->
        <div class="md:w-[45%] flex justify-center relative">

            <!-- Soft Background -->
            <div class="absolute
                        w-52 h-52 sm:w-64 sm:h-64 lg:w-80 lg:h-80
                        bg-green-100
                        rounded-full
                        blur-2xl
                        opacity-70">
            </div>

            <img src="{{ url('public/default/small_logo.png') }}"
                 alt="Online Shoday"
                 class="relative z-10
                        w-52 sm:w-64 md:w-72 lg:w-96
                        drop-shadow-xl
                        hover:scale-105
                        transition duration-500">

        </div>

    </div>

</section>

<!-- 🔍 Filter Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
  <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-md border border-gray-100">
    <h3 class="text-xl font-bold mb-4 text-green-700 flex items-center gap-2 justify-center md:justify-start">
      🔎 পণ্য বাছাই করুন
    </h3>

    <form action="{{ route('products.filter') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
      <select name="category_id" class="border px-3 py-2 rounded-lg w-full focus:ring-2 focus:ring-green-400 text-sm">
        <option value="">ক্যাটাগরি নির্বাচন</option>
        @foreach($categories as $category)
          <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </select>

      <select name="bazar_id" class="border px-3 py-2 rounded-lg w-full focus:ring-2 focus:ring-green-400 text-sm">
        <option value="">বাজার নির্বাচন</option>
        @foreach($bazars as $bazar)
          <option value="{{ $bazar->id }}">{{ $bazar->name }}</option>
        @endforeach
      </select>
 
      <input type="text" name="keyword" placeholder="পণ্যের নাম লিখুন"
             class="border px-3 py-2 rounded-lg w-full focus:ring-2 focus:ring-green-400 text-sm">

      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm sm:col-span-2 md:col-span-1">
        বাছাই করুন
      </button>
    </form>
  </div>
</section>

<!-- 🛍️ Product Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 pb-14 sm:pb-16">
  <div class="flex flex-col sm:flex-row justify-between items-center mb-6 text-center sm:text-left gap-2">
    <h3 class="text-2xl font-bold text-green-700">🛒 নিত্যপ্রয়োজনীয় পণ্যসমূহ</h3>
    <a href="{{ route('products.filter') }}" class="text-sm text-green-600 hover:underline">সব পণ্য দেখুন →</a>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 sm:gap-6">
    @forelse($products as $product)
      <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-4 relative group">
        <img src="{{ url('uploads/products/'.$product->image) }}" 
             alt="{{ $product->name }}" 
             class="rounded-lg w-full h-44 object-cover group-hover:scale-105 transition duration-300">
        <!-- <button class="absolute top-3 right-3 bg-white p-2 rounded-full shadow hover:text-red-500">
          ❤️
        </button> -->
        <div class="mt-4">
           <a href="{{ route('home.product.details', $product->id) }}"  class="font-bold text-sm sm:text-lg">{{ $product->name }}</a>
          <p class="text-green-600 text-lg font-semibold">৳{{ bnNum($product->price) }} / {{ $product->unit }}</p>
          <!-- <p class="text-sm text-gray-500">
            বিতরণকারী: 
            {{ optional($product->rider)->name ?? 'N/A' }}
          </p> -->
          <p class="text-sm text-gray-500 mb-3">
            বাজার:  {{ optional($product->bazar)->name ?? 'N/A' }}
          </p>
          <div class="flex justify-between items-center">
              <button class="addToCartBtn inline-block bg-indigo-600 hover:bg-indigo-700 text-sm text-white py-1 px-2 sm:py-2 sm:px-3 rounded-lg text-sm"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->price }}"
                    data-image="{{ url('uploads/products/'.$product->image) }}">
              🛒 ব্যাগে যোগ করুন
            </button>
            <a href="{{ route('home.product.details', $product->id) }}"  class="inline-block text-sm bg-green-600 text-white py-1 px-2 sm:py-2 sm:px-3 rounded-lg hover:bg-green-700 transition text-center">
              বিস্তারিত </a>
        </div>
        </div>
      </div>


    @empty
      <div class="col-span-4 text-center text-gray-500 py-10">
        🚫 কোনো পণ্য পাওয়া যায়নি।
      </div>
    @endforelse
  </div>
</section>

 <!-- 🛍️ Package Section -->
<section id="packages" class="max-w-7xl mx-auto px-4 sm:px-6 pb-14 sm:pb-16">

    <!-- ================= HEADER ================= -->
    <div class="flex flex-col sm:flex-row justify-between items-center
                mb-6 sm:mb-8 gap-3">

        <h3 class="text-xl sm:text-2xl font-bold text-green-700
                   text-center sm:text-left">

            <span class="text-green-600 mr-1">🛒</span>
            কম্বো প্যাক — প্রয়োজনীয় পণ্য, সাশ্রয়ী প্যাকেজে
        </h3>

        <div class="flex items-center gap-2
                    bg-green-50
                    text-green-700
                    px-4 py-2
                    rounded-full
                    text-sm
                    font-medium">

            <span class="text-base">🌿</span>
    <a href="{{ route('home.package.all') }}" class="text-sm text-green-600 hover:underline">
            <span>সব কম্বো প্যাক</span>
            </a>
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

                    <!-- <button type="button"
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

                    </button> -->

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

        ৳{{ bnNum($discountPrice) }}

    </span>


    {{-- Old Price --}}
    @if($discountPercent > 0)

        <span class="text-sm sm:text-base
                     text-gray-400
                     line-through">

            ৳{{ bnNum($oldPrice) }}

        </span>

    @endif

</div>


                    <!-- ================= BUTTONS ================= -->

                    <div class="flex items-center
                                gap-2
                                mt-4">


                        <!-- ADD TO CART -->
<a href="{{ route('packages.purchase', $package->id) }}"
        class="addToCartBtnPkg
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
               gap-2">

    <span class="text-lg leading-none">🛒</span>

    <span>প্যাকেজ কিনুন 2</span>

</a>


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
 <!-- 🎁 Combo Points Banner -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 pt-3 sm:pt-5 pb-6">

    <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl
                bg-gradient-to-r from-green-700 via-green-600 to-emerald-500
                shadow-md">

        <!-- 65% LEFT + 35% RIGHT -->
        <div class="grid grid-cols-1 md:grid-cols-[65%_35%] items-center">


            <!-- ================================================= -->
            <!-- LEFT SIDE - 65% -->
            <!-- ================================================= -->
            <div class="px-5 py-7
                        sm:px-8 sm:py-9
                        lg:px-10 lg:py-10
                        text-white">

                <!-- Badge -->
                <div class="inline-flex items-center gap-2
                            bg-white/15
                            backdrop-blur-sm
                            border border-white/20
                            px-3 py-1.5
                            rounded-full
                            text-[10px] sm:text-xs
                            mb-3">

                    🎁 কম্বো প্যাক • পয়েন্ট • ফ্রি বাজার

                </div>


                <!-- ================= HEADING ================= -->
                <h1 class="text-xl sm:text-2xl lg:text-3xl
                           font-extrabold
                           leading-tight">

                    নিজে কিনুন,
                    <span class="text-yellow-300">
                        অন্যকেও কিনতে সাহায্য করুন
                    </span>

                    <br>

                    <span>
                        দু’ভাবেই পয়েন্ট সংগ্রহ করুন
                    </span>

                </h1>


                <!-- ================================================= -->
                <!-- 3 BENEFITS -->
                <!-- ================================================= -->
                <div class="grid grid-cols-3
                            gap-1.5 sm:gap-2.5
                            mt-5">


                    <!-- ================= BENEFIT 1 ================= -->
                    <div class="rounded-xl
                                border border-white/30
                                bg-white/10
                                hover:bg-white/15
                                p-2 sm:p-2.5
                                transition">

                        <div class="flex items-center
                                    gap-1.5 sm:gap-2">

                            <!-- Icon -->
                            <div class="w-8 h-8
                                        sm:w-9 sm:h-9
                                        rounded-lg
                                        bg-white
                                        text-green-700
                                        flex items-center justify-center
                                        text-base sm:text-lg
                                        flex-shrink-0">

                                🛒

                            </div>

                            <!-- Text -->
                            <div class="min-w-0">

                                <div class="font-bold
                                            text-[10px]
                                            sm:text-xs
                                            lg:text-sm
                                            leading-tight
                                            whitespace-nowrap">

                                    নিজে সাশ্রয়ী কম্বো কিনুন

                                </div>

                                <div class="text-[8px]
                                            sm:text-[10px]
                                            text-green-100
                                            mt-0.5
                                            whitespace-nowrap">

                                    পয়েন্ট পান

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- ================= BENEFIT 2 ================= -->
                    <div class="rounded-xl
                                border border-white/30
                                bg-white/10
                                hover:bg-white/15
                                p-2 sm:p-2.5
                                transition">

                        <div class="flex items-center
                                    gap-1.5 sm:gap-2">

                            <!-- Icon -->
                            <div class="w-8 h-8
                                        sm:w-9 sm:h-9
                                        rounded-lg
                                        bg-yellow-300
                                        text-green-800
                                        flex items-center justify-center
                                        text-base sm:text-lg
                                        flex-shrink-0">

                                🎁

                            </div>

                            <!-- Text -->
                            <div class="min-w-0">

                                <div class="font-bold
                                            text-[10px]
                                            sm:text-xs
                                            lg:text-sm
                                            leading-tight
                                            whitespace-nowrap">

                                    অন্যকে সাহায্য করুন কিনতে

                                </div>

                                <div class="text-[8px]
                                            sm:text-[10px]
                                            text-green-100
                                            mt-0.5
                                            whitespace-nowrap">

                                    রেফারেল পয়েন্ট পান

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- ================= BENEFIT 3 ================= -->
                    <div class="rounded-xl
                                border border-white/30
                                bg-white/10
                                hover:bg-white/15
                                p-2 sm:p-2.5
                                transition">

                        <div class="flex items-center
                                    gap-1.5 sm:gap-2">

                            <!-- Icon -->
                            <div class="w-8 h-8
                                        sm:w-9 sm:h-9
                                        rounded-lg
                                        bg-green-100
                                        text-green-800
                                        flex items-center justify-center
                                        text-base sm:text-lg
                                        flex-shrink-0">

                                ⭐

                            </div>

                            <!-- Text -->
                            <div class="min-w-0">

                                <div class="font-bold
                                            text-[10px]
                                            sm:text-xs
                                            lg:text-sm
                                            leading-tight
                                            whitespace-nowrap">

                                    পয়েন্ট দিয়ে বাজার

                                </div>

                                <div class="text-[8px]
                                            sm:text-[10px]
                                            text-green-100
                                            mt-0.5
                                            whitespace-nowrap">

                                    টাকা ছাড়াই বাজার করুন

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- ================================================= -->
                <!-- 3 SMALL POINTS -->
                <!-- ================================================= -->
                <div class="flex items-center
                            gap-x-1.5
                            sm:gap-x-2.5
                            lg:gap-x-3
                            mt-3
                            text-[8px]
                            sm:text-[10px]
                            lg:text-xs
                            text-green-50
                            whitespace-nowrap">

                    <span class="flex items-center gap-0.5">
                        <span class="text-yellow-300">✓</span>
                        সহজে পয়েন্ট সংগ্রহ
                    </span>

                    <span class="flex items-center gap-0.5">
                        <span class="text-yellow-300">✓</span>
                        নিজের কেনাকাটায় পয়েন্ট
                    </span>

                    <span class="flex items-center gap-0.5">
                        <span class="text-yellow-300">✓</span>
                        অন্যের অর্ডারেও রিওয়ার্ড
                    </span>

                </div>


                <!-- ================================================= -->
                <!-- BUTTONS -->
                <!-- ================================================= -->
                <div class="flex flex-wrap
                            gap-2.5
                            mt-5">

                    <!-- Combo -->
                    <a href="{{ route('home.package.all') }}"
                       class="inline-flex items-center justify-center
                              bg-white
                              text-green-700
                              hover:bg-green-50
                              font-bold
                              text-xs sm:text-sm
                              px-4 sm:px-5
                              py-2.5
                              rounded-xl
                              shadow-sm
                              transition
                              hover:-translate-y-0.5">

                        🛒 কম্বো প্যাক দেখুন

                    </a>


                    <!-- Details -->
                    <a href="{{ route('home.package_points.details') }}"
                       class="inline-flex items-center justify-center
                              bg-yellow-400
                              hover:bg-yellow-300
                              text-green-900
                              font-bold
                              text-xs sm:text-sm
                              px-4 sm:px-5
                              py-2.5
                              rounded-xl
                              shadow-sm
                              transition
                              hover:-translate-y-0.5">

                        ⭐ বিস্তারিত জানুন

                    </a>

                </div>

            </div>


            <!-- ================================================= -->
            <!-- RIGHT SIDE - 35% -->
            <!-- ================================================= -->
            <div class="relative
                        flex items-center justify-center
                        min-h-[300px]
                        sm:min-h-[340px]
                        md:min-h-[380px]
                        lg:min-h-[420px]
                        px-1 sm:px-2
                        overflow-visible">


                <!-- Soft Circle -->
                <div class="absolute
                            w-56 h-56
                            sm:w-72 sm:h-72
                            md:w-80 md:h-80
                            lg:w-[360px] lg:h-[360px]
                            bg-white/10
                            rounded-full">
                </div>


                <!-- ================= LARGE IMAGE ================= -->
                <div class="relative z-10
                            w-[115%]
                            sm:w-[125%]
                            md:w-[145%]
                            lg:w-[160%]
                            xl:w-[170%]
                            max-w-none
                            scale-110
                            sm:scale-125
                            md:scale-135
                            lg:scale-145">

                    <img src="{{ url('public/default/combo/home_banner.png') }}"
                         alt="Online Shoday Combo Pack"
                         class="w-full h-auto
                                max-w-none
                                object-contain
                                drop-shadow-2xl
                                transition duration-500
                                hover:scale-105">

                </div>

            </div>

        </div>

    </div>

</section>

 



<!-- 🚴‍♂️ Rider Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 pb-16">
  <div class="flex flex-col sm:flex-row justify-between items-center mb-6 text-center sm:text-left gap-2">
    <h3 class="text-2xl font-bold text-green-700">🚴‍♂️ আমাদের বিশ্বস্ত রাইডারগণ</h3>
    <a href="#" class="text-sm text-green-600 hover:underline">সব রাইডার দেখুন →</a>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 sm:gap-6">
    @foreach($riders as $rider)
    <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden group">
      <div class="relative">
        <img src="{{ $rider->photo ? asset('uploads/riders/'.$rider->photo) : 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png' }}" 
             alt="{{ $rider->name }}" 
             class="h-48 w-full object-cover group-hover:scale-105 transition duration-300">
        <span class="absolute top-3 right-3 bg-green-600 text-white text-xs px-3 py-1 rounded-full">
          {{ ucfirst($rider->status) }}
        </span>
      </div>

      <div class="p-5 text-center">
        <h4 class="text-lg font-bold text-gray-800">{{ $rider->name }}</h4>
        <p class="text-sm text-gray-500 mb-1">📞 {{ $rider->phone }}</p>
        <p class="text-sm text-gray-500 mb-2">{{ $rider->vehicle_type ? '🚲 '.$rider->vehicle_type : '' }}</p>

        <div class="grid grid-cols-2 gap-2 text-sm mt-3">
          <div class="bg-green-50 p-2 rounded-lg">
            <p class="font-semibold text-green-700">Delivered</p>
            <p class="font-bold text-gray-800">{{ $rider->total_delivered }}</p>
          </div>
          <div class="bg-green-50 p-2 rounded-lg">
            <p class="font-semibold text-green-700">On Time</p>
            <p class="font-bold text-gray-800">
              @php
                $percent = $rider->total_delivered > 0 ? round(($rider->on_time_delivery / $rider->total_delivered) * 100) : 0;
              @endphp
              {{ $percent }}%
            </p>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-2 text-sm mt-3">
          <div class="bg-yellow-50 p-2 rounded-lg">
            <p class="font-semibold text-yellow-700">Pending</p>
            <p class="font-bold text-gray-800">{{ $rider->pending_orders }}</p>
          </div>
          <div class="bg-red-50 p-2 rounded-lg">
            <p class="font-semibold text-red-700">Cancelled</p>
            <p class="font-bold text-gray-800">{{ $rider->cancel_delivery }}</p>
          </div>
        </div>

        <a href="{{ route('riders.show', $rider->id) }}" 
           class="mt-4 inline-block bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
          বিস্তারিত দেখুন
        </a>
      </div>
    </div>
    @endforeach
  </div>
</section>

  
<!-- 🛍️ Product Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 pb-14 sm:pb-16">

    <!-- Section Header -->
    <div class="flex flex-col sm:flex-row
                justify-between items-start sm:items-center
                mb-5 gap-2">

        <div>
            <h3 class="text-xl sm:text-2xl font-bold text-green-700">
                🛍️ অন্যান্য প্রয়োজনীয় পণ্য
            </h3>

            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                নিত্যপ্রয়োজনীয়সহ আপনার দরকারি বিভিন্ন পণ্য
            </p>
        </div>

        <a href="{{ route('products.filter') }}"
           class="text-xs sm:text-sm text-green-600
                  hover:underline whitespace-nowrap">
            সব পণ্য দেখুন →
        </a>

    </div>


    <!-- Products Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4
                gap-3 sm:gap-5">

        @forelse($ecommece_products as $product)

            @php
                // ৫% ছাড়
                $oldPrice = (float) $product->price;
                $discountPercent = $product->discount;
                $sellingPrice = (int) ($oldPrice - ($oldPrice * $discountPercent / 100));
            @endphp


            <!-- Product Card -->
            <div class="bg-white
                        rounded-xl
                        border border-gray-100
                        shadow-sm
                        hover:shadow-md
                        transition
                        overflow-hidden
                        group">


                <!-- Image -->
                <div class="relative overflow-hidden">

                    <a href="{{ route('home.ecom_product.details', $product->id) }}">

                        <div class="h-32 sm:h-40 lg:h-44 bg-gray-100">

                            @if($product->image)

                                <img src="{{ url('uploads/products/'.$product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover
                                            group-hover:scale-105
                                            transition-transform duration-300">

                            @else

                                <div class="w-full h-full
                                            flex items-center
                                            justify-center
                                            text-3xl">
                                    📦
                                </div>

                            @endif

                        </div>

                    </a>


                    <!-- Discount Badge -->
                     @if($discountPercent > 0)
                    <div class="absolute top-2 left-2
                                bg-red-500
                                text-white
                                px-2 py-1
                                rounded-full
                                text-[10px] sm:text-xs
                                font-bold
                                shadow">

                        🏷️ {{ bnNum($discountPercent) }}% ছাড়

                    </div>
                    @endif

                </div>


                <!-- Product Info -->
                <div class="p-2.5 sm:p-3">


                    <!-- Product Name -->
                    <a href="{{ route('home.ecom_product.details', $product->id) }}"
                       class="block
                              text-xs sm:text-sm
                              font-semibold
                              text-gray-800
                              leading-5
                              line-clamp-2
                              hover:text-green-700">

                        {{ $product->name }}

                    </a>


                    <!-- Price -->
                    <div class="flex items-center gap-1.5 mt-1.5">

                        <!-- Selling Price -->
                        <span class="text-sm sm:text-base
                                     font-bold
                                     text-green-700">

                            ৳{{ bnNum($sellingPrice) }}/{{ $product->unit }}

                        </span>


                        <!-- Old Price -->
                          @if($discountPercent > 0)
                        <span class="text-[10px] sm:text-xs
                                     text-gray-400
                                     line-through">

                            ৳{{ bnNum($oldPrice) }}

                        </span>
@endif
                    </div>


                    <!-- Bazar -->
                    @if(optional($product->bazar)->name)

                        <div class="text-[10px] sm:text-xs
                                    text-gray-400
                                    mt-1
                                    truncate">

                            📍 {{ $product->bazar->name }}

                        </div>

                    @endif


                    <!-- Buttons -->
                    <div class="flex items-center gap-1.5 mt-2.5">

                        <!-- Add To Cart -->
                        <button type="button"
                                class="addToCartBtn
                                       flex-1
                                       bg-green-600
                                       hover:bg-green-700
                                       text-white
                                       text-[10px] sm:text-xs
                                       font-semibold
                                       py-2
                                       px-1.5
                                       rounded-lg
                                       transition
                                       flex items-center
                                       justify-center
                                       gap-1"

                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-price="{{ $sellingPrice }}"
                                data-image="{{ url('uploads/products/'.$product->image) }}">

                            🛒
                            <span>ব্যাগে যোগ</span>

                        </button>


                        <!-- Details -->
                        <a href="{{ route('home.ecom_product.details', $product->id) }}"
                           class="w-9
                                  py-2
                                  border border-green-600
                                  text-green-700
                                  hover:bg-green-600
                                  hover:text-white
                                  rounded-lg
                                  text-xs
                                  transition
                                  flex items-center
                                  justify-center">

                            👁

                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-span-full
                        text-center
                        text-gray-500
                        py-10">

                <div class="text-3xl mb-2">
                    📦
                </div>

                <p class="text-sm">
                    বর্তমানে কোনো পণ্য পাওয়া যায়নি।
                </p>

            </div>

        @endforelse

    </div>

</section>





<!-- 📱 App Download Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 py-14 sm:py-16 bg-green-50 rounded-2xl mt-8 sm:mt-10 shadow-sm">
  <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-center md:text-left">

    <!-- Text Section -->
    <div class="md:w-1/2">
      <h3 class="text-2xl sm:text-3xl font-bold text-green-800 mb-4">📱 আমাদের অ্যান্ড্রয়েড অ্যাপ ডাউনলোড করুন</h3>
      <p class="text-gray-700 leading-relaxed mb-6 text-sm sm:text-base">
        আরও দ্রুত ও সহজভাবে পণ্য অর্ডার করতে এখনই আমাদের অফিশিয়াল 
        <span class="font-semibold text-green-700">"Online Shoday.com"</span> অ্যান্ড্রয়েড অ্যাপটি ডাউনলোড করুন।  
        ঘরে বসে কেনাকাটা করুন, অর্ডার ট্র্যাক করুন, আর পান এক্সক্লুসিভ অফার ও ছাড়!
      </p>

      <!-- Download Button -->
      <div class="flex justify-center md:justify-start">
        <!-- <a href="#" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-3 rounded-lg shadow-md transition transform hover:scale-105">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C6.477 2 2 6.485 2 12.017 2 17.522 6.477 22 12 22s10-4.478 10-9.983C22 6.485 17.523 2 12 2zm0 18.193a8.2 8.2 0 1 1 0-16.386 8.2 8.2 0 0 1 0 16.386zM11 7h2v6h-2zm0 8h2v2h-2z"/>
          </svg>
          📲 অ্যান্ড্রয়েড অ্যাপ ডাউনলোড করুন
        </a> -->
        <button id="installApp"
          class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg ">
          📲 অ্যাপ ইন্সটল করুন
      </button>
      </div>
    </div>

    <!-- Android App Preview -->
    <div class="md:w-1/2 flex justify-center">
      <div class="relative w-56 sm:w-64 md:w-80">
        <img src="{{ url('public/default/android-app.png') }}" alt="Android Phone Frame" class="w-full drop-shadow-lg">
         
      </div>
    </div>

  </div>
</section>



@endsection

@section('scripts')

<script>
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js');
}
</script>

<script>
let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {

    e.preventDefault();

    deferredPrompt = e;

    document
        .getElementById('installApp')
        .classList.remove('hidden');

});

document
.getElementById('installApp')
.addEventListener('click', async () => {

    if (!deferredPrompt) return;

    deferredPrompt.prompt();

    await deferredPrompt.userChoice;

    deferredPrompt = null;

    document
        .getElementById('installApp')
        .classList.add('hidden');

});
</script>


@endsection