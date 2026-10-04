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


            <!-- Orders -->
            <div  id="ordersList" class="overflow-x-auto">

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

                            if (!empty($order->custom_products)) {

                                foreach ($order->custom_products as $cp) {

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
                                order-item border border-gray-100 w-full">


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
                                                <strong>
                                                    অর্ডারের ধরনঃ
                                                </strong>

                                                <span
                                                    class="text-purple-700
                                                    font-semibold">

                                                    📦 প্যাকেজ

                                                </span>
                                            </p>

                                            <p>

                                                <strong>
                                                    মোটঃ
                                                </strong>

                                                <span
                                                    class="text-green-700
                                                    font-semibold">

                                                    ৳ {{ $order->total_amount }}

                                                </span>

                                            </p>

                                        @else

                                            <p>
                                                <strong>
                                                    পণ্যঃ
                                                </strong>

                                                {{ count($order->items ?? []) }}
                                                টি
                                            </p>

                                            <p>

                                                <strong>
                                                    মোটঃ
                                                </strong>

                                                <span
                                                    class="text-green-700
                                                    font-semibold">

                                                    ৳ {{ $order->total_amount }}

                                                </span>

                                            </p>

                                        @endif


                                        <p>

                                            <strong>
                                                ঠিকানাঃ
                                            </strong>

                                            {{ $order->delivery_address ?? '-' }}

                                        </p>

                                    </div>


                                    <!-- Time & Action -->
                                    <div
                                        class="flex flex-col justify-between
                                        text-left md:text-right">


                                        <p
                                            class="text-sm text-gray-500 mb-3">

                                            <strong>
                                                অর্ডার সময়ঃ
                                            </strong>

                                            {{ $order->created_at }}

                                            <br>

                                            @if($order->status == 'delivered')

                                                <strong class="text-red-600">

                                                    ডেলিভারি হয়েছেঃ

                                                </strong>

                                                {{ $order->delivered_at }}

                                            @endif

                                        </p>


                                        @if ($order->status == 'accepted')

                                            <button
                                                type="button"
                                                class="deliverBtn
                                                bg-green-600 hover:bg-green-700
                                                text-white font-semibold
                                                px-6 py-2 rounded-lg transition
                                                w-full md:w-auto"
                                                data-id="{{ $order->id }}">

                                                ✅ ডেলিভারি সম্পন্ন করুন

                                            </button>


                                            @if(!empty($order->delivery_time))

                                                <p class="text-xs p-3">

                                                    এস্টিমেট ডেলিভারি সময়ঃ
                                                    {{ $order->delivery_time }}
                                                    মিনিট

                                                </p>

                                            @endif


                                        @elseif($order->status == 'rider_modified_accepted')

                                            <button
                                                type="button"
                                                class="bg-yellow-600
                                                hover:bg-yellow-700
                                                text-white font-semibold
                                                px-6 py-2 rounded-lg transition
                                                w-full md:w-auto">

                                                ✅ মুল্য বর্ধিত পাঠানো হয়েছে

                                            </button>


                                        @elseif($order->status == 'delivered')

                                            <button
                                                type="button"
                                                class="bg-gray-600
                                                hover:bg-gray-700
                                                text-white font-semibold
                                                px-6 py-2 rounded-lg transition
                                                w-full md:w-auto">

                                                ✅ ডেলিভারি সম্পন্ন হয়েছে

                                            </button>

                                        @endif

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

<script>
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

                    /*
                    |--------------------------------------------------------------------------
                    | পুরো page reload হবে না
                    | শুধু order list আবার render হবে
                    |--------------------------------------------------------------------------
                    */

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


/*
|--------------------------------------------------------------------------
| Refresh Only Order List
|--------------------------------------------------------------------------
*/

function refreshOrdersList() {

    const currentUrl = window.location.href;


    $('#ordersList').addClass('opacity-50');


    $.ajax({

        url: currentUrl,

        method: 'GET',

        cache: false,


        success: function (html) {

            /*
            |--------------------------------------------------------------------------
            | নতুন page থেকে শুধু #ordersList বের করা
            |--------------------------------------------------------------------------
            */

            const newOrdersList =
                $(html).find('#ordersList').html();


            if (newOrdersList !== undefined) {

                $('#ordersList').html(newOrdersList);

            }


            $('#ordersList').removeClass('opacity-50');

        },


        error: function () {

            $('#ordersList').removeClass('opacity-50');


            /*
            |--------------------------------------------------------------------------
            | যদি partial render fail করে,
            | তখন fallback হিসেবে পুরো page reload
            |--------------------------------------------------------------------------
            */

            window.location.reload();

        }

    });

}

</script>

@endsection
 