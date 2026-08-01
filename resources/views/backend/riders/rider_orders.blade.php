@extends('apps.dashboard_master')

@section('content')
<div class="flex min-h-screen bg-gray-50">

    <!-- Sidebar -->
 

    <!-- Main Area -->
    <div class="flex-1 flex flex-col">

        @include('backend.patrials.top_bar')

        <!-- Content -->
        <section class="bg-white p-6 rounded-2xl shadow mx-6 my-6">
            <h2 class="text-2xl font-bold text-green-700 mb-6">📦 লাইভ অর্ডার বোর্ড</h2>

            <!-- Filter -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
                <div>
                    <label for="dateFilter" class="text-gray-600 font-semibold mr-2">Filter by:</label>
                    <select id="dateFilter" class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="last7">Last 7 Days</option>
                        <option value="last15">Last 15 Days</option>
                        <option value="1month">1 Month</option>
                    </select>
                </div>

                <div>
                    <label for="sortBy" class="text-gray-600 font-semibold mr-2">Sort by:</label>
                    <select id="sortBy" class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                        <option value="total_delivered_desc">Total Delivered (High → Low)</option>
                        <option value="total_delivered_asc">Total Delivered (Low → High)</option>
                        <option value="pending_orders_desc">Pending Orders (High → Low)</option>
                        <option value="pending_orders_asc">Pending Orders (Low → High)</option>
                    </select>
                </div>
            </div>
 
            <!-- Orders Table -->
            <div class="overflow-x-auto">
                

@if($orders->count() > 0)
    @foreach ($orders as $order)
        @php
            // 🧮 Calculate total by unit
           $totals = [
    'কেজি' => [],
    'পিস' => [],
    'ডজন' => [],
    'লিটার' => [],
    'প্যাকেট' => [],
    'টাকা' => []
];

// 👉 1. Normal products
foreach ($order->items as $i) {
    $name = $i->product->name ?? 'অজানা পণ্য';
    $unit = trim($i->product->unit ?? '');
    $qty = floatval($i->quantity ?? 0);

    if ($unit && array_key_exists($unit, $totals)) {
        // ✅ প্রতিটি পণ্যের সাথেই unit যোগ করছি
        $totals[$unit][] = "{$name} ({$qty} {$unit})";
    }
}

// 👉 2. Custom products (from JSON field)
if (!empty($order->custom_products)) {
    foreach ($order->custom_products as $cp) {
        $name = $cp['name'] ?? 'অজানা পণ্য';
        $qty = floatval($cp['quantity'] ?? 0);
        $price = floatval($cp['price'] ?? 0);
        $unit = trim($cp['unit'] ?? '');

        if ($unit === 'টাকা') {
            $totals['টাকা'][] = "{$name} ({$price} টাকা)";
        } elseif ($unit && array_key_exists($unit, $totals)) {
            $totals[$unit][] = "{$name} ({$qty} {$unit})";
        } else {
            // unit না থাকলে default টাকা ধরা
            $totals['টাকা'][] = "{$name} ({$price} টাকা)";
        }
    }
}

// 👉 3. Final formatted text
$totalTextParts = [];

foreach (['কেজি','পিস','ডজন','লিটার','প্যাকেট','টাকা'] as $unit) {
    if (count($totals[$unit]) > 0) {
        // ✅ এখন আলাদা আলাদা পণ্য, শেষে আর আলাদা unit লাগবে না
        $totalTextParts[] = implode(', ', $totals[$unit]);
    }
}

