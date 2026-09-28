@extends('apps.front_master')

@section('content')

@php
    // Product discount
    $oldPrice = (float) $product->price;
    $discountPercent = $product->discount;

    $sellingPrice = (int) ($oldPrice - (
        $oldPrice * $discountPercent / 100
    ));
@endphp


<!-- 🧭 Breadcrumb -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 py-3 sm:py-5">

    <nav class="text-xs text-gray-500">

        <a href="{{ url('/') }}"
           class="hover:text-green-600">
            হোম
        </a>

        <span class="mx-1">/</span>

        <span class="text-gray-500">
            পণ্যসমূহ
        </span>

        <span class="mx-1">/</span>

        <span class="text-green-700 font-medium">
            {{ $product->name }}
        </span>

    </nav>

</section>



<!-- 🛍️ Product Details -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 pb-8 sm:pb-10">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 sm:gap-6">


        <!-- =========================
             MAIN PRODUCT
        ========================== -->

        <div class="lg:col-span-2
                    bg-white
                    rounded-2xl
                    border border-gray-100
                    shadow-sm
                    overflow-hidden">

            <div class="p-4 sm:p-5">

                <div class="grid grid-cols-1 sm:grid-cols-2
                            gap-5 sm:gap-7">


                    <!-- Product Image -->
                    <div>

                        <div class="relative
                                    rounded-xl
                                    overflow-hidden
                                    bg-gray-100">

                            <!-- Discount Badge -->
                              @if($discountPercent > 0)
                            <div class="absolute top-3 left-3 z-10
                                        bg-red-500
                                        text-white
                                        px-2.5 py-1
                                        rounded-full
                                        text-xs
                                        font-bold
                                        shadow">

                                🏷️ {{ bnNum($discountPercent) }}% ছাড়

                            </div>
@endif

                            @if($product->image)

                                <img src="{{ url('uploads/products/'.$product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full
                                            h-64 sm:h-72
                                            object-cover">

                            @else

                                <div class="w-full h-64 sm:h-72
                                            flex items-center
                                            justify-center
                                            text-5xl">

                                    📦

                                </div>

                            @endif

                        </div>

                    </div>



                    <!-- Product Info -->
                    <div class="flex flex-col">


                        <!-- Name -->
                        <h1 class="text-xl sm:text-2xl
                                   font-bold
                                   text-gray-800
                                   leading-tight">

                            {{ $product->name }}

                        </h1>


                        <!-- Short Description -->
                        @if($product->short_description)

                            <p class="text-xs sm:text-sm
                                      text-gray-500
                                      leading-5
                                      mt-2">

                                {{ $product->short_description }}

                            </p>

                        @endif


                        <!-- Price -->
                        <div class="flex items-center gap-2 mt-4">

                            <span class="text-2xl sm:text-3xl
                                         font-bold
                                         text-green-700">

                                ৳{{ bnNum($sellingPrice) }}/{{ $product->unit }}

                            </span>
 @if($discountPercent > 0)
                            <span class="text-sm
                                         text-gray-400
                                         line-through">

                                ৳{{ bnNum($oldPrice) }}

                            </span>
