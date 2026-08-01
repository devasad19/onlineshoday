@extends('apps.front_master')

@section('content')
<section class="bg-gradient-to-r from-green-50 via-white to-green-50 py-12">
  <div class="max-w-6xl mx-auto px-6">

    <!-- 🔙 Back Button -->
    <div class="mb-6">
      <a href="{{ url('/') }}" class="text-green-600 hover:text-green-800 font-semibold flex items-center gap-1">
        ← হোমে ফিরে যান
      </a>
    </div>

    <!-- Rider Profile Card -->
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col md:flex-row gap-8 items-center">
      
      <!-- Profile Image -->
      <div class="md:w-1/3 flex justify-center">
        <img src="{{ $rider->photo ? asset('uploads/riders/'.$rider->photo) : 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png' }}" 
             alt="{{ $rider->name }}" 
             class="rounded-full w-48 h-48 object-cover border-4 border-green-200 shadow-md">
      </div>

      <!-- Rider Info -->
      <div class="md:w-2/3">
        <h2 class="text-3xl font-extrabold text-green-700 mb-2">{{ $rider->name }}</h2>
        <p class="text-gray-600 text-sm mb-3">📞 {{ $rider->phone }}</p>
        <p class="text-gray-600 text-sm mb-3">👨‍👦 পিতার নাম: {{ $rider->father_name }}</p>
        <p class="text-gray-600 text-sm mb-3">🎓 শিক্ষাগত যোগ্যতা: {{ $rider->edu_qualification }}</p>
        <p class="text-gray-600 text-sm mb-3">🏫 প্রতিষ্ঠান: {{ $rider->institute }}</p>
        <p class="text-gray-600 text-sm mb-3">🏠 ঠিকানা: {{ $rider->address }}</p>
        <p class="text-gray-600 text-sm mb-3">🚲 যানবাহন: {{ $rider->vehicle_type ?? 'তথ্য নেই' }}</p>

        <div class="flex flex-wrap gap-3 mt-4">
          <span class="px-4 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">Status: {{ ucfirst($rider->status) }}</span>
          <span class="px-4 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">Available: {{ $rider->available ? 'Yes' : 'No' }}</span>
        </div>
      </div>
    </div>

    <!-- Rider Performance -->
    <div class="mt-10 bg-white rounded-2xl shadow p-6">
      <h3 class="text-2xl font-bold text-green-700 mb-4">📊 পারফরম্যান্স বিশ্লেষণ</h3>

      <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
        <div class="bg-green-50 p-4 rounded-lg shadow-sm">
          <p class="text-gray-600 text-sm">Total Delivered</p>
          <h4 class="text-2xl font-bold text-green-700">{{ $rider->total_delivered }}</h4>
        </div>
        <div class="bg-blue-50 p-4 rounded-lg shadow-sm">
          <p class="text-gray-600 text-sm">On Time Delivery</p>
          <h4 class="text-2xl font-bold text-blue-700">{{ $rider->on_time_delivery }}</h4>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg shadow-sm">
          <p class="text-gray-600 text-sm">Pending Orders</p>
          <h4 class="text-2xl font-bold text-yellow-700">{{ $rider->pending_orders }}</h4>
        </div>
        <div class="bg-red-50 p-4 rounded-lg shadow-sm">
          <p class="text-gray-600 text-sm">Cancelled</p>
          <h4 class="text-2xl font-bold text-red-700">{{ $rider->cancel_delivery }}</h4>
        </div>
      </div>

      @php
        $percent = $rider->total_delivered > 0 ? round(($rider->on_time_delivery / $rider->total_delivered) * 100) : 0;
      @endphp

      <div class="mt-6">
        <p class="text-gray-700 mb-2 font-semibold">⏱️ সময়মতো ডেলিভারি রেট:</p>
        <div class="w-full bg-gray-200 h-3 rounded-full overflow-hidden">
          <div class="bg-green-500 h-3" style="width: {{ $percent }}%"></div>
        </div>
        <p class="text-right text-sm text-gray-600 mt-1">{{ $percent }}%</p>
      </div>
    </div>

    <!-- Recent Delivery Section -->
    <div class="mt-10 bg-white rounded-2xl shadow p-6">
      <h3 class="text-2xl font-bold text-green-700 mb-4">🧾 সাম্প্রতিক ডেলিভারি</h3>

      <table class="w-full border-collapse text-left">
        <thead>
          <tr class="bg-green-50 text-gray-700">
            <th class="py-2 px-3 border">#</th>
            <th class="py-2 px-3 border">অর্ডার আইডি</th>
            <th class="py-2 px-3 border">অবস্থা</th>
            <th class="py-2 px-3 border">তারিখ</th>
          </tr>
        </thead>
        <tbody>
          @forelse($recentOrders as $index => $order)
          <tr class="border-b hover:bg-green-50">
            <td class="py-2 px-3 border">{{ $index + 1 }}</td>
            <td class="py-2 px-3 border text-green-700 font-semibold">#{{ $order->id }}</td>
            <td class="py-2 px-3 border text-sm">
              <span class="px-3 py-1 rounded-full text-xs font-semibold 
                {{ $order->status == 'delivered' ? 'bg-green-100 text-green-700' : ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                {{ ucfirst($order->status) }}
              </span>
            </td>
            <td class="py-2 px-3 border text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="text-center text-gray-500 py-4">❌ কোন ডেলিভারি ইতিহাস পাওয়া যায়নি</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </div>
</section>
@endsection
