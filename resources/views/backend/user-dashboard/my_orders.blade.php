@extends('apps.dashboard_master')

@section('content')

@include('alerts.alert')

<div class="flex-1 flex flex-col">

    @include('backend.patrials.top_bar')

    <section class="bg-white p-2 md:p-6 rounded-2xl shadow mx-2 my-2 md:mx-6 md:my-6">

        <h2 class="text-2xl font-bold text-green-700 mb-6">
            📦 আমার অর্ডারসমূহ
        </h2>


        {{-- =====================================================
             FILTER
        ====================================================== --}}

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">

            <div>
                <label
                    for="dateFilter"
                    class="text-gray-600 font-semibold mr-2"
                >
                    Filter by:
                </label>

                <select
                    id="dateFilter"
                    class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none"
                >
                    <option value="today">Today</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="last7">Last 7 Days</option>
                    <option value="last15">Last 15 Days</option>
                    <option value="1month">1 Month</option>
                </select>
            </div>


            <div>
                <label
                    for="sortBy"
                    class="text-gray-600 font-semibold mr-2"
                >
                    Sort by:
                </label>

                <select
                    id="sortBy"
                    class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none"
                >
                    <option value="total_delivered_desc">
                        Total Delivered (High → Low)
                    </option>

                    <option value="total_delivered_asc">
                        Total Delivered (Low → High)
                    </option>

                    <option value="pending_orders_desc">
                        Pending Orders (High → Low)
                    </option>

                    <option value="pending_orders_asc">
                        Pending Orders (Low → High)
                    </option>
                </select>
            </div>

        </div>


        {{-- =====================================================
             ORDERS
        ====================================================== --}}

        <div class="w-full">

            @forelse($orders as $order)


                {{-- =================================================
                     PACKAGE ORDER
                ================================================== --}}

                @if($order->package_id && $order->package)

                    @php

                        $package = $order->package;

                        $recipient = $order->customer ?? $order->user;

                        $statusMap = [

                            'pending' => [
                                'text' => 'অর্ডার অপেক্ষমাণ',
                                'class' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                                'icon' => '🕓',
                            ],

                            'accepted' => [
                                'text' => 'অর্ডার গ্রহণ করা হয়েছে',
                                'class' => 'bg-blue-100 text-blue-700 border-blue-300',
                                'icon' => '✅',
                            ],

                            'rider_modified_accepted' => [
                                'text' => 'ডেলিভারির জন্য প্রস্তুত',
                                'class' => 'bg-indigo-100 text-indigo-700 border-indigo-300',
                                'icon' => '🚚',
                            ],

                            'delivered' => [
                                'text' => 'ডেলিভারি সম্পন্ন',
                                'class' => 'bg-green-100 text-green-700 border-green-300',
                                'icon' => '✅',
                            ],

                            'cancelled' => [
                                'text' => 'অর্ডার বাতিল',
                                'class' => 'bg-red-100 text-red-700 border-red-300',
                                'icon' => '❌',
                            ],

                        ];

                        $status = $statusMap[$order->status] ?? [
                            'text' => ucfirst($order->status ?? 'Unknown'),
                            'class' => 'bg-gray-100 text-gray-700 border-gray-300',
                            'icon' => 'ℹ️',
                        ];

                        $riderName = $order->rider->name ?? 'রাইডার নির্ধারণ হয়নি';

                        $deliveryTime = $order->delivery_time
                            ? $order->delivery_time . ' মিনিট'
                            : '-';

                        $deliveredTime = $order->delivered_at
                            ? \Carbon\Carbon::parse($order->delivered_at)->format('d M Y, h:i A')
                            : null;

                    @endphp


                    {{-- =================================================
                         PACKAGE CARD
                    ================================================== --}}

                    <div
                        class="relative p-5 mt-4 rounded-2xl shadow-md hover:shadow-lg transition border-2 border-green-200 bg-green-50/70 w-full mb-5"
                    >

                        {{-- Package badge --}}

                        <span
                            class="absolute -top-3 left-5 bg-green-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow"
                        >
                            📦 Package Order #{{ $order->id }}
                        </span>


                        {{-- Status --}}

                        <div class="flex justify-end mb-3">

                            <span
                                class="inline-flex items-center border rounded-full px-4 py-1.5 text-sm font-semibold {{ $status['class'] }}"
                            >
                                {{ $status['icon'] }}

                                <span class="ml-1">
                                    {{ $status['text'] }}
                                </span>
                            </span>

                        </div>


                        {{-- Main information --}}

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">


                            {{-- Package --}}

                            <div class="flex gap-4">

                                @if($package->image)

                                    <img
                                        src="{{ url('uploads/packages/' . $package->image) }}"
                                        alt="{{ $package->name }}"
                                        class="w-24 h-24 object-cover rounded-xl border bg-white flex-shrink-0"
                                    >

                                @endif


                                <div>

                                    <h3 class="text-lg font-bold text-green-700">
                                        {{ $package->name }}
                                    </h3>

                                    @if($package->description)

                                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">
                                            {{ $package->description }}
                                        </p>

                                    @endif

                                </div>

                            </div>


                            {{-- Customer --}}

                            <div>

                                <p class="font-semibold text-gray-700">

                                    @if(
                                        $order->customer_id &&
                                        $order->customer_id != $order->user_id
                                    )
                                        যার জন্য
                                    @else
                                        Customer
                                    @endif

                                </p>

                                <p class="text-green-700 font-semibold">
                                    {{ $recipient->name ?? '-' }}
                                </p>

                                <p class="text-sm text-gray-600">
                                    📞 {{ $recipient->phone ?? '-' }}
                                </p>

                                <p class="text-sm text-gray-600 mt-1">
                                    📍 {{ $order->delivery_address ?? '-' }}
                                </p>

                            </div>


                            {{-- Amount + Date --}}

                            <div class="md:text-right">

                                <p class="text-sm text-gray-500">
                                    অর্ডার সময়
                                </p>

                                <p class="font-semibold">
                                    {{ $order->created_at->format('d M Y, h:i A') }}
                                </p>

                                <p class="mt-2">

                                    <span class="text-gray-600">
                                        মোট:
                                    </span>

                                    <span class="text-xl font-bold text-green-700">
                                        ৳{{ number_format($order->total_amount, 2) }}
                                    </span>

                                </p>

                            </div>

                        </div>


                        {{-- Package Items --}}

                        <div class="mt-5 pt-4 border-t border-green-200">

                            <div class="flex items-center justify-between gap-3">

                                <p class="font-semibold text-gray-700">
                                    📦 Package Items
                                </p>

                                <a
                                    href="{{ route('home.package.details', $package->id) }}"
                                    class="text-sm font-semibold text-green-700 hover:text-green-900 hover:underline whitespace-nowrap"
                                >
                                    বিস্তারিত দেখুন →
                                </a>

                            </div>


                            <div class="flex flex-wrap gap-2 mt-3">

                                @forelse($package->items as $packageItem)

                                    <span
                                        class="inline-flex items-center bg-white border border-green-200 rounded-lg px-3 py-2 text-sm text-gray-700"
                                    >

                                        {{ $packageItem->product->name ?? 'অজানা পণ্য' }}

                                        <span class="ml-1 text-green-600 font-semibold">

                                            × {{ $packageItem->quantity }}

                                            {{ $packageItem->unit ?? ($packageItem->product->unit ?? '') }}

                                        </span>

                                    </span>

                                @empty

                                    <span class="text-sm text-gray-500">
                                        কোনো item পাওয়া যায়নি।
                                    </span>

                                @endforelse

                            </div>

                        </div>


                        {{-- Package Delivery Information --}}

                        @if(
                            in_array(
                                $order->status,
                                ['accepted', 'rider_modified_accepted', 'delivered']
                            )
                        )

                            <div class="mt-4 bg-white border border-green-200 rounded-xl p-3 text-sm">

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">

                                    <p>
                                        🚴
                                        <strong>রাইডারঃ</strong>
                                        {{ $riderName }}
                                    </p>


                                    <p>
                                        🕓
                                        <strong>ডেলিভারি সময়ঃ</strong>
                                        {{ $deliveryTime }}
                                    </p>


                                    @if($order->status === 'delivered')

                                        <p>

                                            @if($order->delivered_status === 'on_time')

                                                <span class="text-green-600 font-semibold">
                                                    ✓ সময়ে ডেলিভারি
                                                </span>

                                            @elseif($order->delivered_status === 'late')

                                                <span class="text-red-600 font-semibold">
                                                    ⚠ বিলম্বে ডেলিভারি
                                                </span>

                                            @else

                                                <span class="text-gray-600 font-semibold">
                                                    ✓ ডেলিভারি সম্পন্ন
                                                </span>

                                            @endif

                                        </p>

                                    @endif

                                </div>


                                @if(
                                    $order->status === 'delivered' &&
                                    $deliveredTime
                                )

                                    <div class="mt-2 pt-2 border-t border-gray-200 text-gray-600">

                                        📅
                                        <strong>ডেলিভারি সম্পন্নঃ</strong>
                                        {{ $deliveredTime }}

                                    </div>

                                @endif

                            </div>

                        @endif

                    </div>


                {{-- =================================================
                     NORMAL ORDER
                ================================================== --}}

                @else

                    @php

                        /*
                        |--------------------------------------------------------------------------
                        | Quantity Summary
                        |--------------------------------------------------------------------------
                        */

                        $quantities = [
                            'কেজি' => [],
                            'পিস' => [],
                            'ডজন' => [],
                            'লিটার' => [],
                            'প্যাকেট' => [],
                            'টাকা' => [],
                        ];


                        foreach ($order->items as $item) {

                            $product = $item->product;

                            $name = $product->name ?? 'অজানা পণ্য';

                            $unit = trim($product->unit ?? '');

                            $qty = (float) ($item->quantity ?? 0);


                            if (
                                $unit &&
                                isset($quantities[$unit])
                            ) {

                                $quantities[$unit][] =
                                    "{$name} ({$qty} {$unit})";
                            }

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Custom Products
                        |--------------------------------------------------------------------------
                        */

                        if (!empty($order->custom_products)) {

                            foreach ($order->custom_products as $custom) {

                                $name = $custom['name'] ?? 'অজানা পণ্য';

                                $qty = (float) ($custom['quantity'] ?? 0);

                                $price = (float) ($custom['price'] ?? 0);

                                $unit = trim($custom['unit'] ?? '');


                                if ($unit === 'টাকা') {

                                    $quantities['টাকা'][] =
                                        "{$name} ({$price} টাকা)";

                                } elseif (isset($quantities[$unit])) {

                                    $quantities[$unit][] =
                                        "{$name} ({$qty} {$unit})";

                                } else {

                                    $quantities['টাকা'][] =
                                        "{$name} ({$price} টাকা)";
                                }

                            }

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Final Quantity Text
                        |--------------------------------------------------------------------------
                        */

                        $quantityParts = [];


                        foreach (
                            ['কেজি', 'পিস', 'ডজন', 'লিটার', 'প্যাকেট', 'টাকা']
                            as $unit
                        ) {

                            if (!empty($quantities[$unit])) {

                                $quantityParts[] =
                                    implode(', ', $quantities[$unit]);
                            }

                        }


                        $totalText =
                            implode(', ', $quantityParts) ?: '-';


                        /*
                        |--------------------------------------------------------------------------
                        | Status
                        |--------------------------------------------------------------------------
                        */

                        $statusMap = [

                            'pending' => [
                                'text' => 'অর্ডার অপেক্ষমাণ',
                                'class' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                                'icon' => '🕓',
                            ],

                            'accepted' => [
                                'text' => 'অর্ডার গ্রহণ করা হয়েছে',
                                'class' => 'bg-blue-100 text-blue-700 border-blue-300',
                                'icon' => '✅',
                            ],

                            'rider_modified_accepted' => [
                                'text' => 'ডেলিভারির জন্য প্রস্তুত',
                                'class' => 'bg-indigo-100 text-indigo-700 border-indigo-300',
                                'icon' => '🚚',
                            ],

                            'delivered' => [
                                'text' => 'ডেলিভারি সম্পন্ন',
                                'class' => 'bg-green-100 text-green-700 border-green-300',
                                'icon' => '✅',
                            ],

                            'cancelled' => [
                                'text' => 'অর্ডার বাতিল',
                                'class' => 'bg-red-100 text-red-700 border-red-300',
                                'icon' => '❌',
                            ],

                        ];


                        $status = $statusMap[$order->status] ?? [
                            'text' => ucfirst($order->status ?? 'Unknown'),
                            'class' => 'bg-gray-100 text-gray-700 border-gray-300',
                            'icon' => 'ℹ️',
                        ];


                        /*
                        |--------------------------------------------------------------------------
                        | Delivery Information
                        |--------------------------------------------------------------------------
                        */

                        $showDeliveryInfo = in_array(
                            $order->status,
                            [
                                'accepted',
                                'rider_modified_accepted',
                                'delivered'
                            ]
                        );


                        $riderName =
                            $order->rider->name
                            ?? 'রাইডার নির্ধারণ হয়নি';


                        $deliveryTime =
                            $order->delivery_time
                            ? $order->delivery_time . ' মিনিট'
                            : '-';


                        $deliveredTime =
                            $order->delivered_at
                            ? \Carbon\Carbon::parse(
                                $order->delivered_at
                            )->format('d M Y, h:i A')
                            : null;

                    @endphp


                    {{-- =================================================
                         NORMAL ORDER CARD
                    ================================================== --}}

                    <div
                        class="relative bg-white p-5 mt-3 rounded-2xl shadow-md hover:shadow-lg border w-full mb-4"
                    >

                        {{-- Order ID --}}

                        <span
                            class="absolute -top-3 left-5 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow"
                        >
                            অর্ডার আইডি: #{{ $order->id }}
                        </span>


                        {{-- Status --}}

                        <div class="flex justify-end mt-1">

                            <span
                                class="inline-flex items-center border rounded-full px-3 py-1 text-xs font-semibold {{ $status['class'] }}"
                            >

                                {{ $status['icon'] }}

                                <span class="ml-1">
                                    {{ $status['text'] }}
                                </span>

                            </span>

                        </div>


                        {{-- Main Information --}}

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-3">


                            {{-- Customer --}}

                            <div>

                                <h4 class="text-lg font-semibold text-green-700">
                                    {{ $order->user->name ?? 'অজানা ক্রেতা' }}
                                </h4>

                                <p class="text-sm text-gray-600">
                                    পিতার নামঃ
                                    {{ $order->user->father_name ?? '-' }}
                                </p>

                                <p>
                                    📞 {{ $order->user->phone ?? '-' }}
                                </p>

                            </div>


                            {{-- Product / Total / Address --}}

                            <div>

                                <p>
                                    <strong>পণ্যঃ</strong>
                                    {{ $order->items->count() }} টি
                                </p>

                                <p>
                                    <strong>মোটঃ</strong>
                                    ৳{{ number_format($order->total_amount, 2) }}
                                </p>

                                <p>
                                    <strong>ঠিকানাঃ</strong>
                                    {{ $order->delivery_address ?? '-' }}
                                </p>

                            </div>


                            {{-- Order Time --}}

                            <div class="md:text-right">

                                <p>

                                    <strong>
                                        অর্ডার সময়ঃ
                                    </strong>

                                    {{ $order->created_at->format('d M Y, h:i A') }}

                                </p>

                            </div>

                        </div>


                        {{-- Quantity --}}

                        <p class="text-sm text-red-500 my-3">

                            <strong>
                                মোট পরিমাণঃ
                            </strong>

                            {{ $totalText }}

                        </p>


                        {{-- Delivery Information --}}

                        @if($showDeliveryInfo)

                            <div
                                class="mt-3 text-sm bg-indigo-50 text-gray-700 border-t p-2 rounded-md"
                            >

                                <div
                                    class="flex flex-col md:flex-row md:justify-between md:items-center gap-2"
                                >

                                    <p>
                                        🚴
                                        <strong>
                                            রাইডারঃ
                                        </strong>

                                        {{ $riderName }}
                                    </p>


                                    <p>
                                        🕓
                                        <strong>
                                            এস্টিমেট সময়ঃ
                                        </strong>

                                        {{ $deliveryTime }}
                                    </p>


                                    @if($order->status === 'delivered')

                                        <p>

                                            @if($order->delivered_status === 'on_time')

                                                <span class="text-green-600 font-semibold">
                                                    ✓ সময়ে ডেলিভারি
                                                </span>

                                            @elseif($order->delivered_status === 'late')

                                                <span class="text-red-600 font-semibold">
                                                    ⚠ বিলম্বে ডেলিভারি
                                                </span>

                                            @else

                                                <span class="text-gray-600 font-semibold">
                                                    ✓ ডেলিভারি সম্পন্ন
                                                </span>

                                            @endif

                                        </p>

                                    @endif

                                </div>


                                @if(
                                    $order->status === 'delivered' &&
                                    $deliveredTime
                                )

                                    <div
                                        class="mt-2 pt-2 border-t border-indigo-100 text-gray-600"
                                    >

                                        📅
                                        <strong>
                                            ডেলিভারি সম্পন্নঃ
                                        </strong>

                                        {{ $deliveredTime }}

                                    </div>

                                @endif

                            </div>

                        @endif

                    </div>

                @endif

            @empty

                <div class="text-gray-600 text-center py-10">

                    📭 কোনো অর্ডার পাওয়া যায়নি।

                </div>

            @endforelse

        </div>

    </section>

</div>

@endsection

