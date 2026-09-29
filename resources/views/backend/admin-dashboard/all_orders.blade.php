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
@endsection

@section('scripts')
<script>
 


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
    // ✅ মোট পরিমাণ হিসাব (আগের মতো)
let totals = {
    'কেজি': [],
    'পিস': [],
    'ডজন': [],
    'লিটার': [],
    'প্যাকেট': [],
    'টাকা': [],
};

// 🔹 Normal products
(order.items || []).forEach(i => {
    const unit = (i.product?.unit || '').trim();
    const qty = parseFloat(i.quantity) || 0;
    const price = parseFloat(i.price) || 0;
    const name = i.product?.name ?? 'অজানা পণ্য';

    if (!unit) return;

    if (unit === 'টাকা') {
        totals[unit].push(`${name} (${price}) ${unit}`);
    } else if (totals.hasOwnProperty(unit)) {
        totals[unit].push(`${name} (${qty}) ${unit}`);
    } else {
        totals[unit] = [`${name} (${qty}) ${unit}`];
    }
});

// 🔹 Custom products
(order.custom_products || []).forEach(i => {
    const unit = (i.unit || '').trim();
    const qty = parseFloat(i.quantity) || 0;
    const price = parseFloat(i.price) || 0;
    const name = i.name ?? 'আরো';

    if (!unit) return;

    if (unit === 'টাকা') {
        totals[unit].push(`${name} (${price}) ${unit}`);
    } else if (totals.hasOwnProperty(unit)) {
        totals[unit].push(`${name} (${qty}) ${unit}`);
    } else {
        totals[unit] = [`${name} (${qty}) ${unit}`];
    }
});

// 🔹 Join সবগুলো সুন্দরভাবে
let totalTextParts = [];

['কেজি', 'পিস', 'ডজন', 'লিটার', 'প্যাকেট', 'টাকা'].forEach(unit => {
    if (totals[unit] && totals[unit].length > 0) {
        totalTextParts.push(totals[unit].join(', '));
    }
});

let totalText = totalTextParts.join(' + ') || '-';


    // ✅ Status অনুযায়ী বাটন
    let buttonHTML = '';
    if (order.status === 'delivered') {
        buttonHTML = `
            <button class="bg-gray-600 text-white font-semibold px-6 py-2 rounded-lg w-full md:w-auto" disabled>
                ✅ ডেলিভারি সম্পন্ন হয়েছে
            </button>
        `;
    } else if (order.status === 'accepted') { 
        buttonHTML = `
            <button class="deliverBtn bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg transition w-full md:w-auto" data-id="${order.id}">
                🚚 অর্ডার গৃহীত হয়েছে
            </button>
        `;
    } else {
        buttonHTML = `
            <button class="deliverBtn bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg transition w-full md:w-auto" data-id="${order.id}">
                🚚 অর্ডার পেন্ডিং
            </button>
        `;
    }
 
    
    // ✅ Delivery Info
    let deliveryInfo = '';
    if (order.status === 'delivered' || order.status === 'accepted') {
        const riderName = order.rider?.name ?? '';

        let statusText = '';
        if(order.delivered_status === 'on_time'){
            statusText = `<span class='text-green-600 font-semibold'>সময়ে ডেলিভারি</span>`;
        }else if(order.delivered_status === 'late'){
             statusText = `<span class='text-red-600 font-semibold'>বিলম্বে ডেলিভারি</span>`;
        }

        deliveryInfo = `
            <div class="mt-3 text-sm bg-indigo-100 text-gray-600 border-t p-2 md:p-6 rounded-md flex items-center justify-between">
                <p>🚴 <strong>রাইডারঃ</strong> ${riderName}</p>
                <p>🕓 <strong>এস্টিমেট ডেলিভারি সময়ঃ</strong> ${order.delivery_time? order.delivery_time +'মিনিট': ''} </p>
                <p>🕓 <strong>ডেলিভারি সময়ঃ</strong> ${order.delivered_at?new Date(order.delivered_at).toLocaleString('bn-BD'): ''}</p>
                <p>${statusText}</p>
            </div>
        `;
    }

    return `
    <div
        class="relative bg-white p-5 pt-8 pl-14 mt-3 rounded-2xl shadow-md hover:shadow-lg border order-item w-full mb-1"
        data-id="${order.id}"
    >

        <!-- Checkbox -->
        <div class="absolute top-5 left-4 z-20 flex items-center justify-center">
            <input
                type="checkbox"
                class="order-checkbox !w-5 !h-5 text-green-600 border-gray-400 rounded cursor-pointer"
                data-id="${order.id}"
                ${selectedOrders.has(String(order.id)) ? 'checked' : ''}
            >
        </div>


        <!-- Order ID badge -->
        <span class="absolute -top-3 left-12 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow z-10">
            অর্ডার আইডি: #${order.id}
        </span>


        <!-- Single Print -->
        <a
            href="{{ url('/admin/orders') }}/${order.id}/print"
            target="_blank"
            class="absolute -top-3 right-5 bg-red-500 hover:bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow z-10"
        >
            🖨 Invoice Print
        </a>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div>

                <h4 class="text-lg font-semibold text-green-700">
                    ${order.user?.name ?? 'অজানা ক্রেতা'}
                </h4>

                <p class="text-sm text-gray-600">
                    পিতার নামঃ ${order.user?.father_name ?? '-'}
                </p>

                <p>
                    📞 ${order.user?.phone ?? '-'}
                </p>

            </div>


            <div>

                <p>
                    <strong>পণ্যঃ</strong>
                    ${order.items?.length ?? 0} টি
                </p>

                <p>
                    <strong>মোটঃ</strong>
                    ৳${order.total_amount}
                </p>

                <p>
                    <strong>ঠিকানাঃ</strong>
                    ${order.delivery_address ?? '-'}
                </p>

            </div>


            <div class="text-right">

                <p>
                    <strong>অর্ডার সময়ঃ</strong>
                    ${new Date(order.created_at).toLocaleString('bn-BD')}
                </p>

                ${buttonHTML}

            </div>

        </div>


        <p class="text-sm text-red-500 my-3">
            <strong>মোট পরিমাণঃ</strong>
            ${totalText}
        </p>

        ${deliveryInfo}

    </div>
`;
}




 
</script>
@endsection