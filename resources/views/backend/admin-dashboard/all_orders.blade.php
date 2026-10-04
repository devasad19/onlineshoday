@extends('apps.dashboard_master')

@section('content')
<div class="flex min-h-screen bg-gray-50">
 
    <!-- Main Area -->
    <div class="flex-1 flex flex-col">

        @include('backend.patrials.top_bar')

        <!-- Content -->
        <section class="bg-white p-2 md:p-6 rounded-2xl shadow mx-2 my-2 md:mx-6 md:my-6">
<div class="flex items-center justify-between mb-6">

    <h2 class="text-2xl font-bold text-green-700">
        📦 সব অর্ডার (লাইভ)
    </h2>

    <button
        type="button"
        id="bulkPrintBtn"
        disabled
        class="bg-red-500 hover:bg-red-600 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold px-4 py-2 rounded-lg shadow transition">
        🖨 Print All
        <span id="selectedCount" class="ml-1">(0)</span>
    </button>

</div>

            <!-- Filter -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">

    <div class="flex items-center gap-2">

        <label class="font-semibold">তারিখ:</label>

        <select id="dateFilter" class="border rounded-lg px-3 py-2">

            <option value="today">Today</option>

            <option value="yesterday">Yesterday</option>

            <option value="range">Date Range</option>
            <option value="all">All Orders</option>

        </select>

        <input type="date" id="fromDate"
               class="border rounded-lg px-3 py-2 hidden">

        <span id="rangeText" class="hidden">-</span>

        <input type="date" id="toDate"
               class="border rounded-lg px-3 py-2 hidden">

    </div>
<div class="flex items-center gap-2">

    <label class="font-semibold">Search:</label>

    <input
        type="text"
        id="searchText"
        placeholder="Customer Name, Phone / Rider Name"
        class="border rounded-lg px-3 py-2 w-64">

</div>
    <div>

        <label class="font-semibold">Sort:</label>

        <select id="sortBy"
                class="border rounded-lg px-3 py-2">

            <option value="">All</option>
            <option value="pending">Pending</option>
            <option value="accepted">Accepted</option>
            <option value="delivered">Delivered</option>
            <option value="cancel">Cancelled</option>

        </select>

    </div>

</div>
 
            <!-- Orders Table -->
        <!-- Recent Orders -->
            
            <div id="orderBoard" class="grid grid-cols-1 md:grid-cols-1 gap-4"></div>
           
        </section>

 

    </div>
</div>

 <div
    id="deliveryChargeModal"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4"
>

    <div
        class="bg-white w-full max-w-2xl rounded-2xl shadow-xl"
    >

        <!-- Header -->
        <div
            class="flex justify-between items-center px-5 py-4 border-b"
        >

            <h3 class="text-lg font-bold text-gray-800">
                🚚 Delivery Charge সেট করুন
            </h3>

            <button
                type="button"
                onclick="closeDeliveryChargeModal()"
                class="text-gray-500 hover:text-red-500 text-2xl"
            >
                &times;
            </button>

        </div>


        <!-- Body -->
        <div class="p-5">


            <!-- Product List -->
            <div
                class="border rounded-xl overflow-hidden mb-4"
            >

                <div
                    class="bg-gray-100 px-4 py-3 font-bold text-gray-700"
                >
                    📦 অর্ডারের পণ্য
                </div>

                <div
                    id="deliveryProductList"
                    class="divide-y"
                >
                </div>

            </div>


            <!-- KG / LITER -->
            <div
                class="border rounded-xl p-4 mb-3 bg-green-50"
            >

                <div
                    class="flex justify-between items-center"
                >

                    <div>

                        <p class="font-bold text-gray-700">
                            ⚖️ KG / Liter
                        </p>

                        <p
                            id="deliveryKgLiterQuantity"
                            class="text-sm text-gray-500 mt-1"
                        >
                            মোট: 0 kg / liter
                        </p>

                    </div>


                    <div class="text-right">

                        <p class="text-xs text-gray-500">
                            Auto Charge
                        </p>

                        <p
                            id="deliveryKgLiterCharge"
                            class="text-xl font-bold text-green-700"
                        >
                            ৳0.00
                        </p>

                    </div>

                </div>

            </div>


            <!-- OTHER -->
            <div
                class="border rounded-xl p-4 mb-4 bg-gray-50"
            >

                <div
                    class="flex justify-between items-center gap-4"
                >

                    <div>

                        <p class="font-bold text-gray-700">
                            📦 অন্যান্য পণ্য
                        </p>

                        <p
                            id="deliveryOtherQuantity"
                            class="text-sm text-gray-500 mt-1"
                        >
                            পিস: 0 | ডজন: 0 | প্যাকেট: 0
                        </p>

                    </div>


                    <div class="w-40">

                        <input
                            type="number"
                            id="deliveryOtherCharge"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-right font-bold focus:ring-2 focus:ring-orange-500"
                            placeholder="৳ চার্জ"
                        >

                    </div>

                </div>

            </div>


            <!-- TOTAL -->
            <div class="border-t pt-4">

                <div
                    class="flex justify-between items-center"
                >

                    <span class="font-bold text-gray-700">
                        মোট Delivery Charge
                    </span>

                    <span
                        id="deliveryTotalCharge"
                        class="text-2xl font-bold text-green-700"
                    >
                        ৳0.00
                    </span>

                </div>

            </div>

        </div>


        <!-- Footer -->
        <div
            class="px-5 py-4 border-t flex justify-end gap-3"
        >

            <button
                type="button"
                onclick="closeDeliveryChargeModal()"
                class="px-5 py-2 rounded-lg border hover:bg-gray-100"
            >
                Cancel
            </button>


            <button
                type="button"
                onclick="saveDeliveryCharge()"
                class="px-5 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-bold"
            >
                ✓ Save & Confirm
            </button>

        </div>

    </div>

