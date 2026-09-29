@extends('apps.front_master')
@section('content')
   



<!-- 🎁 Combo Pack Reward Banner -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 py-5 sm:py-7">

    <div class="relative overflow-hidden
                rounded-2xl sm:rounded-3xl
                bg-gradient-to-r from-green-50 via-white to-orange-50
                border border-green-100
                shadow-sm">

        <!-- Decorative Background -->
        <div class="absolute -top-20 -right-20
                    w-56 h-56 sm:w-72 sm:h-72
                    bg-green-100/60 rounded-full">
        </div>

        <div class="absolute -bottom-24 -left-16
                    w-52 h-52 sm:w-72 sm:h-72
                    bg-orange-100/50 rounded-full">
        </div>


        <div class="relative grid grid-cols-1 lg:grid-cols-2
                    items-center">


            <!-- ================= LEFT CONTENT ================= -->
            <div class="px-5 py-8
                        sm:px-8 sm:py-10
                        lg:px-12 lg:py-12">

                <!-- Badge -->
                <div class="inline-flex items-center gap-2
                            bg-green-100
                            border border-green-200
                            text-green-700
                            px-3 py-1.5
                            rounded-full
                            text-xs sm:text-sm
                            font-semibold">

                    🎁 Online Shoday Combo Pack

                </div>


                <!-- Heading -->
                <h2 class="mt-4
                           text-2xl sm:text-3xl lg:text-4xl
                           font-extrabold
                           text-gray-800
                           leading-tight">

                    কম্বো প্যাক কিনুন,

                    <span class="text-green-700">
                        সাশ্রয়ীভাবে
                    </span>

                    প্রয়োজন মেটান

                </h2>


                <p class="mt-3
                          text-sm sm:text-base
                          text-gray-600
                          leading-6 sm:leading-7
                          max-w-xl">

                    প্রয়োজনীয় পণ্য একসাথে নিন।
                    নিজের জন্য কিনলে যেমন সাশ্রয় ও সুবিধা,
                    তেমনি অন্যকে কিনতে সহায়তা করলেও
                    পেতে পারেন পয়েন্ট ও রিওয়ার্ড।

                </p>


                <!-- ================= TWO HIGHLIGHTS ================= -->

                <div class="grid grid-cols-1 sm:grid-cols-2
                            gap-3 mt-5">


                    <!-- 01. নিজের জন্য -->
                    <div class="bg-green-50
                                border border-green-100
                                rounded-2xl
                                p-4">

                        <div class="flex items-start gap-3">

                            <div class="w-11 h-11
                                        flex-shrink-0
                                        rounded-xl
                                        bg-green-600
                                        text-white
                                        flex items-center
                                        justify-center
                                        text-xl">

                                🛒

                            </div>


                            <div>

                                <h3 class="font-bold
                                           text-green-800
                                           text-sm sm:text-base">

                                    নিজে কিনলে

                                </h3>

                                <p class="text-xs sm:text-sm
                                          text-gray-600
                                          mt-1
                                          leading-5">

                                    সাশ্রয়ীভাবে প্রয়োজনীয়
                                    পণ্য কিনুন এবং
                                    পয়েন্ট সংগ্রহ করুন।

                                </p>

                            </div>

                        </div>

                        <div class="mt-3
                                    inline-flex items-center
                                    gap-1.5
                                    text-xs font-semibold
                                    text-green-700">

                            ✓ সাশ্রয়ী
                            <span></span>
                            ✓ সহজ
                            <span></span>
                            ✓ পয়েন্ট

                        </div>

                    </div>



                    <!-- 02. অন্যকে কিনতে দিলে -->
                    <div class="bg-orange-50
                                border border-orange-100
                                rounded-2xl
                                p-4">

                        <div class="flex items-start gap-3">

                            <div class="w-11 h-11
                                        flex-shrink-0
                                        rounded-xl
                                        bg-orange-500
                                        text-white
                                        flex items-center
                                        justify-center
                                        text-xl">

                                🎁

                            </div>


                            <div>

                                <h3 class="font-bold
                                           text-orange-800
                                           text-sm sm:text-base">

                                    অন্যকে কিনতে দিলে

                                </h3>

                                <p class="text-xs sm:text-sm
                                          text-gray-600
                                          mt-1
                                          leading-5">

                                    আপনার মাধ্যমে অন্য কেউ
                                    কম্বো প্যাক কিনলে
                                    পেতে পারেন Rewards
                                    বা Points।

                                </p>

                            </div>

                        </div>

                        <div class="mt-3
                                    inline-flex items-center
                                    gap-1.5
                                    text-xs font-semibold
                                    text-orange-700">

                            ✓ শেয়ার করুন
                            <span></span>
                            ✓ পয়েন্ট
                            <span></span>
                            ✓ রিওয়ার্ড

                        </div>

                    </div>

                </div>


                <!-- Small Benefits -->
                <div class="flex flex-wrap
                            items-center
                            gap-x-4 gap-y-2
                            mt-5
                            text-xs sm:text-sm
                            text-gray-600">

                    <span class="flex items-center gap-1.5">
                        <span class="text-green-600">✓</span>
                        প্রয়োজনীয় পণ্য
                    </span>

                    <span class="flex items-center gap-1.5">
                        <span class="text-green-600">✓</span>
                        সাশ্রয়ী প্যাকেজ
                    </span>

                    <span class="flex items-center gap-1.5">
                        <span class="text-orange-500">🎁</span>
                        পয়েন্ট ও রিওয়ার্ড
                    </span>

                </div>


                <!-- Buttons -->
                <div class="flex flex-wrap gap-3 mt-6">

                    <!-- Details -->
                    <a href="{{ route('home.package_points.details') }}"
                       class="inline-flex items-center
                              justify-center gap-2
                              bg-green-600
                              hover:bg-green-700
                              text-white
                              font-semibold
                              text-sm
                              px-5 py-2.5
                              rounded-xl
                              shadow-sm
                              transition
                              hover:-translate-y-0.5">

                        📦
                        <span>বিস্তারিত দেখুন</span>
                        <span>→</span>

                    </a>


                    <!-- All Packages -->
                    <a href="#packages"
                       class="inline-flex items-center
                              justify-center gap-2
                              bg-white
                              hover:bg-orange-50
                              text-orange-700
                              border border-orange-200
                              font-semibold
                              text-sm
                              px-5 py-2.5
                              rounded-xl
                              transition">

                        🎁
                        <span>সব কম্বো প্যাক</span>

                    </a>

                </div>


                <!-- Note -->
                <p class="mt-3
                          text-[10px] sm:text-xs
                          text-gray-400">

                    * পয়েন্ট ও রিওয়ার্ড প্রযোজ্য নিয়ম ও শর্ত অনুযায়ী।

                </p>

            </div>



            <!-- ================= RIGHT IMAGE ================= -->
            <div class="relative
                        flex items-center
                        justify-center
                        px-5 pb-7
                        sm:px-8 sm:pb-9
                        lg:px-6 lg:py-8">

                <!-- Background Glow -->
                <div class="absolute
                            w-56 h-56
                            sm:w-72 sm:h-72
                            lg:w-80 lg:h-80
                            bg-green-100
                            rounded-full
                            blur-2xl
                            opacity-70">
                </div>


                <!-- Combo Image -->
                <div class="relative z-10
                            w-full
                            max-w-md">

                    <img src="{{ url('public/default/combo/short.png') }}"
                         alt="Online Shoday Combo Pack Rewards"
                         class="w-full h-auto
                                object-contain
                                drop-shadow-xl
                                hover:scale-[1.02]
                                transition duration-500">

                </div>

            </div>

        </div>

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
 

@endsection