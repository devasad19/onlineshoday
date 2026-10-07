@extends('apps.dashboard_master')

@section('content')

<div class="flex min-h-screen bg-gray-50">

    <!-- Main Content -->
    <div class="flex-1 flex flex-col p-4">

        <!-- Top Bar -->
        <header class="bg-white shadow-md py-4 px-6 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-700">ড্যাশবোর্ড</h1>

            <div class="flex items-center gap-4">
                <span class="text-gray-600 text-sm hidden sm:block">রাইডার</span>

                <img
                    src="{{ $rider->user->photo
                        ? asset('uploads/users/' . $rider->user->photo)
                        : 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png' }}"
                    alt="User"
                    class="w-10 h-10 rounded-full object-cover"
                >
            </div>
        </header>


        <div class="bg-gray-50 min-h-screen py-10">

            <div class="max-w-7xl mx-auto px-6">

                <!-- Rider Welcome Header -->
                <div class="bg-white shadow rounded-2xl p-6 flex flex-col md:flex-row justify-between items-center mb-8">

                    <div>
                        <h2 class="text-2xl font-bold text-green-700">
                            স্বাগতম, {{ $rider->user->name ?? 'রাইডার' }} 👋
                        </h2>

                        <p class="text-gray-600 mt-1">
                            আপনার কার্যক্রম নিচে দেখুন
                        </p>
                    </div>

                    <div class="flex items-center gap-4 mt-4 md:mt-0">

                        <img
                            src="{{ $rider->user->photo
                                ? asset('uploads/users/' . $rider->user->photo)
                                : 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png' }}"
                            class="w-16 h-16 rounded-full border-2 border-green-500 object-cover"
                            alt="Rider Photo"
                        >

                        <div>
                            <p class="text-sm text-gray-700">
                                <strong>ফোন:</strong>
                                {{ $rider->user->phone ?? '-' }}
                            </p>

                            <p class="text-sm text-gray-700">
                                <strong>যানবাহন:</strong>
                                {{ $rider->vehicle_type ?? 'নির্দিষ্ট নয়' }}
                            </p>
                        </div>

                    </div>
                </div>


                <!-- Rider Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">

                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-gray-500 text-sm mb-2">
                            ✅ সম্পন্ন ডেলিভারি
                        </h3>

                        <p class="text-3xl font-bold text-green-600">
                            {{ $totalDelivered }}
                        </p>
                    </div>


                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-gray-500 text-sm mb-2">
                            ⏱️ সময়মতো ডেলিভারি
                        </h3>

                        <p class="text-3xl font-bold text-blue-600">
                            {{ $onTimeDelivery }}
                        </p>
                    </div>


                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-gray-500 text-sm mb-2">
                            📦 চলমান অর্ডার
                        </h3>

                        <p class="text-3xl font-bold text-yellow-600">
                            {{ $pendingOrders }}
                        </p>
                    </div>


                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-gray-500 text-sm mb-2">
                            ❌ বাতিল ডেলিভারি
                        </h3>

                        <p class="text-3xl font-bold text-red-600">
                            {{ $cancelDelivery }}
                        </p>
                    </div>

                </div>


                <!-- Quick Actions -->
                <div class="bg-white p-6 rounded-2xl shadow mb-10">

                    <h3 class="text-lg font-semibold text-green-700 mb-4">
                        🚀 দ্রুত কার্যক্রম
                    </h3>

                    <div class="flex flex-wrap gap-4">

                        <a href="{{ route('rider.orders') }}"
                           class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            📦 আমার অর্ডারসমূহ
                        </a>

                        <a href="{{ route('rider.products') }}"
                           class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            🛒 আমার পণ্য তালিকা
                        </a>

                        <a href="{{ route('rider.earnings') }}"
                           class="px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                            💰 আয় দেখুন
                        </a>

                        <a href="{{ route('rider.support') }}"
                           class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                            📞 সাপোর্টে যোগাযোগ
                        </a>

                    </div>
                </div>


                <!-- Live Order Board -->
                <div class="bg-white p-6 rounded-2xl shadow">

                    <div class="flex justify-between items-center mb-5">

                        <h3 class="text-lg font-semibold text-green-700">
                            📋 লাইভ অর্ডার বোর্ড
                        </h3>

                        <span id="orderLoading"
                              class="text-sm text-gray-400 hidden">
                            অর্ডার লোড হচ্ছে...
                        </span>

                    </div>


                    <div id="orderBoard"
                         class="grid grid-cols-1 gap-6">
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     ACCEPT MODAL
========================================================= -->
 <div
    id="acceptModal"
    class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex justify-center items-center z-50 p-3 sm:p-5"
>
 