</div>

<script id="delivery-charge-rules-data" type="application/json">
{!! json_encode($deliveryChargeRules ?? []) !!}
</script>

@endsection

@section('scripts')
<script>
 
const deliveryChargeRulesElement =
    document.getElementById('delivery-charge-rules-data');

let deliveryChargeRules = [];

if (deliveryChargeRulesElement) {

    try {

        deliveryChargeRules =
            JSON.parse(
                deliveryChargeRulesElement.textContent || '[]'
            );

    } catch (error) {

        console.error(
            'Delivery Charge Rules JSON Error:',
            error
        );

        deliveryChargeRules = [];
    }
}

console.log(
    'ALL DELIVERY RULES:',
    deliveryChargeRules
);

console.log('Delivery Charge Rules:', deliveryChargeRules);

// Selected order IDs
let selectedOrders = new Set();


function updatePrintButton() {

    const count = selectedOrders.size;

    $("#selectedCount").text(`(${count})`);

    $("#bulkPrintBtn").prop("disabled", count === 0);
}


function loadOrders(){

    $.ajax({
        url:"{{ route('admin.orders.live') }}",
        type:"GET",
        data:{
            date_filter:$("#dateFilter").val(),
            from_date:$("#fromDate").val(),
            to_date:$("#toDate").val(),
            status:$("#sortBy").val(),
            search:$("#searchText").val()
        },

        success:function(data){

            $("#orderBoard").empty();

            // বর্তমানে পাওয়া order ID
            const currentOrderIds = new Set(
                data.orders.map(order => String(order.id))
            );

            // যেসব selected order বর্তমানে list-এ নেই সেগুলো remove
            selectedOrders.forEach(id => {

                if (!currentOrderIds.has(String(id))) {
                    selectedOrders.delete(id);
                }

            });


            data.orders.forEach(order => {

                $("#orderBoard").append(
                    renderOrderCard(order)
                );

            });


            // Re-check selected orders after AJAX refresh
            $(".order-checkbox").each(function(){

                const id = String($(this).data("id"));

                if(selectedOrders.has(id)) {
                    $(this).prop("checked", true);
                }

            });


            updatePrintButton();

        }

    });

}

// ==========================================
// Order Checkbox Selection
// ==========================================

$(document).on("change", ".order-checkbox", function(){

    const id = String($(this).data("id"));

    if($(this).is(":checked")){

        selectedOrders.add(id);

    }else{

        selectedOrders.delete(id);

    }

    updatePrintButton();

});


loadOrders();


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




setInterval(loadOrders,5000);

$("#dateFilter,#sortBy,#fromDate,#toDate").on("change",function(){

    loadOrders();

});

let searchTimer;

$("#searchText").on("keyup", function(){

    clearTimeout(searchTimer);

    searchTimer = setTimeout(function(){

        loadOrders();

    },300);

});


