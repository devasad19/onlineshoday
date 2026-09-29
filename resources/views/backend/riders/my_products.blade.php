@extends('apps.dashboard_master')
@section('title', 'আমার পণ্য ব্যবস্থাপনা')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <!-- 🟢 Sidebar -->
    <!-- @include('backend.patrials.rider_aside') -->
 
    <!-- 🟡 Main Content Area -->
    <div class="flex-1 flex flex-col p-4">
        <!-- Top Bar -->
        @include('backend.patrials.top_bar')

        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-700">🛒 আমার পণ্য ব্যবস্থাপনা</h1>

            <!-- Product Manage Section -->
            <div class="bg-white shadow rounded-lg p-6 mb-8">
                <h2 class="text-xl font-semibold mb-4">পণ্য তালিকা থেকে দাম নির্ধারণ ও ব্যবস্থাপনা</h2>

                <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="p-3 text-left">#</th>
                            <th class="p-3 text-left">পণ্যের নাম</th>
                            <th class="p-3 text-left">মূল দাম</th>
                            <th class="p-3 text-left">আমার বিক্রয় মূল্য (৳)</th>
                            <th class="p-3 text-center">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $key => $product)
                            @php
                                $riderProduct = $riderProducts->firstWhere('product_id', $product->id);
                            @endphp
                            <tr class="border-t {{ $riderProduct ? 'bg-green-50' : '' }}">
                                <td class="p-3">{{ $key+1 }}</td>
                                <td class="p-3">{{ $product->name }}</td>
                                <td class="p-3">{{ number_format($product->price, 2) }} ৳</td>
                                <td class="p-3">
                                    <input type="number"
                                           class="border rounded px-3 py-1 w-32 rider-price"
                                           data-product-id="{{ $product->id }}"
                                           value="{{ $riderProduct ? $riderProduct->price : '' }}"
                                           placeholder="নিজের দাম দিন">
                                </td>
                                <td class="p-3 text-center">
                                    @if($riderProduct)
                                        <button class="bg-blue-600 text-white px-4 py-1 rounded addOrUpdateProductBtn hover:bg-blue-700 transition"
                                                data-product-id="{{ $product->id }}"
                                                data-type="update">
                                            🔄 আপডেট করুন
                                        </button>
                                    @else
                                        <button class="bg-green-600 text-white px-4 py-1 rounded addOrUpdateProductBtn hover:bg-green-700 transition"
                                                data-product-id="{{ $product->id }}"
                                                data-type="add">
                                            ➕ যোগ করুন
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Add or Update Product
    $('.addOrUpdateProductBtn').click(function() {
        const btn = $(this);
        const productId = btn.data('product-id');
        const actionType = btn.data('type'); // 'add' or 'update'
        const price = $(`.rider-price[data-product-id="${productId}"]`).val();

        if (!price || price <= 0) {
            Swal.fire('⚠️ সতর্কতা', 'দয়া করে নিজের বিক্রয়মূল্য নির্ধারণ করুন।', 'warning');
            return;
        }

        $.ajax({
            url: "{{ route('rider.products.store') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId,
                price: price
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: '✅ সফল হয়েছে!',
                    text: actionType === 'add'
                        ? 'পণ্যটি আপনার তালিকায় যোগ হয়েছে!'
                        : 'দাম সফলভাবে আপডেট হয়েছে!',
                    timer: 1500,
                    showConfirmButton: false
                });

                // Change button style dynamically
                btn.removeClass('bg-green-600 hover:bg-green-700')
                   .addClass('bg-blue-600 hover:bg-blue-700')
                   .text('🔄 আপডেট করুন')
                   .data('type', 'update');

                // Highlight row
                btn.closest('tr').addClass('bg-green-50');
            },
            error: function(xhr) {
                Swal.fire('❌ ব্যর্থ', xhr.responseJSON?.message || 'কিছু ভুল হয়েছে।', 'error');
            }
        });
    });
});
</script>
@endsection