@endif
                        </div>


                        <!-- Bazar -->
                        @if(optional($product->bazar)->name)

                            <div class="text-xs sm:text-sm
                                        text-gray-500
                                        mt-2">

                                📍 বাজার:
                                <span class="font-medium text-gray-700">

                                    {{ $product->bazar->name }}

                                </span>

                            </div>

                        @endif


                        <!-- Price Note -->
                        <div class="mt-3
                                    bg-yellow-50
                                    border border-yellow-100
                                    rounded-lg
                                    px-3 py-2">

                            <p class="text-[11px] sm:text-xs
                                      text-gray-600">

                                ℹ️ বাজারদর পরিবর্তনের কারণে
                                পণ্যের মূল্যে সামান্য পরিবর্তন হতে পারে।

                            </p>

                        </div>


                        <!-- Quantity + Cart -->
                        <div class="flex flex-wrap
                                    items-center
                                    gap-2
                                    mt-5">


                            <!-- Quantity -->
                            <div class="flex items-center
                                        border border-gray-200
                                        rounded-lg
                                        overflow-hidden">

                                <button type="button"
                                        class="w-9 h-9
                                               bg-gray-50
                                               hover:bg-gray-100
                                               font-bold"
                                        onclick="decreaseQty(this)">

                                    −

                                </button>


                                <input type="number"
                                       value="1"
                                       min="1"
                                       class="w-12 h-9
                                              text-center
                                              border-x
                                              border-gray-200
                                              text-sm
                                              focus:outline-none">


                                <button type="button"
                                        class="w-9 h-9
                                               bg-gray-50
                                               hover:bg-gray-100
                                               font-bold"
                                        onclick="increaseQty(this)">

                                    +

                                </button>

                            </div>


                            <!-- Cart -->
                            <button type="button"
                                    class="addToCartBtn
                                           flex-1
                                           min-w-[150px]
                                           bg-green-600
                                           hover:bg-green-700
                                           text-white
                                           font-semibold
                                           text-xs sm:text-sm
                                           py-2.5
                                           px-4
                                           rounded-lg
                                           transition
                                           flex items-center
                                           justify-center
                                           gap-2"

                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $sellingPrice }}"
                                    data-image="{{ url('uploads/products/'.$product->image) }}">

                                🛒 ব্যাগে যোগ করুন

                            </button>

                        </div>


                        <!-- Delivery -->
                        <div class="mt-4
                                    flex items-center gap-2
                                    text-xs text-gray-500">

                            🚚
                            <span>
                                অর্ডার করুন, আমরা আপনার ঠিকানায় পৌঁছে দেব।
                            </span>

                        </div>

                    </div>

                </div>



                <!-- Description -->
                <div class="border-t
                            border-gray-100
                            mt-6 pt-5">

                    <h3 class="text-sm sm:text-base
                               font-bold
                               text-green-700
                               mb-2">

                        📋 পণ্যের বিস্তারিত বিবরণ

                    </h3>

                    <p class="text-xs sm:text-sm
                              text-gray-600
                              leading-6">

                        {{ $product->description
                            ?? 'এই পণ্যের বিস্তারিত বিবরণ পাওয়া যায়নি।' }}

                    </p>

                </div>

            </div>

        </div>



        <!-- =========================
             OTHER PRODUCTS
        ========================== -->

        <div class="bg-white
                    rounded-2xl
                    border border-gray-100
                    shadow-sm
                    p-4 sm:p-5">

            <div class="mb-4">

                <h3 class="text-lg
                           font-bold
                           text-green-700">

                    🛍️ আরও পণ্য

                </h3>

                <p class="text-xs text-gray-500 mt-1">

                    আপনার প্রয়োজনের আরও কিছু পণ্য

                </p>

            </div>


            <div class="space-y-3">

                @forelse($othersProducts as $item)

                    @php
                        $itemOldPrice = (float) $item->price;
                        $itemDiscount = 5;
                        $itemSellingPrice = $itemOldPrice -
                            ($itemOldPrice * $itemDiscount / 100);
                    @endphp


                    <div class="flex gap-2.5
                                border-b border-gray-100
                                pb-3
                                last:border-0
                                last:pb-0">


                        <!-- Image -->
                        <a href="{{ route('home.product.details', $item->id) }}"
                           class="w-16 h-16
                                  flex-shrink-0
                                  rounded-lg
                                  overflow-hidden
                                  bg-gray-100">

                            @if($item->image)

                                <img src="{{ url('uploads/products/'.$item->image) }}"
                                     alt="{{ $item->name }}"
                                     class="w-full h-full object-cover">

                            @else

                                <div class="w-full h-full
                                            flex items-center
                                            justify-center">

                                    📦

                                </div>

                            @endif

                        </a>


                        <!-- Info -->
                        <div class="flex-1 min-w-0">

                            <a href="{{ route('home.product.details', $item->id) }}"
                               class="block
                                      text-xs
                                      font-semibold
                                      text-gray-800
                                      truncate
                                      hover:text-green-700">

                                {{ $item->name }}

                            </a>


                            <div class="flex items-center gap-1.5 mt-1">

                                <span class="text-sm
                                             font-bold
                                             text-green-700">

                                    ৳{{ bnNum($itemSellingPrice) }}

                                </span>

                                <span class="text-[10px]
                                             text-gray-400
                                             line-through">

                                    ৳{{ bnNum($itemOldPrice) }}

                                </span>

                            </div>


                            <button type="button"
                                    class="addToCartBtn
                                           mt-1.5
                                           bg-green-600
                                           hover:bg-green-700
                                           text-white
                                           text-[10px]
                                           px-2.5 py-1
                                           rounded-md"

                                    data-id="{{ $item->id }}"
                                    data-name="{{ $item->name }}"
                                    data-price="{{ $itemSellingPrice }}"
                                    data-image="{{ url('uploads/products/'.$item->image) }}">

                                🛒 যোগ করুন

                            </button>

                        </div>

                    </div>

                @empty

                    <p class="text-gray-500
                              text-center
                              text-xs
                              py-8">

                        বর্তমানে অন্য কোনো পণ্য নেই।

                    </p>

                @endforelse

            </div>

        </div>

    </div>