$("#dateFilter").change(function(){

    if($(this).val()=="range"){

        $("#fromDate,#toDate,#rangeText")
            .removeClass("hidden");

    }else{

        $("#fromDate,#toDate,#rangeText")
            .addClass("hidden");

    }

});
 

 
function renderOrderCard(order) {

    // ======================================================
    // Live Order Store
    // ======================================================
    window.liveOrders = window.liveOrders || {};
    window.liveOrders[order.id] = order;


    // ======================================================
    // মোট পরিমাণ হিসাব
    // ======================================================
    let totals = {
        'কেজি': [],
        'পিস': [],
        'ডজন': [],
        'লিটার': [],
        'প্যাকেট': [],
        'টাকা': [],
    };


    // ======================================================
    // Custom Product Price Status
    // ======================================================
    const customProducts = order.custom_products || [];

    const hasCustomProducts = customProducts.length > 0;

    const hasPendingCustomPrice = customProducts.some(item => {
        return parseFloat(item.price) <= 0;
    });


    // ======================================================
    // Delivery Charge Status
    //
    // IMPORTANT:
    // null / undefined = Delivery Charge এখনো সেট হয়নি
    // 0 = Delivery Charge সেট হয়েছে (Free Delivery হলেও confirmed)
    // ======================================================
    const hasDeliveryCharge =
        order.delivery_charge !== null &&
        order.delivery_charge !== undefined;


    // ======================================================
    // PRICE / DELIVERY STATUS BUTTON
    // ======================================================
    let priceStatusHTML = '';

    if (hasPendingCustomPrice) {

        // 1️⃣ Custom Product Price Pending
        priceStatusHTML = `
            <button
                type="button"
                onclick="openCustomPriceModal(${order.id})"
                class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow cursor-pointer"
            >
                ⚠ Price Pending
            </button>
        `;

    } else if (!hasDeliveryCharge) {

        // 2️⃣ Custom Price Done কিন্তু Delivery Charge সেট হয়নি
        priceStatusHTML = `
            <button
                type="button"
                onclick="openDeliveryChargeModal(${order.id})"
                class="bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow cursor-pointer"
            >
                🚚 Set Delivery Charge
            </button>
        `;

    } else {

        // 3️⃣ সব Complete
        priceStatusHTML = `
            <span
                class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full"
            >
                ✓ Price Confirmed
            </span>
        `;
    }


    // ======================================================
    // PRINT BUTTON
    // শুধু Custom Price + Delivery Charge দুইটাই Complete হলে
    // ======================================================
    const canPrint =
        !hasPendingCustomPrice &&
        hasDeliveryCharge;


    const printButton = canPrint
        ? `
            <a
                href="{{ url('/admin/orders') }}/${order.id}/print"
                target="_blank"
                class="absolute -top-3 right-5 bg-red-500 hover:bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow z-10"
            >
                🖨 Invoice Print
            </a>
        `
        : '';


    // ======================================================
    // NORMAL PRODUCTS
    // ======================================================
    (order.items || []).forEach(i => {

        const unit = (i.product?.unit || '').trim();
        const qty = parseFloat(i.quantity) || 0;
        const price = parseFloat(i.price) || 0;
        const name = i.product?.name ?? 'অজানা পণ্য';

        if (!unit) return;


        if (unit === 'টাকা') {

            totals[unit].push(
                `${name} (${price}) ${unit}`
            );

        } else if (totals.hasOwnProperty(unit)) {

            totals[unit].push(
                `${name} (${qty}) ${unit}`
            );

        } else {

            totals[unit] = [
                `${name} (${qty}) ${unit}`
            ];
        }
    });


    // ======================================================
    // CUSTOM PRODUCTS
    // ======================================================
    (order.custom_products || []).forEach(i => {

        const unit = (i.unit || '').trim();
        const qty = parseFloat(i.quantity) || 0;
        const price = parseFloat(i.price) || 0;
        const name = i.name ?? 'আরো';

        if (!unit) return;


        if (unit === 'টাকা') {

            if (price > 0) {

                totals[unit].push(
                    `${name} (${price}) ${unit}`
                );

            } else {

                totals[unit].push(
                    `${name} (Price Pending)`
                );
            }

        } else if (totals.hasOwnProperty(unit)) {

            totals[unit].push(
                `${name} (${qty}) ${unit}`
            );

        } else {

            totals[unit] = [
                `${name} (${qty}) ${unit}`
            ];
        }
    });


    // ======================================================
    // সবগুলো সুন্দরভাবে Join
    // ======================================================
    let totalTextParts = [];

    [
        'কেজি',
        'পিস',
        'ডজন',
        'লিটার',
        'প্যাকেট',
        'টাকা'
    ].forEach(unit => {

        if (
            totals[unit] &&
            totals[unit].length > 0
        ) {
            totalTextParts.push(
                totals[unit].join(', ')
            );
        }
    });


    let totalText =
        totalTextParts.join(' + ') || '-';


    // ======================================================
    // ORDER STATUS BUTTON
    // ======================================================
    let buttonHTML = '';

    if (order.status === 'delivered') {

        buttonHTML = `
            <button
                class="bg-gray-600 text-white font-semibold px-6 py-2 rounded-lg w-full md:w-auto"
                disabled
            >
                ✅ ডেলিভারি সম্পন্ন হয়েছে
            </button>
        `;

    } else if (order.status === 'accepted') {

        buttonHTML = `
            <button
                class="deliverBtn bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg transition w-full md:w-auto"
                data-id="${order.id}"
            >
                🚚 অর্ডার গৃহীত হয়েছে
            </button>
        `;

    } else {

        buttonHTML = `
            <button
                class="deliverBtn bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg transition w-full md:w-auto"
                data-id="${order.id}"
            >
                🚚 অর্ডার পেন্ডিং
            </button>
        `;
    }


    // ======================================================
    // DELIVERY INFO
    // ======================================================
    let deliveryInfo = '';

    if (
        order.status === 'delivered' ||
        order.status === 'accepted'
    ) {

        const riderName =
            order.rider?.name ?? '';

        let statusText = '';

        if (
            order.delivered_status === 'on_time'
        ) {

            statusText = `
                <span class="text-green-600 font-semibold">
                    সময়ে ডেলিভারি
                </span>
            `;

        } else if (
            order.delivered_status === 'late'
        ) {

            statusText = `
                <span class="text-red-600 font-semibold">
                    বিলম্বে ডেলিভারি
                </span>
            `;
        }


        deliveryInfo = `
            <div
                class="mt-3 text-sm bg-indigo-100 text-gray-600 border-t p-2 md:p-6 rounded-md flex items-center justify-between"
            >

                <p>
                    🚴 <strong>রাইডারঃ</strong>
                    ${riderName}
                </p>

                <p>
                    🕓 <strong>এস্টিমেট ডেলিভারি সময়ঃ</strong>
                    ${
                        order.delivery_time
                            ? order.delivery_time + ' মিনিট'
                            : ''
                    }
                </p>

                <p>
                    🕓 <strong>ডেলিভারি সময়ঃ</strong>
                    ${
                        order.delivered_at
                            ? new Date(
                                order.delivered_at
                              ).toLocaleString('bn-BD')
                            : ''
                    }
                </p>

                <p>
                    ${statusText}
                </p>

            </div>
        `;
    }


    // ======================================================
    // FINAL CARD
    // ======================================================
    return `
        <div
            class="relative bg-white p-5 pt-8 pl-14 mt-3 rounded-2xl shadow-md hover:shadow-lg border order-item w-full mb-1"
            data-id="${order.id}"
        >

            <!-- Checkbox -->
            <div
                class="absolute top-5 left-4 z-20 flex items-center justify-center"
            >

                <input
                    type="checkbox"
                    class="order-checkbox !w-5 !h-5 text-green-600 border-gray-400 rounded cursor-pointer"
                    data-id="${order.id}"
                    ${
                        selectedOrders.has(String(order.id))
                            ? 'checked'
                            : ''
                    }
                >

            </div>


            <!-- Order ID -->
            <span
                class="absolute -top-3 left-12 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow z-10"
            >
                অর্ডার আইডি: #${order.id}
            </span>


            <!-- Print -->
            ${printButton}


            <div
                class="grid grid-cols-1 md:grid-cols-3 gap-6"
            >

                <!-- CUSTOMER -->
                <div>

                    <h4
                        class="text-lg font-semibold text-green-700"
                    >
                        ${order.user?.name ?? 'অজানা ক্রেতা'}
                    </h4>

                    <p class="text-sm text-gray-600">
                        পিতার নামঃ
                        ${order.user?.father_name ?? '-'}
                    </p>

                    <p>
                        📞 ${order.user?.phone ?? '-'}
                    </p>

                </div>


                <!-- ORDER INFO -->
                <div>

                    <p>
                        <strong>পণ্যঃ</strong>
                        ${order.items?.length ?? 0} টি
                    </p>


                    <!-- TOTAL + STATUS -->
                    <p class="flex items-center gap-2 flex-wrap">

                        <strong>মোটঃ</strong>

                        <span
                            class="text-lg font-bold text-gray-800"
                        >
                            ৳${parseFloat(
                                order.total_amount || 0
                            ).toFixed(2)}
                        </span>

                        ${priceStatusHTML}

                    </p>


                    <p>
                        <strong>ঠিকানাঃ</strong>
                        ${order.delivery_address ?? '-'}
                    </p>

                </div>


                <!-- ORDER TIME -->
                <div class="text-right">

                    <p>
                        <strong>অর্ডার সময়ঃ</strong>
                        ${
                            new Date(
                                order.created_at
                            ).toLocaleString('bn-BD')
                        }
                    </p>

                    ${buttonHTML}

                </div>

            </div>


            <!-- TOTAL QUANTITY -->
            <p class="text-sm text-red-500 my-3">

                <strong>মোট পরিমাণঃ</strong>

                ${totalText}

            </p>


            ${deliveryInfo}

        </div>
    `;
}



