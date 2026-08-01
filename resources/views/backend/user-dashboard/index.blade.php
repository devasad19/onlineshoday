@extends('apps.dashboard_master')

@section('content')
 
    <!-- 🟢 সাইডবার -->
    <!-- @include('backend.patrials.aside') -->

    <!-- 🟡 মূল কন্টেন্ট -->
    <div class="flex-1 flex flex-col p-2 md:p-6">
        <!-- টপ বার -->
        @include('backend.patrials.top_bar')

        <!-- 🎁 অফার নোটিশ -->
        <div id="offerNotice"
            class="bg-gradient-to-r from-green-500 to-green-700 text-white p-5 rounded-2xl shadow-md mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3 transition-all duration-300">
            <p class="font-semibold text-lg">
                🎉 <span class="font-bold">বিশেষ অফার!</span>
                এই সপ্তাহে তাজা সবজিতে <span class="underline decoration-white">১০% ছাড়</span>।
            </p>
            <div class="flex items-center gap-3">
                <a href="{{ route('user.my_cart') }}" 
                   class="bg-white text-green-700 font-semibold px-4 py-2 rounded-lg hover:bg-green-100 transition">
                    🛒 এখনই অর্ডার করুন
                </a>
                <button onclick="closeOfferNotice()" class="text-white hover:text-gray-200 text-2xl font-bold leading-none">&times;</button>
            </div>
        </div>

        <!-- 🧮 সারাংশ কার্ড -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow-md p-6 flex items-center justify-between border-l-4 border-green-500">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">মোট অর্ডার</h3>
                    <p class="text-3xl font-bold text-green-600">{{ bnNum($totalOrders) }}</p>
                </div>
                <span class="text-4xl">📦</span>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 flex items-center justify-between border-l-4 border-yellow-500">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">অপেক্ষমান</h3>
                    <p class="text-3xl font-bold text-yellow-500">{{ bnNum($pendingOrders) }}</p>
                </div>
                <span class="text-4xl">⏳</span>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 flex items-center justify-between border-l-4 border-blue-500">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">সম্পন্ন</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ bnNum($completedOrders) }}</p>
                </div>
                <span class="text-4xl">✅</span>
            </div>
        </div>

        <!-- 🧾 সাম্প্রতিক অর্ডার কার্ড -->
        <h3 class="text-xl font-semibold text-gray-800 mt-8 mb-4">📋 সাম্প্রতিক অর্ডারসমূহ</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
            @forelse($recentOrders as $order)
            <div class="bg-white p-3 md:p-6 rounded-2xl shadow hover:shadow-lg transition relative border-t-4 
                        @if($order->status === 'pending') border-yellow-500 
                        @elseif($order->status === 'delivered') border-green-600 
                        @elseif($order->status === 'cancelled') border-red-500 
                        @else border-gray-400 @endif">

                <h4 class="text-lg font-bold text-gray-800 mb-2">🆔 অর্ডার কোড: #{{ $order->order_code }}</h4>
                
                <div class="text-sm text-gray-700 mb-3">
                    <p><span class="font-semibold">অবস্থা:</span>
                        @if($order->status === 'pending')
                            <span class="text-yellow-600 font-semibold">⏳ অপেক্ষমান</span>
                        @elseif($order->status === 'delivered')
                            <span class="text-green-600 font-semibold">✅ সম্পন্ন</span>
                        @elseif($order->status === 'cancelled')
                            <span class="text-red-500 font-semibold">❌ বাতিল</span>
                        @else
                            <span class="text-gray-500">{{ ucfirst($order->status) }}</span>
                        @endif
                    </p>
                    <p><span class="font-semibold">নাম:</span> {{ $order->user->name }}</p>
                    <p><span class="font-semibold">তারিখ:</span> {{ $order->created_at->format('d M, Y h:i A') }}</p>
                    <p><span class="font-semibold">মোট মূল্য:</span> ৳{{ bnNum($order->total_amount, 2) }}</p>
                </div>

                <div class="mb-3">
                    <h5 class="font-semibold text-gray-700 mb-1">🛒 পণ্যসমূহ:</h5>
                    <ul class="text-sm text-gray-600 space-y-1">
                        @foreach($order->items as $item)
                            <li>• {{ $item->product->name }} – {{ bnNum($item->quantity) }} {{ $item->product->unit ?? 'টি' }}</li>
                        @endforeach
                    </ul>
                </div>

                <!-- Delivery status -->
                @php
                    $deliveryStatus = '';
                    if ($order->delivery_at) {
                        $expected = \Carbon\Carbon::parse($order->delivery_at);
                        $delivered = $order->delivered_at ? \Carbon\Carbon::parse($order->delivered_at) : null;

                        if ($delivered) {
                            $deliveryStatus = $delivered->gt($expected)
                                ? '❌ বিলম্বিত'
                                : '✅ সময়ে পৌঁছেছে';
                        } else {
                            $deliveryStatus = '🚚 পথে রয়েছে';
                        }
                    }
                @endphp

                <div class="mt-3 text-sm font-semibold
                    @if(str_contains($deliveryStatus, 'বিলম্ব')) text-red-600 
                    @elseif(str_contains($deliveryStatus, 'সময়')) text-green-600 
                    @else text-blue-600 @endif">
                    📦 ডেলিভারি স্ট্যাটাস: {{ $deliveryStatus }}
                </div>
            </div>
            @empty
            <div class="text-center col-span-3 py-10 text-gray-500">
                😔 এখনো কোনো অর্ডার দেওয়া হয়নি
            </div>
            @endforelse
        </div>
    </div>
 
@endsection

@section('scripts')
<script>
function closeOfferNotice() {
    const notice = document.getElementById('offerNotice');
    notice.classList.add('opacity-0', 'translate-y-3');
    setTimeout(() => notice.remove(), 300);
}
</script>
@endsection
