@extends('apps.dashboard_master')
@section('content')
<div class="flex min-h-screen bg-gray-50">
    <!-- 🟢 Sidebar -->
    <!-- @include('backend.patrials.rider_aside') -->
  
    <!-- 🟡 Main Content Area -->
    <div class="flex-1 flex flex-col p-4">
        <!-- Top Bar -->
        <!-- Top Bar -->
        <header class="bg-white shadow-md py-4 px-6 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-700">ড্যাশবোর্ড</h1>
            <div class="flex items-center gap-4">
                <span class="text-gray-600 text-sm hidden sm:block">রাইডার</span>
                <img src="{{ $rider->user->photo ? url('uploads/riders/'.$rider->user->photo??'') : 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png' }}" alt="User" class="w-10 h-10 rounded-full object-cover">
            </div>
        </header>

        
        <!-- 🎁 Offer Notice Card (Dismissible) -->
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-6">

        <!-- Rider Welcome Header -->
        <div class="bg-white shadow rounded-2xl p-6 flex flex-col md:flex-row justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-green-700">স্বাগতম, {{ $rider->name ?? 'রাইডার' }} 👋</h2>
                <p class="text-gray-600 mt-1">আপনার কার্যক্রম নিচে দেখুন</p>
            </div>

            <div class="flex items-center gap-4 mt-4 md:mt-0">
                <img src="{{ $rider->user->photo ? asset('uploads/riders/'.$rider->user->photo) : 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png' }}" 
                     class="w-16 h-16 rounded-full border-2 border-green-500 object-cover" 
                     alt="Rider Photo">

                <div>
                    <p class="text-sm text-gray-700"><strong>ফোন:</strong> {{ $rider->user->phone }}</p>
                    <p class="text-sm text-gray-700"><strong>যানবাহন:</strong> {{ $rider->vehicle_type ?? 'নির্দিষ্ট নয়' }}</p>
                    
                </div>
            </div>
        </div>

         
                <!-- Rider Stats Section -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">

                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-gray-500 text-sm mb-2">✅ সম্পন্ন ডেলিভারি</h3>
                        <p class="text-3xl font-bold text-green-600">
                            {{ $totalDelivered }}
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-gray-500 text-sm mb-2">⏱️ সময়মতো ডেলিভারি</h3>
                        <p class="text-3xl font-bold text-blue-600">
                            {{ $onTimeDelivery }}
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-gray-500 text-sm mb-2">📦 চলমান অর্ডার</h3>
                        <p class="text-3xl font-bold text-yellow-600">
                            {{ $pendingOrders }}
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-gray-500 text-sm mb-2">❌ বাতিল ডেলিভারি</h3>
                        <p class="text-3xl font-bold text-red-600">
                            {{ $cancelDelivery }}
                        </p>
                    </div>

                </div>

        <!-- Quick Actions -->
        <div class="bg-white p-6 rounded-2xl shadow mb-10">
            <h3 class="text-lg font-semibold text-green-700 mb-4">🚀 দ্রুত কার্যক্রম</h3>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('rider.orders') }}" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">📦 আমার অর্ডারসমূহ</a>
                <a href="{{ route('rider.products') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">🛒 আমার পণ্য তালিকা</a>
                <a href="{{ route('rider.earnings') }}" class="px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">💰 আয় দেখুন</a>
                <a href="{{ route('rider.support') }}" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">📞 সাপোর্টে যোগাযোগ</a>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white p-6 rounded-2xl shadow">
            <h3 class="text-lg font-semibold text-green-700 mb-4">📋 লাইভ অর্ডার বোর্ড</h3>
            <div id="orderBoard" class="grid grid-cols-1 md:grid-cols-1 gap-6"></div>
        </div>
    </div>
</div>
    </div>
</div>


<!-- ✅ Accept Modal -->
<div id="acceptModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center z-50">
    <div class="bg-white w-full max-w-2xl rounded-lg p-6 shadow-lg relative">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-600 text-xl">✖</button>
        <h3 class="text-xl font-bold mb-4">🧾 Accept Order</h3>

        <div id="modalItems" class="space-y-3"></div>

                <div class="w-full text-left mt-3">
                    <label class="block font-semibold  text-gray-700 mb-2">ডেলিভারি সময় সেট করুন(মিনিট) ঃ</label>
                    <input type="number" id="delivery_time" class="border p-1 w-full rounded mx-auto" placeholder="Exp: 30 মিনিট" required/> 
                </div>
        <div class="flex justify-between mt-6 border-t pt-4">
            <p class="font-bold text-lg">Total:</p>
            <p id="modalTotal" class="font-bold text-lg text-green-600">৳0</p>
        </div>

        <button id="confirmAccept" class="bg-green-600 text-white px-4 py-2 rounded mt-4 w-full">✅ Confirm Order</button>
    </div>
</div>