// ======================================================
// Custom Product Price Modal
// ======================================================

window.liveOrders = window.liveOrders || {};
// window.currentCustomNormalTotal = normalTotal;
function openCustomPriceModal(orderId) {

    const order = window.liveOrders[orderId];

    if (!order) {
        alert('অর্ডারের তথ্য পাওয়া যায়নি।');
        return;
    }

const normalTotal = (order.items || []).reduce((sum, item) => {

    const qty = parseFloat(item.quantity) || 0;

    let price = parseFloat(item.rider_price) || 0;

    if (price <= 0) {
        price = parseFloat(item.price) || 0;
    }

    return sum + (qty * price);

}, 0);


 

    const customProducts = order.custom_products || [];

    if (customProducts.length === 0) {
        alert('এই অর্ডারে কোনো custom product নেই।');
        return;
    }


    let rows = '';

    customProducts.forEach((item, index) => {

        const qty = parseFloat(item.quantity) || 0;
        const price = parseFloat(item.price) || 0;

        rows += `
            <div class="border rounded-xl p-4 mb-3 bg-gray-50">

                <div class="flex justify-between items-start gap-4">

                    <div class="flex-1">

                        <p class="font-bold text-gray-800">
                            ${index + 1}. ${item.name ?? 'Custom Product'}
                        </p>

                        <p class="text-sm text-gray-600 mt-1">
                            পরিমাণ:
                            <strong>${qty}</strong>
                            ${item.unit ?? ''}
                        </p>

                    </div>


                    <div class="w-40">

                        <label class="block text-xs font-semibold text-gray-600 mb-1">
                            প্রতি ইউনিট মূল্য
                        </label>

                        <input
                            type="number"
                            min="0"
                            step="0.01"
                            class="custom-price-input w-full border border-gray-300 rounded-lg px-3 py-2 text-right font-bold focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            data-id="${item.id}"
                            data-qty="${qty}"
                            value="${price > 0 ? price : ''}"
                            placeholder="৳ Price"
                        >

                    </div>
                </div>
            </div>
        `;
    });


    const modal = `
        <div
            id="customPriceModal"
            class="fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center p-4"
        >

            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">

                <!-- Header -->
                <div class="sticky top-0 bg-white border-b px-6 py-4 flex items-center justify-between z-10">

                    <div>
                        <h2 class="text-xl font-bold text-gray-800">
                            🧾 অর্ডার #${order.id}
                        </h2>

                        <p class="text-sm text-gray-500">
                            Custom Product-এর মূল্য নির্ধারণ করুন
                        </p>
                    </div>

                    <button
                        type="button"
                        onclick="closeCustomPriceModal()"
                        class="text-gray-500 hover:text-red-600 text-2xl font-bold"
                    >
                        ×
                    </button>

                </div>


                <!-- Customer -->
                <div class="px-6 pt-4">

                    <div class="bg-indigo-50 rounded-xl p-4">

                        <p>
                            <strong>ক্রেতাঃ</strong>
                            ${order.user?.name ?? '-'}
                        </p>

                        <p>
                            <strong>ফোনঃ</strong>
                            ${order.user?.phone ?? '-'}
                        </p>

                        <p>
                            <strong>ঠিকানাঃ</strong>
                            ${order.delivery_address ?? '-'}
                        </p>

                    </div>

                </div>


                <!-- Products -->
                <div class="p-6">

         
                    <h3 class="font-bold text-gray-700 mb-3">
                        Custom Products
                    </h3>

                    ${rows}


                    <!-- Grand Total -->
                    <div class="border-t pt-4 mt-4">

                        <div class="flex justify-between items-center">

                            <span class="text-lg font-bold">
                                নতুন মোট:
                            </span>

                            <span
                                id="customGrandTotal"
                                class="text-2xl font-bold text-green-700"
                            >
                                ৳${parseFloat(order.total_amount || 0).toFixed(2)}
                            </span>

                        </div>

                    </div>

                </div>


                <!-- Footer -->
                <div class="sticky bottom-0 bg-white border-t px-6 py-4 flex justify-end gap-3">

                    <button
                        type="button"
                        onclick="closeCustomPriceModal()"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-5 py-2 rounded-lg"
                    >
                        বাতিল
                    </button>


                    <button
                        type="button"
                        onclick="saveCustomPrices(${order.id})"
                        id="saveCustomPricesBtn"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-2 rounded-lg shadow"
                    >
                        💾 Save & Confirm
                    </button>

                </div>

            </div>

        </div>
    `;


    // পুরোনো modal থাকলে remove
    $('#customPriceModal').remove();

    $('body').append(modal);

    updateCustomModalTotal();
}
function closeCustomPriceModal() {

    $('#customPriceModal').remove();

}
 