<div
    class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl relative max-h-[94vh] overflow-hidden flex flex-col"
>

    <!-- Header -->
    <div
        class="px-5 py-4 border-b bg-gradient-to-r from-green-50 to-white flex items-center justify-between"
    >

        <div>

            <h3 class="text-lg sm:text-xl font-bold text-gray-800">
                🧾 অর্ডার গ্রহণ
            </h3>

            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                পণ্যের মূল্য যাচাই করে অর্ডারটি গ্রহণ করুন
            </p>

        </div>


        <button
            type="button"
            onclick="closeModal()"
            class="w-9 h-9 rounded-full bg-gray-100 hover:bg-red-100 hover:text-red-600 text-gray-500 flex items-center justify-center transition"
        >
            ✕
        </button>

    </div>


    <!-- Body -->
    <div class="overflow-y-auto px-4 sm:px-5 py-5">


        <!-- Product Section -->
        <div class="border border-gray-200 rounded-xl overflow-hidden">

            <div
                class="bg-gray-50 px-4 py-3 flex items-center justify-between border-b"
            >

                <div>

                    <h4 class="font-bold text-gray-800">
                        📦 অর্ডারের পণ্য
                    </h4>

                    <p class="text-xs text-gray-500 mt-0.5">
                        প্রয়োজন হলে Rider Price পরিবর্তন করুন
                    </p>

                </div>


                <span
                    id="modalProductCount"
                    class="text-xs font-semibold bg-green-100 text-green-700 px-3 py-1 rounded-full"
                >
                    0 টি
                </span>

            </div>


            <!-- Product List -->
            <div
                id="modalItems"
                class="divide-y divide-gray-100"
            >
            </div>

        </div>


        <!-- Delivery Time -->
        <div
            class="mt-5 border border-blue-100 bg-blue-50/50 rounded-xl p-4"
        >

            <div class="flex items-center gap-2 mb-3">

                <div
                    class="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center"
                >
                    🚚
                </div>

                <div>

                    <h4 class="font-bold text-gray-800">
                        ডেলিভারি সময়
                    </h4>

                    <p class="text-xs text-gray-500">
                        আনুমানিক কত মিনিটে পৌঁছাতে পারবেন?
                    </p>

                </div>

            </div>


            <div class="relative">

                <input
                    type="text"
                    id="delivery_time"
                    inputmode="numeric"
                    min="1"
                    class="w-full border border-gray-300 bg-white rounded-xl px-4 py-3 pr-16 font-semibold text-gray-700 outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                    placeholder="যেমন: 30"
                    required
                >

                <span
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-400"
                >
                    মিনিট
                </span>

            </div>

        </div>


        <!-- Total Summary -->
        <div
            class="mt-5 rounded-xl border border-gray-200 bg-gray-50 p-4"
        >

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-sm text-gray-500">
                        অর্ডারের মোট
                    </p>

                    <p
                        id="modalTotal"
                        class="text-2xl font-extrabold text-green-600 mt-1"
                    >
                        ৳0
                    </p>

                </div>


                <div
                    class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-2xl"
                >
                    💰
                </div>

            </div>

        </div>

    </div>


    <!-- Footer -->
    <div
        class="px-4 sm:px-5 py-4 border-t bg-white"
    >

        <button
            type="button"
            id="confirmAccept"
            class="w-full bg-green-600 hover:bg-green-700 active:bg-green-800 disabled:bg-gray-300 disabled:cursor-not-allowed text-white px-4 py-3.5 rounded-xl font-bold shadow-sm transition flex items-center justify-center gap-2"
        >

            <span>
                ✅
            </span>

            <span>
                অর্ডার গ্রহণ করলাম
            </span>

        </button>

    </div>

</div>
 

</div>



@endsection


@section('scripts')

<script>

/*
|--------------------------------------------------------------------------
| Global
|--------------------------------------------------------------------------
*/

let ordersCache = [];
let loadingOrders = false;


/*
|--------------------------------------------------------------------------
| Escape HTML
|--------------------------------------------------------------------------
*/

function escapeHtml(value) {

    if (value === null || value === undefined) {
        return '';
    }

    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}


/*
|--------------------------------------------------------------------------
| Number Format
|--------------------------------------------------------------------------
*/

function numberFormat(value) {

    value = parseFloat(value) || 0;

    return value.toLocaleString('en-US', {
        maximumFractionDigits: 2
    });
}


/*
|--------------------------------------------------------------------------
| Date Format
|--------------------------------------------------------------------------
*/

function formatDate(date) {

    if (!date) {
        return '-';
    }

    const d = new Date(date);

    if (isNaN(d.getTime())) {
        return '-';
    }

    return d.toLocaleString('bn-BD');
}