@endsection
@section('scripts')
<script>
function loadOrders() {
    $.get("{{ route('rider.orders.pending') }}", function(data){
        data.orders.forEach(order => {
            if (!$(`#orderBoard .order-item[data-id="${order.id}"]`).length) {

                // 🧮 Calculate total by unit
                    // 🧮 Calculate totals with product names (except কেজি)
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



                $('#orderBoard').append(`
                    <div class="w-full">        
                    <div class="relative bg-white p-5 mt-3 rounded-2xl shadow-md hover:shadow-lg border order-item w-full mb-1" data-id="${order.id}">
                    
                        <span class="absolute -top-3 left-5 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                            অর্ডার আইডি: # ${order.id }
                        </span>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

                                <!-- 🧍‍♂️ Customer Info -->
                                <div>
                                    <h4 class="text-lg font-semibold text-green-700 mb-1">
                                        ${order.user?.name ?? 'অজানা ক্রেতা'}
                                    </h4>
                                    <p class="text-sm text-gray-600">পিতার নামঃ ${order.user?.father_name ?? '-'}</p>
                                    <p class="text-sm text-gray-600">📞 ${order.user?.phone ?? '-'}</p>
                                </div>

                                <!-- 📦 Order Info -->
                                <div class="text-gray-700">
                                    <p><strong>পণ্যঃ</strong> ${order.items?.length ?? 0} টি</p>
                                    <p><strong>মোটঃ</strong> <span class="text-green-700 font-semibold">৳${order.total_amount}</span></p>
                                    <p><strong>ঠিকানাঃ</strong> ${order.delivery_address ?? '-'}</p>
                                </div>

                                <!-- ⏰ Time & Action -->
                                <div class="flex flex-col justify-between text-left md:text-right">
                                    <p class="text-sm text-gray-500 mb-3">
                                        <strong>অর্ডার সময়ঃ</strong> ${new Date(order.created_at).toLocaleString('bn-BD')}
                                    </p>
                                    <button class="acceptBtn bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg transition w-full md:w-auto">
                                        ✅ গ্রহণ করুন
                                    </button>
                                </div>
                                </div>
                                <p class="text-sm text-red-500 mt-3"><strong>মোট পরিমাণঃ</strong> ${totalText}</p>
                        </div>
                    </div>
                `);
            }
        });
    });
}

setInterval(loadOrders, 5000);
loadOrders();

// 🔹 Open Modal
 // 🔹 Open Accept Modal
$(document).on('click', '.acceptBtn', function() {
    const orderId = $(this).closest('.order-item').data('id');

    $.get("{{ route('rider.orders.pending') }}", function(data){
        const order = data.orders.find(o => o.id == orderId);
        if (!order) return;

        $('#modalItems').html(order.items.map(i => {
            const qty = parseFloat(i.quantity) || 0;
            const price = parseFloat(i.price) || 0;
            return `
                <div class="flex justify-between items-center border p-2 rounded modal-item" data-id="${i.id}">
                    <!-- Product Info (Left) -->
                    <div class="flex items-center gap-2 w-1/3">
                        <img src="${i.product.full_image}" class="w-12 h-12 rounded" alt="${i.product.name}" />
                        <div>
                            <p class="font-semibold">${i.product.name}</p>
                            <p>Qty: <span class="itemQty">${qty}</span> ${i.product.unit}</p>
                        </div>
                    </div>

                    <!-- Price Input (Middle) -->
                    <div class="w-1/3 text-center">
                        <input type="number" value="${price}" class="priceInput border p-1 w-20 rounded mx-auto" data-id="${i.id}" data-qty="${qty}" />
                    </div>

                    <!-- Subtotal (Right) -->
                    <div class="w-1/3 text-right">
                        <span class="itemSubtotal text-green-700 font-semibold">৳${(qty*price).toFixed(2)}</span>
                    </div>
                </div>
            `;
        }).join(''));

        updateModalTotal(); // initial total
        $('#acceptModal').data('id', orderId).removeClass('hidden');
    });
});

// 🔹 Recalculate subtotal & total when price changes
$(document).on('input', '.priceInput', function() {
    const $row = $(this).closest('.modal-item');
    const qty = parseFloat($(this).data('qty')) || 0;
    const price = parseFloat($(this).val()) || 0;

    // Update row subtotal
    $row.find('.itemSubtotal').text(`৳${(qty*price).toFixed(2)}`);

    // Update modal total
    updateModalTotal();
});

// 🔹 Function to recalc total
function updateModalTotal() {
    let total = 0;
    $('#modalItems .modal-item').each(function() {
        const subtotal = parseFloat($(this).find('.itemSubtotal').text().replace('৳','')) || 0;
        total += subtotal;
    });
    $('#modalTotal').text(`৳${total.toFixed(2)}`);
}


// 🔹 Confirm Accept
$('#confirmAccept').on('click', function() {
    const orderId = $('#acceptModal').data('id');
    const items = [];
    $('.priceInput').each(function() {
        items.push({ id: $(this).data('id'), price: $(this).val() });
    });

    const total = $('#modalTotal').text().replace('৳', '');
    const delivery_time = $('#delivery_time').val();
    $.ajax({
        url: "{{ route('rider.orders.accept') }}",
        method: 'POST',
        data: {
            id: orderId,
            items: items,
            total_amount: total,
            delivery_time: delivery_time,
            _token: "{{ csrf_token() }}"
        },
        success: function(res) {
            if (res.success) {
                showToast('success', 'Accepted', '✅ Order accepted successfully!');
                $('#acceptModal').addClass('hidden');
                $(`.order-item[data-id="${orderId}"]`).remove();
            }
        }
    });
});

function closeModal() {
    $('#acceptModal').addClass('hidden');
}
</script>
@endsection