$(document).on('input', '.custom-price-input', function () {

    const input = $(this);

    const id = input.data('id');
    const qty = parseFloat(input.data('qty')) || 0;
    const price = parseFloat(input.val()) || 0;

    const lineTotal = qty * price;

    $(`.custom-line-total[data-id="${id}"]`)
        .text('৳' + lineTotal.toFixed(2));

    updateCustomModalTotal();
});

function updateCustomModalTotal() {

    let customTotal = 0;

    $('.custom-price-input').each(function () {

        const qty = parseFloat($(this).data('qty')) || 0;
        const price = parseFloat($(this).val()) || 0;

        customTotal += qty * price;
    });


    const normalTotal =
        parseFloat(window.currentCustomNormalTotal || 0);


    const grandTotal = normalTotal + customTotal;


    $('#customGrandTotal').text(
        '৳' + grandTotal.toFixed(2)
    );
}

function saveCustomPrices(orderId) {

    const products = [];

    let hasEmptyPrice = false;


    $('.custom-price-input').each(function () {

        const id = $(this).data('id');
        const price = parseFloat($(this).val());

        if (isNaN(price) || price < 0) {
            hasEmptyPrice = true;
            return false;
        }

        products.push({
            id: id,
            price: price
        });

    });


    if (hasEmptyPrice) {

        alert('সব custom product-এর মূল্য সঠিকভাবে দিন।');

        return;
    }


    const btn = $('#saveCustomPricesBtn');

    btn.prop('disabled', true)
       .text('Saving...');


    $.ajax({

        url: "{{ url('/admin/orders') }}/" + orderId + "/custom-price-update",

        type: "POST",

        data: {
            _token: "{{ csrf_token() }}",
            custom_products: products
        },

        success: function(response) {

            if (response.success) {

                closeCustomPriceModal();

                /*
                |--------------------------------------------------------------------------
                | Live order list reload
                |--------------------------------------------------------------------------
                */

                loadOrders();

                alert('✅ Custom product-এর price সফলভাবে confirm হয়েছে।');

            } else {

                alert(response.message || 'Price update করা যায়নি।');

            }

        },

        error: function(xhr) {

            console.error(xhr.responseText);

            let message = 'Price update করার সময় সমস্যা হয়েছে।';

            if (xhr.responseJSON?.message) {
                message = xhr.responseJSON.message;
            }

            alert(message);

        },

        complete: function() {

            btn.prop('disabled', false)
               .text('💾 Save & Confirm');

        }

    });
}