/*
|--------------------------------------------------------------------------
| Check Package Order
|--------------------------------------------------------------------------
*/

function isPackageOrder(order) {

    return (
        order.type === 'package' ||
        order.package_id ||
        order.package
    );
}


/*
|--------------------------------------------------------------------------
| Product Image
|--------------------------------------------------------------------------
*/

function getProductImage(product) {

    if (!product) {
        return '';
    }

    return (
        product.image ||
        ''
    );
}


/*
|--------------------------------------------------------------------------
| Package Image
|--------------------------------------------------------------------------
*/

function getPackageImage(packageData) {

    if (!packageData) {
        return '';
    }

    return (
        packageData.image ||
        ''
    );
}


/*
|--------------------------------------------------------------------------
| Normal Order Quantity Text
|--------------------------------------------------------------------------
*/

function getNormalOrderTotalText(order) {

    let totals = {
        'কেজি': [],
        'পিস': [],
        'ডজন': [],
        'লিটার': [],
        'প্যাকেট': [],
        'টাকা': []
    };


    /*
    |--------------------------------------------------------------------------
    | Normal Products
    |--------------------------------------------------------------------------
    */

    (order.items || []).forEach(function(item) {

        const unit = (item.product?.unit || '').trim();

        const qty = parseFloat(item.quantity) || 0;

        const price = parseFloat(
            item.rider_price ?? item.price
        ) || 0;

        const name = item.product?.name || 'অজানা পণ্য';


        if (!unit) {
            return;
        }


        if (unit === 'টাকা') {

            if (!totals[unit]) {
                totals[unit] = [];
            }

            totals[unit].push(
                `${name} (${numberFormat(price)}) ${unit}`
            );

        } else {

            if (!totals[unit]) {
                totals[unit] = [];
            }

            totals[unit].push(
                `${name} (${numberFormat(qty)}) ${unit}`
            );
        }

    });


    /*
    |--------------------------------------------------------------------------
    | Custom Products
    |--------------------------------------------------------------------------
    */

    (order.custom_products || []).forEach(function(item) {

        const unit = (item.unit || '').trim();

        const qty = parseFloat(item.quantity) || 0;

        const price = parseFloat(
            item.rider_price ?? item.price
        ) || 0;

        const name = item.name || 'অতিরিক্ত পণ্য';


        if (!unit) {
            return;
        }


        if (!totals[unit]) {
            totals[unit] = [];
        }


        if (unit === 'টাকা') {

            totals[unit].push(
                `${name} (${numberFormat(price)}) ${unit}`
            );

        } else {

            totals[unit].push(
                `${name} (${numberFormat(qty)}) ${unit}`
            );

        }

    });


    let parts = [];


    [
        'কেজি',
        'পিস',
        'ডজন',
        'লিটার',
        'প্যাকেট',
        'টাকা'
    ].forEach(function(unit) {

        if (
            totals[unit] &&
            totals[unit].length
        ) {

            parts.push(
                totals[unit].join(', ')
            );

        }

    });


    return parts.join(' + ') || '-';
}


/*
|--------------------------------------------------------------------------
| Render Package Order
|--------------------------------------------------------------------------
*/