</section>



<!-- =========================
     🔄 RELATED PRODUCTS
========================== -->

<section class="max-w-7xl mx-auto
                px-4 sm:px-6
                pb-12 sm:pb-16">

    <div class="flex items-center
                justify-between
                mb-5">

        <div>

            <h3 class="text-lg sm:text-xl
                       font-bold
                       text-green-700">

                🔄 সম্পর্কিত পণ্য

            </h3>

            <p class="text-xs text-gray-500 mt-1">

                আপনার পছন্দ হতে পারে এমন আরও কিছু পণ্য

            </p>

        </div>

        <a href="{{ route('products.filter') }}"
           class="text-xs sm:text-sm
                  text-green-600
                  hover:underline">

            সব দেখুন →

        </a>

    </div>



    <!-- Product Grid -->
    <div class="grid grid-cols-2
                sm:grid-cols-3
                lg:grid-cols-4
                gap-3 sm:gap-5">


        @forelse($relatedProducts as $related)

            @php
                $relatedOldPrice = (float) $related->price;
                $relatedDiscount = 5;

                $relatedSellingPrice =
                    $relatedOldPrice -
                    ($relatedOldPrice * $relatedDiscount / 100);
            @endphp


            <div class="bg-white
                        rounded-xl
                        border border-gray-100
                        shadow-sm
                        hover:shadow-md
                        transition
                        overflow-hidden
                        group">


                <!-- Image -->
                <div class="relative">

                    <a href="{{ route('home.product.details', $related->id) }}">

                        <div class="h-32 sm:h-40
                                    bg-gray-100
                                    overflow-hidden">

                            @if($related->image)

                                <img src="{{ url('uploads/products/'.$related->image) }}"
                                     alt="{{ $related->name }}"
                                     class="w-full h-full
                                            object-cover
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


                    <!-- Discount -->
                    <span class="absolute top-2 left-2
                                 bg-red-500
                                 text-white
                                 px-2 py-1
                                 rounded-full
                                 text-[10px]
                                 font-bold">

                        🏷️ ৫% ছাড়

                    </span>

                </div>


                <!-- Info -->
                <div class="p-2.5 sm:p-3">

                    <a href="{{ route('home.product.details', $related->id) }}"
                       class="block
                              text-xs sm:text-sm
                              font-semibold
                              text-gray-800
                              line-clamp-2
                              leading-5
                              hover:text-green-700">

                        {{ $related->name }}

                    </a>


                    <!-- Price -->
                    <div class="flex items-center gap-1.5 mt-1.5">

                        <span class="text-sm sm:text-base
                                     font-bold
                                     text-green-700">

                            ৳{{ bnNum($relatedSellingPrice) }}

                        </span>

                        <span class="text-[10px] sm:text-xs
                                     text-gray-400
                                     line-through">

                            ৳{{ bnNum($relatedOldPrice) }}

                        </span>

                    </div>


                    <!-- Buttons -->
                    <div class="flex gap-1.5 mt-2.5">

                        <button type="button"
                                class="addToCartBtn
                                       flex-1
                                       bg-green-600
                                       hover:bg-green-700
                                       text-white
                                       text-[10px] sm:text-xs
                                       font-semibold
                                       py-2
                                       rounded-lg
                                       flex items-center
                                       justify-center
                                       gap-1"

                                data-id="{{ $related->id }}"
                                data-name="{{ $related->name }}"
                                data-price="{{ $relatedSellingPrice }}"
                                data-image="{{ url('uploads/products/'.$related->image) }}">

                            🛒 যোগ করুন

                        </button>


                        <a href="{{ route('home.product.details', $related->id) }}"
                           class="w-9
                                  py-2
                                  border border-green-600
                                  text-green-700
                                  hover:bg-green-600
                                  hover:text-white
                                  rounded-lg
                                  text-xs
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
                        py-10
                        text-sm">

                📦 কোনো সম্পর্কিত পণ্য পাওয়া যায়নি।

            </div>

        @endforelse

    </div>

</section>

@endsection