function getDeliveryQuantities(order) {

    const totals = {
        kg_liter: 0,
        piece: 0,
        dozen: 0,
        packet: 0
    };

    const products = [];


    // ==========================================
    // Normal Products
    // ==========================================

    (order.items || []).forEach(item => {

        const name =
            item.product?.name ?? 'অজানা পণ্য';

        const unit =
            (item.product?.unit || '').trim();

        const qty =
            parseFloat(item.quantity) || 0;


        products.push({
            name: name,
            unit: unit,
            quantity: qty,
            custom: false
        });


        if (
            unit === 'কেজি' ||
            unit === 'লিটার'
        ) {

            totals.kg_liter += qty;

        } else if (unit === 'পিস') {

            totals.piece += qty;

        } else if (unit === 'ডজন') {

            totals.dozen += qty;

        } else if (unit === 'প্যাকেট') {

            totals.packet += qty;
        }

    });


    // ==========================================
    // Custom Products
    // ==========================================

    (order.custom_products || []).forEach(item => {

        const name =
            item.name ?? 'Custom Product';

        const unit =
            (item.unit || '').trim();

        const qty =
            parseFloat(item.quantity) || 0;


        products.push({
            name: name,
            unit: unit,
            quantity: qty,
            custom: true
        });


        // KG / Liter
        if (
            unit === 'কেজি' ||
            unit === 'লিটার'
        ) {

            totals.kg_liter += qty;

        }

        // Piece
        else if (unit === 'পিস') {

            totals.piece += qty;

        }

        // Dozen
        else if (unit === 'ডজন') {

            totals.dozen += qty;

        }

        // Packet
        else if (unit === 'প্যাকেট') {

            totals.packet += qty;
        }

    });


    return {
        totals: totals,
        products: products
    };
}

