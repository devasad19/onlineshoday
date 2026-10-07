@extends('apps.dashboard_master')

@section('content')

<div class="flex min-h-screen bg-gray-50">

    <!-- Sidebar -->

    <div class="flex-1 flex flex-col">

        @include('backend.patrials.top_bar')

        <section class="bg-white p-6 rounded-2xl shadow mx-6 my-6">

            <h2 class="text-2xl font-bold text-green-700 mb-6">
                📦 লাইভ অর্ডার বোর্ড
            </h2>

            <!-- Filter -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">

                <form method="GET" action="{{ route('rider.orders') }}" class="w-full">

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                        <!-- Date -->
                        <div class="flex items-center gap-2 flex-wrap">

                            <label class="font-semibold">
                                তারিখ:
                            </label>

                            <select
                                name="date_filter"
                                onchange="this.form.submit()"
                                class="border rounded-lg px-3 py-2">

                                <option value="today"
                                    {{ request('date_filter') == 'today' ? 'selected' : '' }}>
                                    Today
                                </option>

                                <option value="yesterday"
                                    {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>
                                    Yesterday
                                </option>

                                <option value="range"
                                    {{ request('date_filter') == 'range' ? 'selected' : '' }}>
                                    Date Range
                                </option>

                                <option value="all"
                                    {{ request('date_filter', 'all') == 'all' ? 'selected' : '' }}>
                                    All Orders
                                </option>

                            </select>

                            <input
                                type="date"
                                name="from_date"
                                value="{{ request('from_date') }}"
                                onchange="this.form.submit()"
                                class="border rounded-lg px-3 py-2
                                {{ request('date_filter') == 'range' ? '' : 'hidden' }}">

                            <span class="{{ request('date_filter') == 'range' ? '' : 'hidden' }}">
                                -
                            </span>

                            <input
                                type="date"
                                name="to_date"
                                value="{{ request('to_date') }}"
                                onchange="this.form.submit()"
                                class="border rounded-lg px-3 py-2
                                {{ request('date_filter') == 'range' ? '' : 'hidden' }}">

                        </div>

                        <!-- Search -->
                        <div>

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Customer Name, Phone"
                                class="border rounded-lg px-3 py-2 w-64">

                        </div>

                        <!-- Status -->
                        <div>

                            <select
                                name="status"
                                onchange="this.form.submit()"
                                class="border rounded-lg px-3 py-2">

                                <option value="">
                                    All
                                </option>

                                <option value="accepted"
                                    {{ request('status') == 'accepted' ? 'selected' : '' }}>
                                    Accepted
                                </option>

                                <option value="rider_modified_accepted"
                                    {{ request('status') == 'rider_modified_accepted' ? 'selected' : '' }}>
                                    Modified
                                </option>

                                <option value="delivered"
                                    {{ request('status') == 'delivered' ? 'selected' : '' }}>
                                    Delivered
                                </option>

                            </select>

                        </div>

                        <button
                            type="submit"
                            class="bg-green-600 text-white px-5 py-2 rounded-lg">

                            Search

                        </button>

                    </div>

                </form>

            </div>


            <!-- Bulk Print Toolbar -->
            <div
                id="bulkPrintToolbar"
                class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 mb-4 flex flex-wrap items-center justify-between gap-3 no-print">

                <div class="flex items-center gap-3">

                    <label class="flex items-center gap-2 cursor-pointer">

                        <input
                            type="checkbox"
                            id="selectAllOrders"
                            class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">

                        <span class="font-semibold text-gray-700">
                            সব নির্বাচন
                        </span>

                    </label>

                    <span id="selectedOrderCount" class="text-sm text-gray-500">
                        0 টি নির্বাচিত
                    </span>

                </div>

                <button
                    type="button"
                    id="bulkPrintBtn"
                    disabled
                    class="bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-semibold px-5 py-2 rounded-lg transition">
                    🖨️ নির্বাচিত অর্ডার প্রিন্ট
                </button>

            </div>

            <!-- Orders -->
            <div id="ordersList" class="overflow-x-auto">

                @if($orders->count() > 0)

                    @foreach ($orders as $order)

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | Package Order Check
                            |--------------------------------------------------------------------------
                            */

                            $isPackageOrder =
                                ($order->type ?? null) === 'package'
                                || !empty($order->package_id)
                                || !empty($order->package);


                            /*
                            |--------------------------------------------------------------------------
                            | Total Product Count
                            |--------------------------------------------------------------------------
                            */

                            if ($isPackageOrder) {

                                $normalProductCount =
                                    ($order->package && $order->package->items)
                                        ? $order->package->items->count()
                                        : 0;

                            } else {

                                $normalProductCount =
                                    is_countable($order->items ?? null)
                                        ? count($order->items ?? [])
                                        : 0;
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Custom Product Data
                            |--------------------------------------------------------------------------
                            */

                            $customProductData = [];

                            if (!empty($order->custom_products)) {

                                if (is_string($order->custom_products)) {

                                    $decoded = json_decode($order->custom_products, true);

                                    $customProductData =
                                        is_array($decoded) ? $decoded : [];

                                } elseif (is_array($order->custom_products)) {

                                    $customProductData = $order->custom_products;

                                } elseif ($order->custom_products instanceof \Illuminate\Support\Collection) {

                                    $customProductData = $order->custom_products->toArray();
                                }
                            }

                            $customProductCount = count($customProductData);

                            $totalProductCount =
                                $normalProductCount + $customProductCount;


                            /*
                            |--------------------------------------------------------------------------
                            | Delivery Time Calculation
                            |--------------------------------------------------------------------------
                            */

                            $deliveryDeadline = null;
                            $deliveryStatusText = null;
                            $deliveryStatusClass = 'text-gray-500';

                            if (!empty($order->accepted_at) && !empty($order->delivery_time)) {

                                try {

                                    $acceptedAt = \Carbon\Carbon::parse($order->accepted_at);

                                    $deliveryDeadline =
                                        $acceptedAt->copy()->addMinutes((int) $order->delivery_time);

                                    if ($order->status === 'delivered' && !empty($order->delivered_at)) {

                                        $deliveredAt = \Carbon\Carbon::parse($order->delivered_at);

                                        $lateMinutes = $deliveryDeadline->diffInMinutes($deliveredAt);

                                        if ($deliveredAt->lte($deliveryDeadline)) {
                                            $deliveryStatusText = 'সময়মতো ডেলিভারি';
                                            $deliveryStatusClass = 'text-green-600';
                                        } else {
                                            $deliveryStatusText = 'দেরিতে ডেলিভারি — ' . $lateMinutes . ' মিনিট late';
                                            $deliveryStatusClass = 'text-red-600';
                                        }

                                    } else {

                                        $now = now();

                                        if ($now->lte($deliveryDeadline)) {
                                            $remainingMinutes = $now->diffInMinutes($deliveryDeadline);
                                            $deliveryStatusText = 'সময় বাকি — ' . $remainingMinutes . ' মিনিট';
                                            $deliveryStatusClass = 'text-green-600';
                                        } else {
                                            $lateMinutes = $deliveryDeadline->diffInMinutes($now);
                                            $deliveryStatusText = 'ডেলিভারি সময় পার — ' . $lateMinutes . ' মিনিট late';
                                            $deliveryStatusClass = 'text-red-600';
                                        }
                                    }

                                } catch (\Throwable $e) {
                                    $deliveryDeadline = null;
                                    $deliveryStatusText = null;
                                }
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Normal Product Quantity Summary
                            |--------------------------------------------------------------------------
                            */

                            $totals = [
                                'কেজি'   => [],
                                'পিস'    => [],
                                'ডজন'   => [],
                                'লিটার' => [],
                                'প্যাকেট'=> [],
                                'টাকা'   => []
                            ];


                            /*
                            |--------------------------------------------------------------------------
                            | Normal Products
                            |--------------------------------------------------------------------------
                            */

                            foreach ($order->items ?? [] as $item) {

                                $name = $item->product->name ?? 'অজানা পণ্য';

                                $unit = trim(
                                    $item->product->unit ?? ''
                                );

                                $qty = floatval(
                                    $item->quantity ?? 0
                                );

                                if (
                                    $unit &&
                                    array_key_exists($unit, $totals)
                                ) {

                                    $totals[$unit][] =
                                        "{$name} ({$qty} {$unit})";

                                }

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Custom Products
                            |--------------------------------------------------------------------------
                            */

                            if (!empty($customProductData)) {

                                foreach ($customProductData as $cp) {

                                    /*
                                    | custom_products may be array or object
                                    */

                                    if (is_object($cp)) {

                                        $name =
                                            $cp->name ?? 'অজানা পণ্য';

                                        $qty =
                                            floatval($cp->quantity ?? 0);

                                        $price =
                                            floatval($cp->price ?? 0);

                                        $unit =
                                            trim($cp->unit ?? '');

                                    } else {

                                        $name =
                                            $cp['name'] ?? 'অজানা পণ্য';

                                        $qty =
                                            floatval($cp['quantity'] ?? 0);

                                        $price =
                                            floatval($cp['price'] ?? 0);

                                        $unit =
                                            trim($cp['unit'] ?? '');

                                    }


                                    if ($unit === 'টাকা') {

                                        $totals['টাকা'][] =
                                            "{$name} ({$price} টাকা)";

                                    } elseif (
                                        $unit &&
                                        array_key_exists($unit, $totals)
                                    ) {

                                        $totals[$unit][] =
                                            "{$name} ({$qty} {$unit})";

                                    } else {

                                        $totals['টাকা'][] =
                                            "{$name} ({$price} টাকা)";

                                    }

                                }

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Total Text
                            |--------------------------------------------------------------------------
                            */

                            $totalTextParts = [];

                            foreach (
                                ['কেজি','পিস','ডজন','লিটার','প্যাকেট','টাকা']
                                as $unit
                            ) {

                                if (
                                    count($totals[$unit]) > 0
                                ) {

                                    $totalTextParts[] =
                                        implode(', ', $totals[$unit]);

                                }

                            }

                            $totalText =
                                implode(', ', $totalTextParts) ?: '-';

                        @endphp


                        <!-- Order Card -->
                        <div class="w-full mb-4">

                            <div
                                class="relative bg-white p-5 mt-2 rounded-2xl shadow-md
                                hover:shadow-lg transition
                                order-item border border-gray-100 w-full"
                                data-order-id="{{ $order->id }}">

                                <!-- Print Checkbox -->
<!-- Print Button -->

<div class="absolute -top-3 right-4 no-print z-10">
    <label
        class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-2 py-1 rounded-lg cursor-pointer transition shadow-sm"
    >
        <input
            type="checkbox"
            class="orderPrintCheckbox w-4 h-4 rounded border-white text-indigo-600 focus:ring-white"
            value="{{ $order->id }}"
        >

 
    <span>
        🖨️ প্রিন্ট
    </span>
</label>
 

</div>



                                <!-- Order ID -->
                                <span
                                    class="absolute -top-3 left-5
                                    bg-indigo-600 text-white text-xs font-bold
                                    px-3 py-1 rounded-full shadow">

                                    অর্ডার আইডি:
                                    #{{ $order->id }}

                                </span>


                                <!-- Package Label -->
                                @if($isPackageOrder)

                                    <span
                                        class="absolute -top-3 right-5
                                        bg-purple-600 text-white text-xs font-bold
                                        px-3 py-1 rounded-full shadow">

                                        📦 প্যাকেজ অর্ডার 

                                    </span>

                                @endif


                                <div
                                    class="grid grid-cols-1 md:grid-cols-3
                                    gap-6 items-start">


                                    <!-- Customer Info -->
                                    <div>

                                        <h4
                                            class="text-lg font-semibold
                                            text-green-700 mb-1">

                                            {{ $order->user->name ?? 'অজানা ক্রেতা' }}

                                        </h4>

                                        <p class="text-sm text-gray-600">

                                            পিতার নামঃ
                                            {{ $order->user->father_name ?? '-' }}

                                        </p>

                                        <p class="text-sm text-gray-600">

                                            📞
                                            {{ $order->user->phone ?? '-' }}

                                        </p>

                                        @if($order->customer && $order->customer_id != $order->user_id)

                                            <p class="text-sm text-blue-600 mt-1">

                                                <strong>
                                                    যার জন্যঃ
                                                </strong>

                                                {{ $order->customer->name ?? '-' }}

                                            </p>

                                            <p class="text-xs text-gray-500">

                                                📞
                                                {{ $order->customer->phone ?? '-' }}

                                            </p>

                                        @endif

                                    </div>


                                    <!-- Order Info -->
                                    <div class="text-gray-700">

                                        @if($isPackageOrder)

                                            <p>
                                                <strong>অর্ডারের ধরনঃ</strong>
                                                <span class="text-purple-700 font-semibold">
                                                    📦 প্যাকেজ
                                                </span>
                                            </p>

                                            <p>
                                                <strong>পণ্যঃ</strong>
                                                {{ $totalProductCount }} টি
                                            </p>

                                        @else

                                            <p>
                                                <strong>পণ্যঃ</strong>
                                                {{ $totalProductCount }} টি
                                            </p>

                                        @endif

                                        <p>
                                            <strong>মোটঃ</strong>
                                            <span class="text-green-700 font-semibold">
                                                ৳ {{ $order->total_amount }}
                                            </span>
                                        </p>

                                        <p>
                                            <strong>ঠিকানাঃ</strong>
                                            {{ $order->delivery_address ?? '-' }}
                                        </p>

                                    </div>


                                    <!-- Time & Action -->
                                    <div class="flex flex-col justify-between text-left md:text-right">

                                        <p class="text-sm text-gray-500 mb-2">
                                            <strong>অর্ডার সময়ঃ</strong>
                                            {{ $order->created_at }}
                                        </p>

                                        @if(!empty($order->accepted_at))
                                            <p class="text-sm text-gray-500 mb-2">
                                                <strong>গ্রহণ সময়ঃ</strong>
                                                {{ \Carbon\Carbon::parse($order->accepted_at)->format('d-m-Y h:i A') }}
                                            </p>
                                        @endif

                                        @if($deliveryDeadline)
                                            <p class="text-sm text-gray-600 mb-2">
                                                <strong>ডেলিভারি সময়সীমাঃ</strong>
                                                {{ $deliveryDeadline->format('d-m-Y h:i A') }}
                                            </p>
                                        @endif

                                        @if($deliveryStatusText)
                                            <p class="text-sm font-semibold {{ $deliveryStatusClass }} mb-3">
                                                🚚 {{ $deliveryStatusText }}
                                            </p>
                                        @endif

                                        @if($order->status == 'delivered' && !empty($order->delivered_at))
                                            <p class="text-sm text-gray-600 mb-3">
                                                <strong>ডেলিভারি সময়ঃ</strong>
                                                {{ \Carbon\Carbon::parse($order->delivered_at)->format('d-m-Y h:i A') }}
                                            </p>
                                        @endif

                                        <div class="flex flex-wrap gap-2 no-print md:justify-end">

                                            @if ($order->status == 'accepted')

                                                <button
                                                    type="button"
                                                    class="deliverBtn bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-lg transition w-full md:w-auto"
                                                    data-id="{{ $order->id }}">
                                                    ✅ ডেলিভারি সম্পন্ন করুন
                                                </button>

                                                @if(!empty($order->delivery_time))
                                                    <p class="w-full text-xs bg-blue-50 text-blue-700 p-3 rounded-lg">
                                                        ⏱️ এস্টিমেট ডেলিভারি সময়ঃ {{ $order->delivery_time }} মিনিট
                                                    </p>
                                                @endif

                                            @elseif($order->status == 'rider_modified_accepted')

                                                <button
                                                    type="button"
                                                    class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold px-5 py-2 rounded-lg transition w-full md:w-auto">
                                                    ⏳ মুল্য বর্ধিত পাঠানো হয়েছে
                                                </button>

                                            @elseif($order->status == 'delivered')

                                                <span class="inline-flex items-center bg-green-100 text-green-700 px-4 py-2 rounded-lg font-semibold">
                                                    ✅ ডেলিভারি সম্পন্ন হয়েছে
                                                </span>

                                            @endif

                                         

                                                    <a
            href="{{ url('/admin/orders') }}/{{$order->id}}/print"
            target="_blank"
            class="singlePrintBtn bg-gray-700 hover:bg-gray-800 text-white font-semibold px-5 py-2 rounded-lg transition"
        >
            🖨 Invoice Print
        </a>

                                        </div>

                                    </div>

                                </div>


                                <!-- ================================================= -->
                                <!-- PACKAGE DETAILS -->
                                <!-- ================================================= -->

                        
 
@if($isPackageOrder && $order->package)

    <div
        class="  mt-5 p-4 rounded-xl
        bg-purple-50
        border border-purple-200">

  

        <!-- ===================================================== -->
        <!-- PACKAGE HEADER -->
        <!-- ===================================================== -->

        <div
            class="flex flex-col md:flex-row
            gap-4 items-start">



            <!-- Package Image -->
            @if(!empty($order->package->image))

                <div class="shrink-0">

                    <img
                        src="{{ asset('uploads/packages/' . $order->package->image) }}"
                        alt="{{ $order->package->name }}"
                        class="w-24 h-24 object-cover
                        rounded-xl border border-purple-200">

                </div>

            @endif


            <!-- Package Info -->
            <div class="flex-1 w-full">

                <div
                    class="flex flex-col md:flex-row
                    md:items-center md:justify-between gap-2">

                    
                    <h3
                        class="text-lg font-bold text-purple-800">

                        📦 {{ $order->package->name ?? 'প্যাকেজ' }}

                    </h3>


                    <!-- Delivery Status -->
                    @if($order->status === 'accepted')

                        <span
                            class="inline-flex items-center
                            bg-green-100 text-green-700
                            border border-green-200
                            px-3 py-1 rounded-full
                            text-xs font-bold">

                            🛵 ডেলিভারি বাকি

                        </span>

                    @elseif($order->status === 'rider_modified_accepted')

                        <span
                            class="inline-flex items-center
                            bg-yellow-100 text-yellow-700
                            border border-yellow-200
                            px-3 py-1 rounded-full
                            text-xs font-bold">

                            ⏳ মূল্য পরিবর্তন হয়েছে

                        </span>

                    @elseif($order->status === 'delivered')

                        <span
                            class="inline-flex items-center
                            bg-gray-100 text-gray-700
                            border border-gray-300
                            px-3 py-1 rounded-full
                            text-xs font-bold">

                            ✅ ডেলিভারি সম্পন্ন

                        </span>

                    @else

                        <span
                            class="inline-flex items-center
                            bg-blue-100 text-blue-700
                            border border-blue-200
                            px-3 py-1 rounded-full
                            text-xs font-bold">

                            {{ $order->status }}

                        </span>

                    @endif

                </div>


                @if(!empty($order->package->description))

                    <p
                        class="text-sm text-gray-600 mt-1">

                        {{ $order->package->description }}

                    </p>

                @endif


                <!-- Package Basic Information -->
                <div
                    class="grid grid-cols-2 md:grid-cols-4
                    gap-2 mt-3 text-sm">


                     


                    <!-- Package Price -->
                    <div
                        class="bg-white border border-purple-100
                        rounded-lg px-3 py-2">

                        <span class="text-gray-500 block text-xs">
                            প্যাকেজ মূল্য
                        </span>

                        <span
                            class="font-bold text-gray-800">

                            ৳ {{ number_format((float) $order->package->price, 2) }}

                        </span>

                    </div>


                    <!-- Discount -->
                    <div
                        class="bg-white border border-purple-100
                        rounded-lg px-3 py-2">

                        <span class="text-gray-500 block text-xs">
                            Discount
                        </span>

                        <span
                            class="font-bold text-red-600">

                            ৳ {{ number_format((float) ($order->package->discount ?? 0), 2) }}

                        </span>

                    </div>


                    <!-- Final Amount -->
                    <div
                        class="bg-white border border-purple-100
                        rounded-lg px-3 py-2">

                        <span class="text-gray-500 block text-xs">
                            পরিশোধযোগ্য
                        </span>

                        <span
                            class="font-bold text-green-700">

                            ৳ {{ number_format((float) $order->total_amount, 2) }}

                        </span>

                    </div>

                </div>

            </div>

        </div>


        <!-- ===================================================== -->
        <!-- PACKAGE ITEMS -->
        <!-- ===================================================== -->

        @if($order->package->items && $order->package->items->count())

            <div class="mt-5">

                <h4
                    class="font-bold text-purple-800 mb-2">

                    📋 প্যাকেজের পণ্যসমূহ

                </h4>


                <div
                    class="bg-white rounded-lg
                    border border-purple-100
                    overflow-hidden">


                    @foreach($order->package->items as $packageItem)

                        <div
                            class="flex items-center
                            gap-3 px-4 py-3
                            border-b last:border-b-0
                            border-gray-100">


                            <!-- Product Image -->
                            <div class="shrink-0">

                                @if(
                                    !empty($packageItem->product->image)
                                )

                                    <img
                                        src="{{ asset('uploads/products/' . $packageItem->product->image) }}"
                                        alt="{{ $packageItem->product->name ?? 'Product' }}"
                                        class="w-14 h-14 object-cover
                                        rounded-lg border border-gray-200">

                                @else

                                    <div
                                        class="w-14 h-14 rounded-lg
                                        bg-gray-100
                                        border border-gray-200
                                        flex items-center justify-center
                                        text-gray-400 text-xl">

                                        📦

                                    </div>

                                @endif

                            </div>


                            <!-- Product Name -->
                            <div class="flex-1 min-w-0">

                                <p
                                    class="font-medium text-gray-800">

                                    {{ $packageItem->product->name ?? 'অজানা পণ্য' }}

                                </p>

                                @if(!empty($packageItem->product->unit))

                                    <p
                                        class="text-xs text-gray-500 mt-1">

                                        Unit:
                                        {{ $packageItem->product->unit }}

                                    </p>

                                @endif

                            </div>


                            <!-- Quantity -->
                            <div
                                class="text-right
                                whitespace-nowrap">

                                <p
                                    class="text-sm font-bold
                                    text-purple-700">

                                    {{ $packageItem->quantity ?? 0 }}

                                    {{ $packageItem->unit
                                        ?? ($packageItem->product->unit ?? '') }}

                                </p>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        @else

            <p
                class="text-sm text-red-600 mt-3">

                ⚠️ এই প্যাকেজের কোনো পণ্য পাওয়া যায়নি।

            </p>

        @endif


    </div>

@endif



                                <!-- ================================================= -->
                                <!-- NORMAL ORDER TOTAL QUANTITY -->
                                <!-- ================================================= -->

                                @if(!$isPackageOrder)

                                    <p
                                        class="text-sm text-red-500 mt-3">

                                        <strong>
                                            মোট পরিমাণঃ
                                        </strong>

                                        {{ $totalText }}

                                    </p>

                                @endif


                            </div>

                        </div>

                    @endforeach

                @else

                    <p class="text-gray-600">

                        📭 কোনো অর্ডার পাওয়া যায়নি।

                    </p>

                @endif

            </div>

        </section>

    </div>

</div>

@endsection


@section('scripts')

<style>
    @media print {
        body * {
            visibility: hidden !important;
        }

        #ordersList,
        #ordersList * {
            visibility: visible !important;
        }

        #ordersList {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            overflow: visible !important;
        }

        #ordersList .no-print,
        .no-print {
            display: none !important;
        }

        .print-hide {
            display: none !important;
        }

        .order-item {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            box-shadow: none !important;
            margin-bottom: 20px !important;
        }
    }
</style>

<script>

$(document).ready(function () {

    function updateSelectedCount() {

        const selectedCount =
            $('.orderPrintCheckbox:checked').length;

        $('#selectedOrderCount')
            .text(selectedCount + ' টি নির্বাচিত');

        $('#bulkPrintBtn')
            .prop('disabled', selectedCount === 0);

        const totalCount =
            $('.orderPrintCheckbox').length;

        $('#selectAllOrders')
            .prop(
                'checked',
                totalCount > 0 && selectedCount === totalCount
            );
    }


    $(document).on('change', '.orderPrintCheckbox', function () {
        updateSelectedCount();
    });


    $(document).on('change', '#selectAllOrders', function () {

        const checked = $(this).is(':checked');

        $('.orderPrintCheckbox')
            .prop('checked', checked);

        updateSelectedCount();
    });


    function printOrders(orderIds) {

        if (!orderIds || orderIds.length === 0) {

            Swal.fire({
                icon: 'warning',
                title: 'কোনো অর্ডার নির্বাচন করা হয়নি',
                text: 'প্রিন্ট করার জন্য অন্তত একটি অর্ডার নির্বাচন করুন।'
            });

            return;
        }


        $('.order-item').each(function () {

            const orderId =
                String($(this).data('order-id'));

            if (!orderIds.includes(orderId)) {
                $(this).addClass('print-hide');
            }
        });


        let restored = false;

        const restoreOrders = function () {

            if (restored) {
                return;
            }

            restored = true;

            $('.order-item')
                .removeClass('print-hide');
        };


        $(window)
            .off('afterprint.orderPrint')
            .on('afterprint.orderPrint', restoreOrders);


        setTimeout(function () {
            window.print();
        }, 100);


        setTimeout(function () {
            restoreOrders();
        }, 1000);
    }


  

 
    
// ==========================================
// Bulk Print
// ==========================================

$("#bulkPrintBtn").on("click", function(){

    if(selectedOrders.size === 0){
        return;
    }

    const form = $("<form>", {
        method: "POST",
        action: "{{ route('admin.orders.bulkPrint') }}",
        target: "_blank"
    });

    form.append(
        $("<input>", {
            type: "hidden",
            name: "_token",
            value: "{{ csrf_token() }}"
        })
    );


    selectedOrders.forEach(function(id){

        form.append(
            $("<input>", {
                type: "hidden",
                name: "order_ids[]",
                value: id
            })
        );

    });


    $("body").append(form);

    form.submit();

    form.remove();

});



    $(document).on('click', '.deliverBtn', function () {

        const btn = $(this);
        const orderId = btn.data('id');

        btn
            .prop('disabled', true)
            .text('⏳ প্রসেস হচ্ছে...');

        $.ajax({

            url: "{{ route('rider.orders.deliver', ':id') }}"
                .replace(':id', orderId),

            method: "POST",

            data: {
                _token: "{{ csrf_token() }}"
            },

            success: function (res) {

                if (res.success) {

                    Swal.fire({
                        icon: 'success',
                        title: 'সফল!',
                        text: res.message ||
                            'ডেলিভারি সফলভাবে সম্পন্ন হয়েছে।',
                        confirmButtonColor: '#16a34a',
                        confirmButtonText: 'ঠিক আছে'
                    }).then(function () {
                        refreshOrdersList();
                    });

                } else {

                    Swal.fire({
                        icon: 'warning',
                        title: 'সতর্কতা',
                        text: res.message ||
                            'কিছু ভুল হয়েছে!',
                        confirmButtonColor: '#f59e0b'
                    });

                    btn
                        .prop('disabled', false)
                        .text('✅ ডেলিভারি সম্পন্ন করুন');
                }
            },

            error: function (xhr) {

                let message =
                    'সার্ভারে সমস্যা হয়েছে, আবার চেষ্টা করুন।';

                if (
                    xhr.responseJSON &&
                    xhr.responseJSON.message
                ) {
                    message = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'ত্রুটি!',
                    text: message,
                    confirmButtonColor: '#dc2626'
                });

                btn
                    .prop('disabled', false)
                    .text('✅ ডেলিভারি সম্পন্ন করুন');
            }
        });
    });


    window.refreshOrdersList = function () {

        const currentUrl = window.location.href;

        $('#ordersList')
            .addClass('opacity-50');

        $.ajax({

            url: currentUrl,
            method: 'GET',
            cache: false,

            success: function (html) {

                const newOrdersList =
                    $(html).find('#ordersList').html();

                if (newOrdersList !== undefined) {
                    $('#ordersList').html(newOrdersList);
                }

                $('#ordersList')
                    .removeClass('opacity-50');

                $('#selectAllOrders')
                    .prop('checked', false);

                updateSelectedCount();
            },

            error: function () {

                $('#ordersList')
                    .removeClass('opacity-50');

                window.location.reload();
            }
        });
    };


    updateSelectedCount();

});

</script>

@endsection