function renderPackageOrder(order) {

    const packageData = order.package || {};


  
     
    const packageItems = (
        packageData.items ||
        order.package_items ||
        []
    );

    const img_url = "{{ url('uploads/packages/') }}";
    const packageImage = img_url+'/'+getPackageImage(packageData);

    
    let itemsHtml = '';


    if (packageItems.length) {

        itemsHtml = packageItems.map(function(item) {

            const product = item.product || {};

            const name =
                product.name ||
                item.product_name ||
                'অজানা পণ্য';

            const unit =
                item.unit ||
                product.unit ||
                '';

            const quantity =
                parseFloat(item.quantity) || 0;

            const product_img_url = "{{ url('uploads/products') }}";
            const image = product_img_url+'/'+getProductImage(product);
 
            return `

                <div class="flex items-center gap-3 bg-white border rounded-xl p-3">

                    ${
                        image
                        ?
                        `
                        <img
                            src="${escapeHtml(image)}"
                            class="w-12 h-12 rounded-lg object-cover border"
                            alt="${escapeHtml(name)}"
                        >
                        `
                        :
                        `
                        <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-xl">
                            📦
                        </div>
                        `
                    }

                    <div class="flex-1">

                        <p class="font-semibold text-gray-800">
                            ${escapeHtml(name)}
                        </p>

                        <p class="text-sm text-gray-500">
                            পরিমাণ:
                            <strong>
                                ${numberFormat(quantity)}
                            </strong>
                            ${escapeHtml(unit)}
                        </p>

                    </div>

                </div>

            `;

        }).join('');

    } else {

        itemsHtml = `
            <div class="bg-white border rounded-xl p-4 text-sm text-gray-500">
                এই প্যাকেজের পণ্য তথ্য পাওয়া যায়নি।
            </div>
        `;

    }


    return `

        <div
            class="relative bg-white p-5 mt-3 rounded-2xl shadow-md hover:shadow-lg border order-item w-full mb-1"
            data-id="${order.id}"
            data-type="package"
        >

            <!-- Order ID -->

            <span class="absolute -top-3 left-5 bg-purple-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow">

                📦 প্যাকেজ অর্ডার #${order.id}

            </span>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-3">

                <!-- Customer -->

                <div>

                    <h4 class="text-lg font-semibold text-green-700 mb-1">

                        ${escapeHtml(
                            order.user?.name ||
                            order.customer?.name ||
                            'অজানা ক্রেতা'
                        )}

                    </h4>

                    <p class="text-sm text-gray-600">
                        পিতার নামঃ
                        ${escapeHtml(
                            order.user?.father_name ||
                            order.customer?.father_name ||
                            '-'
                        )}
                    </p>

                    <p class="text-sm text-gray-600">
                        📞
                        ${escapeHtml(
                            order.user?.phone ||
                            order.customer?.phone ||
                            '-'
                        )}
                    </p>

                </div>


                <!-- Package Info -->

                <div class="text-gray-700">

                    <p>
                        <strong>প্যাকেজঃ</strong>

                        <span class="text-purple-700 font-semibold">
                            ${escapeHtml(
                                packageData.name ||
                                'প্যাকেজ'
                            )}
                        </span>
                    </p>

                    <p>
                        <strong>মোটঃ</strong>

                        <span class="text-green-700 font-semibold">
                            ৳${numberFormat(order.total_amount)}
                        </span>
                    </p>

                    <p>
                        <strong>ঠিকানাঃ</strong>
                        ${escapeHtml(
                            order.delivery_address || '-'
                        )}
                    </p>

                </div>


                <!-- Time + Action -->

                <div class="flex flex-col justify-between text-left md:text-right">

                    <p class="text-sm text-gray-500 mb-3">

                        <strong>অর্ডার সময়ঃ</strong>

                        ${formatDate(order.created_at)}

                    </p>


                    <button
                        type="button"
                        class="acceptBtn bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg transition w-full md:w-auto"
                        data-id="${order.id}"
                        data-type="package"
                    >

                        ✅ গ্রহণ করুন

                    </button>

                </div>

            </div>


            <!-- PACKAGE DETAILS -->

            <div class="mt-5 rounded-2xl border border-purple-200 bg-purple-50 p-4">

                <div class="flex flex-col md:flex-row gap-4">

                    ${
                        packageImage
                        ?
                        `
                        <div class="shrink-0">

                            <img
                                src="${escapeHtml(packageImage)}"
                                class="w-28 h-28 rounded-xl object-cover border-2 border-white shadow"
                                alt="Package"
                            >

                        </div>
                        `
                        :
                        ''
                    }


                    <div class="flex-1">

                        <div class="flex items-center gap-2 mb-2">

                            <span class="bg-purple-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                                🎁 প্যাকেজ বিস্তারিত
                            </span>

                        </div>


                        <h4 class="text-lg font-bold text-purple-800">

                            ${escapeHtml(
                                packageData.name ||
                                'প্যাকেজ'
                            )}

                        </h4>


                        ${
                            packageData.description
                            ?
                            `
                            <p class="text-sm text-gray-600 mt-1">
                                ${escapeHtml(
                                    packageData.description
                                )}
                            </p>
                            `
                            :
                            ''
                        }

                    </div>

                </div>


                <!-- Package Items -->

                <div class="mt-4">

                    <p class="font-semibold text-gray-700 mb-3">
                        📦 প্যাকেজে যা আছে:
                    </p>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                        ${itemsHtml}

                    </div>

                </div>

            </div>


        </div>

    `;
}

function hasPendingCustomProduct(order) {

    return (order.custom_products || []).some(item => {

        const unit =
            (item.unit || '').trim();

        // unit = টাকা হলে Price অবশ্যই 0-এর বেশি হতে হবে
      

            const price =
                parseFloat(item.price) || 0;

            return price <= 0;
        

        
    });
}
/*
|--------------------------------------------------------------------------
| Render Normal Order
|--------------------------------------------------------------------------
*/