function closeDeliveryChargeModal() {

    const modal =
        document.getElementById('deliveryChargeModal');

    if (!modal) {
        return;
    }

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    modal.dataset.orderId = '';
}
function openDeliveryChargeModal(orderId) {

    const order =
        window.liveOrders[orderId];


    if (!order) {

        alert('অর্ডারের তথ্য পাওয়া যায়নি।');

        return;
    }


    // ==========================================
    // আগে Custom Product Price Complete কিনা
    // ==========================================

    const hasPendingCustomPrice =
        (order.custom_products || []).some(item => {

            return parseFloat(item.price) <= 0;
        });


    if (hasPendingCustomPrice) {

        alert(
            'আগে Custom Product-এর Price সেট করুন।'
        );

        return;
    }


    // ==========================================
    // Quantity Calculate
    // ==========================================

    const data =
        getDeliveryQuantities(order);

    const totals =
        data.totals;

    const products =
        data.products;


    // ==========================================
    // Product List
    // ==========================================

    let html = '';


    products.forEach(product => {

        html += `
            <div
                class="px-4 py-3 flex justify-between items-center"
            >

                <div>

                    <p class="font-semibold text-gray-700">
                        ${product.name}

                        ${
                            product.custom
                            ? `
                                <span class="text-xs text-orange-600">
                                    (Custom)
                                </span>
                            `
                            : ''
                        }

                    </p>

                </div>


                <div class="font-bold text-gray-700">

                    ${product.quantity}
                    ${product.unit}

                </div>

            </div>
        `;
    });


    document.getElementById(
        'deliveryProductList'
    ).innerHTML =

        html ||

        `
            <div class="p-4 text-gray-500">
                কোনো পণ্য পাওয়া যায়নি।
            </div>
        `;


    // ==========================================
    // KG / Liter Auto Charge
    // ==========================================

    const kgLiterCharge =
        getKgLiterDeliveryCharge(
            totals.kg_liter
        );


    console.log(
        'Total KG/Liter:',
        totals.kg_liter
    );

    console.log(
        'Auto KG/Liter Charge:',
        kgLiterCharge
    );


    document.getElementById(
        'deliveryKgLiterQuantity'
    ).innerText =
        `মোট: ${totals.kg_liter} kg / liter`;


    document.getElementById(
        'deliveryKgLiterCharge'
    ).innerText =
        `৳${kgLiterCharge.toFixed(2)}`;


    // ==========================================
    // Other
    // ==========================================

    document.getElementById(
        'deliveryOtherQuantity'
    ).innerText =

        `পিস: ${totals.piece} | ` +
        `ডজন: ${totals.dozen} | ` +
        `প্যাকেট: ${totals.packet}`;


    // ==========================================
    // Input Event
    // ==========================================

    document.getElementById(
        'deliveryOtherCharge'
    ).oninput = function () {

        calculateDeliveryTotal();

    };


    // ==========================================
    // Calculate Total
    // ==========================================

    calculateDeliveryTotal();


    // ==========================================
    // Store Order ID
    // ==========================================

    const modal =
        document.getElementById(
            'deliveryChargeModal'
        );


    modal.dataset.orderId =
        orderId;


    // ==========================================
    // Show Modal
    // ==========================================

    modal.classList.remove('hidden');

    modal.classList.add('flex');
}
 
