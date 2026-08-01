@extends('apps.dashboard_master')

@section('content')
<div class="flex min-h-screen bg-gray-50">

    

    <!-- 🟡 Main Content Area -->
    <div class="flex-1 min-w-0 flex flex-col">
        @include('backend.patrials.top_bar')

        <!-- Page Title -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-green-700">📋 Customer List</h2>
        </div>

        <!-- Filter -->
        <div class="flex justify-end mb-4">
            <select class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                <option value="today">Today</option>
                <option value="yesterday">Yesterday</option>
                <option value="7_days">Last 7 Days</option>
                <option value="15_days">Last 15 Days</option>
                <option value="1_month">1 Month</option>
            </select>
        </div>

        <!-- Customer Table -->
<div class="w-full overflow-x-auto">
    <table class="min-w-[900px] border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-green-50 text-gray-700">
                        <th class="py-2 px-4 border">#</th>
                        <th class="py-2 px-4 border">Name</th>
                        <th class="py-2 px-4 border">Email</th>
                        <th class="py-2 px-4 border">Phone</th>
                        <th class="py-2 px-4 border">Total Orders</th>
                        <th class="py-2 px-4 border">Pending Orders</th>
                        <th class="py-2 px-4 border">Status</th>
                        <th class="py-2 px-4 border">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $index => $customer)
                    <tr class="border-b hover:bg-green-50">
                        <td class="py-2 px-4 border">{{ $index + 1 }}</td>
                        <td class="py-2 px-4 border">{{ $customer->name }}</td>
                        <td class="py-2 px-4 border">{{ $customer->email }}</td>
                        <td class="py-2 px-4 border">{{ $customer->phone }}</td>
                        <td class="py-2 px-4 border">{{ $customer->total_orders }}</td>
                        <td class="py-2 px-4 border">{{ $customer->pending_orders }}</td>
                        <td class="py-2 px-4 border">
                            @if($customer->status == 'active')
                                <span class="text-green-600 font-semibold">Active</span>
                            @else
                                <span class="text-red-600 font-semibold">Inactive</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 border flex gap-2 md:p-6">
                            <button class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition" 
                                    onclick="alert('View Customer Details')">View</button>
                            <button class="bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500 transition" 
                                    onclick="alert('Edit Customer')">Edit</button>
                            <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition" 
                                    onclick="alert('Delete Customer')">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