function renderNormalOrder(order) {


const hasPendingCustomPrice =
    hasPendingCustomProduct(order);

const hasDeliveryCharge =
    order.delivery_charge !== null &&
    order.delivery_charge !== undefined &&
    order.delivery_charge !== '';

const readyToDelivery =
    !hasPendingCustomPrice &&
    hasDeliveryCharge;

const acceptButton = readyToDelivery
    ? `
        <button
            type="button"
            class="acceptBtn bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg transition w-full md:w-auto"
            data-id="${order.id}"
            data-type="normal"
        >
            ✅ গ্রহণ করুন
        </button>
    `
    : `
        <button
            type="button"
            class="acceptBtn bg-gray-400 text-white font-semibold px-6 py-2 rounded-lg cursor-not-allowed opacity-70 w-full md:w-auto"
            data-id="${order.id}"
            data-type="normal"
            disabled
        >
            🔒 Ready to Delivery হয়নি
        </button>
    `;
 





    const totalText =
        getNormalOrderTotalText(order);


    return `

        <div
            class="relative bg-white p-5 mt-3 rounded-2xl shadow-md hover:shadow-lg border order-item w-full mb-1"
            data-id="${order.id}"
            data-type="normal"
        >

            <span class="absolute -top-3 left-5 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow">

                অর্ডার আইডি: #${order.id}

            </span>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start mt-3">


                <!-- Customer Info -->

                <div>

                    <h4 class="text-lg font-semibold text-green-700 mb-1">

                        ${escapeHtml(
                            order.user?.name ||
                            'অজানা ক্রেতা'
                        )}

                    </h4>

                    <p class="text-sm text-gray-600">

                        পিতার নামঃ
                        ${escapeHtml(
                            order.user?.father_name || '-'
                        )}

                    </p>

                    <p class="text-sm text-gray-600">

                        📞
                        ${escapeHtml(
                            order.user?.phone || '-'
                        )}

                    </p>

                </div>


                <!-- Order Info -->

                <div class="text-gray-700">

                    <p>
                        <strong>পণ্যঃ</strong>
                        ${(order.items || []).length} টি
                    </p>

                    <p>
                        <strong>মোটঃ</strong>

                        <span class="text-green-700 font-semibold">
                            ৳${numberFormat(order.total_amount)}
                        </span>
                    </p>

                    <p>
                        <strong>ঠিকানাঃ</strong>

                        ${escapeHtml(
                            order.delivery_address || '-'
                        )}

                    </p>

                </div>


                <!-- Time + Action -->

                <div class="flex flex-col justify-between text-left md:text-right">

                    <p class="text-sm text-gray-500 mb-3">

                        <strong>অর্ডার সময়ঃ</strong>

                        ${formatDate(order.created_at)}

                    </p>


${acceptButton}

                </div>

            </div>


            <!-- Quantity Summary -->

            <p class="text-sm text-red-500 mt-3">

                <strong>মোট পরিমাণঃ</strong>

                ${escapeHtml(totalText)}

            </p>

        </div>

    `;
}


/*
|--------------------------------------------------------------------------
| Render Order
|--------------------------------------------------------------------------
*/

function renderOrder(order) {

    if (isPackageOrder(order)) {

        return renderPackageOrder(order);

    }

    return renderNormalOrder(order);
}


/*
|--------------------------------------------------------------------------
| Load Orders
|--------------------------------------------------------------------------
*/

function loadOrders() {

    if (loadingOrders) {
        return;
    }

    loadingOrders = true;

    $('#orderLoading').removeClass('hidden');


    $.get("{{ route('rider.orders.pending') }}")

        .done(function(data) {

            const orders = Array.isArray(data.orders)
                ? data.orders
                : [];


            ordersCache = orders;


            const board = $('#orderBoard');


            orders.forEach(function(order) {

                const selector =
                    `.order-item[data-id="${order.id}"]`;


                if (!board.find(selector).length) {

                    board.prepend(
                        renderOrder(order)
                    );

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | Existing order update
                    |--------------------------------------------------------------------------
                    */

                    board.find(selector).replaceWith(
                        renderOrder(order)
                    );

                }

            });


            /*
            |--------------------------------------------------------------------------
            | Remove orders which are no longer pending
            |--------------------------------------------------------------------------
            */

            board.find('.order-item').each(function() {

                const id = $(this).data('id');

                const exists = orders.some(function(order) {

                    return String(order.id) === String(id);

                });


                if (!exists) {

                    $(this).remove();

                }

            });


            /*
            |--------------------------------------------------------------------------
            | Empty
            |--------------------------------------------------------------------------
            */

            if (!orders.length) {

                if (!board.find('.empty-orders').length) {

                    board.html(`

                        <div class="empty-orders text-center py-10 text-gray-500">

                            📭 বর্তমানে কোনো pending order নেই।

                        </div>

                    `);

                }

            } else {

                board.find('.empty-orders').remove();

            }

        })

        .fail(function(xhr) {

            console.error(
                'Pending orders load failed:',
                xhr.responseText
            );

        })

        .always(function() {

            loadingOrders = false;

            $('#orderLoading').addClass('hidden');

        });

}