$totalText = implode(', ', $totalTextParts) ?: '-';
 
        @endphp

        <div class="w-full mb-4">
            <div class="relative bg-white p-5 mt-2 rounded-2xl shadow-md hover:shadow-lg transition order-item border border-gray-100 w-full">
    {{-- 🔹 Order ID badge (top-left) --}}
    <span class="absolute -top-3 left-5 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
        অর্ডার আইডি: #{{ $order->id }}
    </span>


                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

                    <!-- 🧍‍♂️ Customer Info -->
                    <div>
                        <h4 class="text-lg font-semibold text-green-700 mb-1">
                            {{ $order->user->name ?? 'অজানা ক্রেতা' }}
                        </h4>
                        <p class="text-sm text-gray-600">পিতার নামঃ {{ $order->user->father_name ?? '-' }}</p>
                        <p class="text-sm text-gray-600">📞 {{ $order->user->phone ?? '-' }}</p>
                    </div>

                    <!-- 📦 Order Info -->
                    <div class="text-gray-700">
                        <p><strong>পণ্যঃ</strong> {{ count($order->items) }} টি</p>
                        <p><strong>মোটঃ</strong> <span class="text-green-700 font-semibold">৳ {{ $order->total_amount }}</span></p>
                        <p><strong>ঠিকানাঃ</strong> {{ $order->delivery_address ?? '-' }}</p>
                    </div>

                    <!-- ⏰ Time & Action -->
                    <div class="flex flex-col justify-between text-left md:text-right">
                        <p class="text-sm text-gray-500 mb-3">
                            <strong>অর্ডার সময়ঃ</strong> {{ $order->created_at }} <br>
                            @if ($order->status == 'delivered')
                            <strong class="text-red-600">ডেলিভারি হয়েছেঃ</strong> {{ $order->delivered_at }}
                            @endif
                        </p>
                        {{-- Optional: Accept Button for future --}}
                        @if ($order->status == 'accepted')
                            <button  class="deliverBtn bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg transition w-full md:w-auto"
                                data-id="{{ $order->id }}">
                                ✅ ডেলিভারি সম্পন্ন করুন
                            </button>
                            <p class="text-xs p-3 ">এস্টিমেট ডেলিভারি সময়ঃ {{$order->delivery_time}} মিনিট</p>
                        @elseif($order->status == 'rider_modified_accepted')
                            <button  class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold px-6 py-2 rounded-lg transition w-full md:w-auto">
                                ✅ মুল্য বর্ধিত পাঠানো হয়েছে
                            </button>
                        @elseif($order->status == 'delivered')
                            <button  class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-6 py-2 rounded-lg transition w-full md:w-auto">
                                ✅ ডেলিভারি সম্পন্ন হয়েছে
                            </button>
                        @endif
                    </div>
                </div>

                <!-- 🧮 Total Qty -->
                <p class="text-sm text-red-500 mt-3"><strong>মোট পরিমাণঃ</strong> {{ $totalText }}</p>
            </div>
        </div>
    @endforeach
@else
    <p class="text-gray-600">📭 কোনো অর্ডার পাওয়া যায়নি।</p>
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

    btn.prop('disabled', true).text('⏳ প্রসেস হচ্ছে...');

    $.ajax({
        url: "{{ route('rider.orders.deliver', ':id') }}".replace(':id', orderId),
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function (res) {
            if (res.success) {
                // Success Notification
                Swal.fire({
                    icon: 'success',
                    title: 'সফল!',
                    text: res.message,
                    confirmButtonColor: '#16a34a',
                });

                // Button Update
                btn
                    .removeClass('bg-green-600 hover:bg-green-700')
                    .addClass('bg-gray-400 cursor-not-allowed')
                    .text('✅ ডেলিভারি সম্পন্ন হয়েছে')
                    .prop('disabled', true);
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'সতর্কতা',
                    text: res.message || 'কিছু ভুল হয়েছে!',
                    confirmButtonColor: '#f59e0b',
                });
                btn.prop('disabled', false).text('✅ ডেলিভারি সম্পন্ন');
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'ত্রুটি!',
                text: 'সার্ভারে সমস্যা হয়েছে, আবার চেষ্টা করুন।',
                confirmButtonColor: '#dc2626',
            });
            btn.prop('disabled', false).text('✅ ডেলিভারি সম্পন্ন');
        }
    });
});
</script>

@endsection