function getKgLiterDeliveryCharge(quantity) {
 

    quantity = parseFloat(quantity) || 0;

    if (quantity <= 0) {
        return 0;
    }

    if (!Array.isArray(deliveryChargeRules)) {
        console.warn('Delivery Charge Rules পাওয়া যায়নি');
        return 0;
    }

    const rules = deliveryChargeRules
        .filter(rule => {

            const unitType =
                String(rule.unit_type || '').trim().toLowerCase();

            const status =
                rule.status === true ||
                rule.status === 1 ||
                rule.status === '1';

            return (
                unitType === 'kg_liter' &&
                status
            );
        })
        .sort((a, b) => {
            return (
                parseFloat(a.min_quantity || 0) -
                parseFloat(b.min_quantity || 0)
            );
        });
        
const rule = rules.find(rule => {

    const min = parseFloat(rule.min_quantity) || 0;
    const max = parseFloat(rule.max_quantity) || 0;

    console.log('Checking Rule:', min, '-', max);
    console.log('Quantity:', quantity);

    return quantity >= min && quantity <= max;
});


    console.log('KG/Liter Quantity:', quantity);
    console.log('Matching Rule:', rule);


    if (!rule) {
        console.warn(
            'এই quantity-এর জন্য কোনো Delivery Charge Rule পাওয়া যায়নি:',
            quantity
        );

        return 0;
    }


    return parseFloat(rule.charge) || 0;
}


function calculateDeliveryTotal() {

    const kgLiterChargeElement =
        document.getElementById('deliveryKgLiterCharge');

    const otherChargeElement =
        document.getElementById('deliveryOtherCharge');

    const totalElement =
        document.getElementById('deliveryTotalCharge');


    const kgLiterCharge =
        parseFloat(
            (kgLiterChargeElement?.innerText || '0')
                .replace('৳', '')
                .trim()
        ) || 0;


    const otherCharge =
        parseFloat(
            otherChargeElement?.value || 0
        ) || 0;


    const total =
        kgLiterCharge + otherCharge;


    if (totalElement) {

        totalElement.innerText =
            `৳${total.toFixed(2)}`;
    }
}

function saveDeliveryCharge() {

    const modal =
        document.getElementById('deliveryChargeModal');

    const orderId =
        modal.dataset.orderId;


    const order =
        window.liveOrders[orderId];


    if (!order) {
        alert('অর্ডার পাওয়া যায়নি।');
        return;
    }


    const data =
        getDeliveryQuantities(order);


    const kgLiterCharge =
        getKgLiterDeliveryCharge(
            data.totals.kg_liter
        );


    const otherCharge =
        parseFloat(
            document.getElementById('deliveryOtherCharge').value
        ) || 0;


    const totalCharge =
        kgLiterCharge + otherCharge;


    fetch(
        "{{ route('admin.orders.setDeliveryCharge') }}",
        {

            method: 'POST',

            headers: {

                'Content-Type': 'application/json',

                'Accept': 'application/json',

                'X-CSRF-TOKEN':
                    document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content

            },

            body: JSON.stringify({

                order_id: orderId,

                delivery_charge: totalCharge

            })

        }
    )
    .then(response => response.json())

    .then(result => {

        if (!result.success) {

            alert(result.message || 'সমস্যা হয়েছে।');

            return;
        }


        // Local data update
        window.liveOrders[orderId].delivery_charge =
            result.delivery_charge;


        closeDeliveryChargeModal();


        // Order card update
        refreshOrderCard(orderId);


    })
    .catch(error => {

        console.error(error);

        alert('Delivery Charge save করা যায়নি।');

    });

}

</script>
@endsection