/*
|--------------------------------------------------------------------------
| Initial Load
|--------------------------------------------------------------------------
*/

loadOrders();


/*
|--------------------------------------------------------------------------
| Refresh Every 5 Seconds
|--------------------------------------------------------------------------
*/

setInterval(loadOrders, 5000);


/*
|--------------------------------------------------------------------------
| Open Accept Modal
|--------------------------------------------------------------------------
*/

$(document).on('click', '.acceptBtn', function() {

    const orderId =
        $(this).data('id');

    const orderType =
        $(this).data('type');


    const order =
        ordersCache.find(function(item) {

            return String(item.id) === String(orderId);

        });


    if (!order) {

        alert('অর্ডারের তথ্য পাওয়া যায়নি।');

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Package Order
    |--------------------------------------------------------------------------
    */

    if (orderType === 'package' || isPackageOrder(order)) {

        openPackageAcceptModal(order);

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Normal Order
    |--------------------------------------------------------------------------
    */

    openNormalAcceptModal(order);

});


/*
|--------------------------------------------------------------------------
| Normal Order Modal
|--------------------------------------------------------------------------
*/

 function openNormalAcceptModal(order) {

const items =
    Array.isArray(order.items)
        ? order.items
        : [];

const customProducts =
    Array.isArray(order.custom_products)
        ? order.custom_products
        : [];


if (!items.length && !customProducts.length) {

    alert('এই অর্ডারে কোনো পণ্য পাওয়া যায়নি।');

    return;
}


let html = '';

let productCount = 0;


// ==========================================
// Normal Products
// ==========================================

items.forEach(function(item) {

    productCount++;


    const qty =
        parseFloat(item.quantity) || 0;


    const price =
        parseFloat(
            item.rider_price ?? item.price
        ) || 0;


    const product =
        item.product || {};


    const productName =
        product.name ||
        'অজানা পণ্য';


    const unit =
        product.unit ||
        '';

            const product_img_url = "{{ url('uploads/products') }}";
            const image = product_img_url+'/'+getProductImage(product);

  

    html += `

        <div
            class="modal-item bg-white border border-gray-200 rounded-xl p-3 sm:p-4"
            data-id="${item.id}"
            data-custom="0"
        >

            <div class="flex items-center gap-3">

                ${
                    image
                    ?
                    `
                    <img
                        src="${escapeHtml(image)}"
                        class="w-14 h-14 rounded-xl object-cover border"
                        alt="${escapeHtml(productName)}"
                    >
                    `
                    :
                    `
                    <div
                        class="w-14 h-14 rounded-xl bg-gray-100 flex items-center justify-center text-xl shrink-0"
                    >
                        📦
                    </div>
                    `
                }


                <div class="flex-1 min-w-0">

                    <p class="font-bold text-gray-800">
                        ${escapeHtml(productName)}
                    </p>

                    <p class="text-sm text-gray-500 mt-1">

                        পরিমাণ:
                        <strong class="text-gray-700">
                            ${numberFormat(qty)}
                        </strong>

                        ${escapeHtml(unit)}

                    </p>

                </div>


                <div class="w-28 sm:w-32">

                  
                    <label class="block text-xs text-gray-500 mb-1">
                        ${item.product.unit}
                    </label>
                    <div class="relative">

                        <span
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-semibold"
                        >
                            ৳
                        </span>

                        <input
                            type="text"
                            inputmode="decimal"
                            value="${price}"
                            class="priceInput w-full border border-gray-300 rounded-lg pl-7 pr-2 py-2 text-right font-semibold focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            data-id="${item.id}"
                            data-qty="${qty}" readonly
                        >

                    </div>

                </div>


                <div class="w-24 sm:w-28 text-right">

                    <p class="text-xs text-gray-500 mb-1">
                        মোট
                    </p>

                    <span
                        class="itemSubtotal text-green-700 font-bold"
                    >
                        ৳${numberFormat(qty * price)}
                    </span>

                </div>

            </div>

        </div>

    `;
});


// ==========================================
// Custom Products
// ==========================================

customProducts.forEach(function(item) {

    productCount++;


    const qty =
        parseFloat(item.quantity) || 0;


    const price =
        parseFloat(
            item.rider_price ?? item.price
        ) || 0;


    const name =
        item.name ||
        'অতিরিক্ত পণ্য';


    const unit =
        (item.unit || '').trim();


    const isMoney =
        unit === 'টাকা';


    const displayQuantity =
        qty > 0
        ? `${numberFormat(qty)} ${escapeHtml(unit)}`
        : escapeHtml(unit);


    html += `

        <div
            class="modal-item bg-orange-50 border border-orange-200 rounded-xl p-3 sm:p-4"
            data-id="${item.id}"
            data-custom="1"
        >

            <div class="flex items-center gap-3">

                <div
                    class="w-14 h-14 rounded-xl bg-orange-100 flex items-center justify-center text-xl shrink-0"
                >
                    🧩
                </div>


                <div class="flex-1 min-w-0">

                    <div class="flex items-center gap-2 flex-wrap">

                        <p class="font-bold text-gray-800">
                            ${escapeHtml(name)}
                        </p>

                        <span
                            class="text-xs font-bold bg-orange-200 text-orange-700 px-2 py-0.5 rounded-full"
                        >
                            Custom
                        </span>

                    </div>


                    <p class="text-sm text-gray-500 mt-1">

                        ${
                            isMoney
                            ?
                            `
                            <span class="text-orange-700 font-semibold">
                                ${escapeHtml(unit)}
                            </span>
                            `
                            :
                            `
                            পরিমাণ:
                            <strong class="text-gray-700">
                                ${displayQuantity}
                            </strong>
                            `
                        }

                    </p>

                </div>


                <div class="w-28 sm:w-32">

                    <label class="block text-xs text-gray-500 mb-1">
                        ${item.unit}
                    </label>

                    <div class="relative">

                        <span
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-semibold"
                        >
                            ৳
                        </span>

                        <input
                            type="text"
                            inputmode="decimal"
                            value="${price}"
                            class="priceInput customPriceInput w-full border border-orange-300 rounded-lg pl-7 pr-2 py-2 text-right font-semibold bg-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400"
                            data-id="${item.id}"
                            data-qty="${qty}"
                            data-money="${isMoney ? '1' : '0'}" readonly
                        >

                    </div>

                </div>


                <div class="w-24 sm:w-28 text-right">

                    <p class="text-xs text-gray-500 mb-1">
                        মোট
                    </p>

                    <span
                        class="itemSubtotal text-green-700 font-bold"
                    >
                        ৳${
                            isMoney
                            ? numberFormat(price)
                            : numberFormat(qty * price)
                        }
                    </span>

                </div>

            </div>

        </div>

    `;
});


$('#modalItems').html(html);


$('#modalProductCount').text(
    `${productCount} টি`
);


updateModalTotal();


$('#acceptModal')
    .data('id', order.id)
    .data('type', 'normal')
    .removeClass('hidden');


$('#delivery_time')
    .val('');


}

/*
|--------------------------------------------------------------------------
| Package Accept Modal
|--------------------------------------------------------------------------
*/

function openPackageAcceptModal(order) {

    const packageData =
        order.package || {};

    const packageItems =
        packageData.items ||
        order.package_items ||
        [];


    let html = `

        <div class="bg-purple-50 border border-purple-200 rounded-xl p-4">

            <div class="flex items-center gap-3 mb-4">

                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-2xl">
                    🎁
                </div>

                <div>

                    <h4 class="font-bold text-purple-800">
                        ${escapeHtml(
                            packageData.name ||
                            'প্যাকেজ অর্ডার'
                        )}
                    </h4>

                    <p class="text-sm text-gray-500">
                        Package Order #${order.id}
                    </p>

                </div>

            </div>


            <div class="space-y-2">

    `;


    if (packageItems.length) {

        packageItems.forEach(function(item) {

            const product =
                item.product || {};

            const name =
                product.name ||
                item.product_name ||
                'অজানা পণ্য';

            const unit =
                item.unit ||
                product.unit ||
                '';

            const qty =
                parseFloat(item.quantity) || 0;


            html += `

                <div class="bg-white border rounded-lg px-3 py-2 flex justify-between">

                    <span class="font-medium">
                        ${escapeHtml(name)}
                    </span>

                    <span class="text-gray-600">
                        ${numberFormat(qty)}
                        ${escapeHtml(unit)}
                    </span>

                </div>

            `;

        });

    } else {

        html += `

            <div class="bg-white border rounded-lg p-3 text-sm text-gray-500">

                প্যাকেজের item পাওয়া যায়নি।

            </div>

        `;

    }


    html += `

            </div>

        </div>

    `;


    $('#modalItems').html(html);


    $('#modalTotal').text(
        `৳${numberFormat(order.total_amount)}`
    );


    $('#acceptModal')
        .data('id', order.id)
        .data('type', 'package')
        .removeClass('hidden');


    $('#delivery_time')
        .val('');

}


/*
|--------------------------------------------------------------------------
| Update Normal Modal Total
|--------------------------------------------------------------------------
*/

function updateModalTotal() {

 
let total = 0;


$('#modalItems .modal-item').each(function() {

    const qty =
        parseFloat(
            $(this)
                .find('.priceInput')
                .data('qty')
        ) || 0;


    const price =
        parseFloat(
            $(this)
                .find('.priceInput')
                .val()
        ) || 0;


    const isMoney =
        $(this)
            .find('.priceInput')
            .data('money') === 1 ||
        String(
            $(this)
                .find('.priceInput')
                .data('money')
        ) === '1';


    if (isMoney) {

        total += price;

    } else {

        total += qty * price;

    }

});


$('#modalTotal').text(
    `৳${numberFormat(total)}`
);
 

}

/*
|--------------------------------------------------------------------------
| Price Input
|--------------------------------------------------------------------------
*/

$(document).on('input', '.priceInput', function() {
 
const row =
    $(this).closest('.modal-item');


const qty =
    parseFloat(
        $(this).data('qty')
    ) || 0;


const price =
    parseFloat(
        $(this).val()
    ) || 0;


const isMoney =
    String(
        $(this).data('money')
    ) === '1';


const subtotal =
    isMoney
    ? price
    : qty * price;


row.find('.itemSubtotal').text(
    `৳${numberFormat(subtotal)}`
);


updateModalTotal();
 

});

/*
|--------------------------------------------------------------------------
| Confirm Accept
|--------------------------------------------------------------------------
*/

$('#confirmAccept').on('click', function() {

    const button = $(this);


    const orderId =
        $('#acceptModal').data('id');


    const orderType =
        $('#acceptModal').data('type');


    const deliveryTime =
        parseInt(
            $('#delivery_time').val()
        ) || 0;


    if (deliveryTime <= 0) {

        alert('দয়া করে delivery time দিন।');

        return;

    }


    button
        .prop('disabled', true)
        .text('⏳ গ্রহণ করা হচ্ছে...');


    let ajaxData = {

        id: orderId,

        order_type: orderType,

        delivery_time: deliveryTime,

        _token: "{{ csrf_token() }}"

    };


    /*
    |--------------------------------------------------------------------------
    | Normal Order Items
    |--------------------------------------------------------------------------
    */

    if (orderType === 'normal') {

        const items = [];


        $('#modalItems .priceInput').each(function() {

            items.push({

                id: $(this).data('id'),

                price: $(this).val()

            });

        });


        ajaxData.items = items;


        ajaxData.total_amount =
            $('#modalTotal')
                .text()
                .replace('৳', '')
                .trim();

    }


    /*
    |--------------------------------------------------------------------------
    | Send Request
    |--------------------------------------------------------------------------
    */

    $.ajax({

        url: "{{ route('rider.orders.accept') }}",

        method: 'POST',

        data: ajaxData,

        success: function(res) {

            if (res.success) {

                closeModal();


                $(
                    `.order-item[data-id="${orderId}"]`
                ).remove();


                /*
                |--------------------------------------------------------------------------
                | Remove Cache
                |--------------------------------------------------------------------------
                */

                ordersCache =
                    ordersCache.filter(function(order) {

                        return String(order.id) !==
                            String(orderId);

                    });


                if (
                    typeof showToast === 'function'
                ) {

                    showToast(
                        'success',
                        'Accepted',
                        '✅ অর্ডার সফলভাবে গ্রহণ করা হয়েছে!'
                    );

                } else {

                    alert(
                        '✅ অর্ডার সফলভাবে গ্রহণ করা হয়েছে!'
                    );

                }

            } else {

                alert(
                    res.message ||
                    'অর্ডার গ্রহণ করা যায়নি।'
                );

            }

        },

        error: function(xhr) {

            console.error(
                'Accept Error:',
                xhr.responseText
            );


            let message =
                'অর্ডার গ্রহণ করা যায়নি।';


            if (
                xhr.responseJSON &&
                xhr.responseJSON.message
            ) {

                message =
                    xhr.responseJSON.message;

            }


            alert(message);

        },

        complete: function() {

            button
                .prop('disabled', false)
                .text('✅ অর্ডার গ্রহণ করলাম');

        }

    });

});


/*
|--------------------------------------------------------------------------
| Close Modal
|--------------------------------------------------------------------------
*/

function closeModal() {

    $('#acceptModal')
        .addClass('hidden')
        .removeData('id')
        .removeData('type');


    $('#modalItems').html('');

    $('#delivery_time').val('');

    $('#modalTotal').text('৳0');

}
 

 

  
 
</script>

@endsection
