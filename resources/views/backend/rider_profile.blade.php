@extends('apps.dashboard_master')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    @include('backend.patrials.admin_aside')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col p-6">
        @include('backend.patrials.top_bar')

        <!-- Rider Profile Section -->
        <div class="bg-white rounded-2xl shadow p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center gap-6">
                <img src="{{ $rider->avatar ?? 'https://via.placeholder.com/100' }}" 
                     alt="{{ $rider->name }}" 
                     class="w-24 h-24 rounded-full object-cover border-2 border-green-600">

                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $rider->name }}</h2>
                    <p class="text-gray-600">Email: {{ $rider->email ?? 'example@mail.com' }}</p>
                    <p class="text-gray-600">Phone: {{ $rider->phone ?? '0123456789' }}</p>
                    <p class="text-gray-600">Joined: {{ $rider->created_at }}</p>
                </div>
            </div>
        </div>

        <!-- Delivery Stats -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
            <div class="bg-green-100 rounded-2xl shadow p-5 flex flex-col items-center justify-center">
                <h3 class="text-lg font-semibold text-green-700 mb-2">Total Delivered</h3>
                <p class="text-2xl font-bold text-green-800">{{ $rider->total_delivered ?? 0 }}</p>
            </div>
            <div class="bg-blue-100 rounded-2xl shadow p-5 flex flex-col items-center justify-center">
                <h3 class="text-lg font-semibold text-blue-700 mb-2">On-Time Delivery</h3>
                <p class="text-2xl font-bold text-blue-800">
                    {{ $rider->on_time_delivery ?? 0 }}
                    <span class="text-sm text-gray-600">({{ $rider->on_time_percentage ?? 0 }}%)</span>
                </p>
            </div>
            <div class="bg-yellow-100 rounded-2xl shadow p-5 flex flex-col items-center justify-center">
                <h3 class="text-lg font-semibold text-yellow-700 mb-2">Pending Orders</h3>
                <p class="text-2xl font-bold text-yellow-800">{{ $rider->pending_orders ?? 0 }}</p>
            </div>
            <div class="bg-red-100 rounded-2xl shadow p-5 flex flex-col items-center justify-center">
                <h3 class="text-lg font-semibold text-red-700 mb-2">Cancelled Orders</h3>
                <p class="text-2xl font-bold text-red-800">{{ $rider->cancel_orders ?? 0 }}</p>
            </div>
            <div class="bg-purple-100 rounded-2xl shadow p-5 flex flex-col items-center justify-center">
                <h3 class="text-lg font-semibold text-purple-700 mb-2">Total Earnings</h3>
                <p class="text-2xl font-bold text-purple-800">৳{{ $rider->total_earnings ?? 0 }}</p>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Recent Orders</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-green-50 text-gray-700">
                            <th class="py-2 px-4 border">Order ID</th>
                            <th class="py-2 px-4 border">Customer</th>
                            <th class="py-2 px-4 border">Product</th>
                            <th class="py-2 px-4 border">Quantity</th>
                            <th class="py-2 px-4 border">Price</th>
                            <th class="py-2 px-4 border">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rider->recent_orders ?? [] as $order)
                        <tr class="border-b hover:bg-green-50">
                            <td class="py-2 px-4 border">#{{ $order->id }}</td>
                            <td class="py-2 px-4 border">{{ $order->customer_name }}</td>
                            <td class="py-2 px-4 border">{{ $order->product_name }}</td>
                            <td class="py-2 px-4 border">{{ $order->quantity }}</td>
                            <td class="py-2 px-4 border">৳{{ $order->price }}</td>
                            <td class="py-2 px-4 border text-green-600 font-semibold">{{ $order->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
