@extends('apps.dashboard_master')

@section('content')
<div class="flex min-h-screen bg-gray-50">

    

    <!-- 🟡 Main Content Area -->
    <div class="flex-1 min-w-0 flex flex-col">
        @include('backend.patrials.top_bar')

        <div class="bg-white rounded-2xl shadow p-2 md:p-6">
            <!-- Add Rider Button -->
            <div class="flex justify-end mb-4">
                <h2 class="text-2xl font-bold text-green-700 mb-6">📦 Rider List</h2>
                <button id="openAddRiderModal"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow font-semibold">
                    ➕ Add Rider
                </button>
            </div>


            <!-- Filter -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">

            <div class="w-full overflow-x-auto">
    <table class="min-w-[900px] border-collapse whitespace-nowrap">Filter by:</label>
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

            <!-- Rider Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-green-50 text-gray-700">
                            <th class="py-2 px-4 border">#</th>
                            <th class="py-2 px-4 border">Name</th>
                            <th class="py-2 px-4 border">Total Delivered</th>
                            <th class="py-2 px-4 border">On-Time Delivery</th>
                            <th class="py-2 px-4 border">Pending Orders</th>
                            <th class="py-2 px-4 border">Cancel Delivery</th>
                        </tr>
                    </thead>
                    <tbody id="riderTableBody">
                        @foreach($riders as $rider)
                        <tr class="border-b hover:bg-green-50">
                            <td class="py-2 px-4 border">{{ $rider->id }}</td>
                            <td class="py-2 px-4 border"><a href="{{ route('admin.rider.profile') }}"> {{ $rider->name }}</a></td>
                            <td class="py-2 px-4 border text-green-600 font-semibold">{{ $rider->total_delivered }}</td>
                            <td class="py-2 px-4 border text-blue-600 font-semibold">{{ $rider->on_time_delivery }}</td>
                            <td class="py-2 px-4 border text-yellow-600 font-semibold">{{ $rider->pending_orders }}</td>
                            <td class="py-2 px-4 border text-red-600 font-semibold">{{ $rider->cancel_delivery }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>



<!-- Add Rider Modal -->
<div id="addRiderModal"
    class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6 relative">
        <button id="closeAddRiderModal" class="absolute top-2 md:p-6 right-3 text-gray-500 hover:text-red-600">✖</button>

        <h2 class="text-xl font-bold text-green-700 mb-4">Add New Rider</h2>
 
            <form id="addRiderForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Name *</label>
                    <input type="text" name="name" required class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Phone *</label>
                    <input type="text" name="phone" required class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Email</label>
                    <input type="email" name="email" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Status *</label>
                    <select name="status" required class="w-full border rounded-lg px-3 py-2">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-1">Address</label>
                    <textarea name="address" rows="2" class="w-full border rounded-lg px-3 py-2"></textarea>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow font-semibold">
                    Save Rider
                </button>
            </div>
        </form>
    </div>
</div>


</div>
@endsection

@section('scripts')
<script>
// Filter and Sort Example (Frontend, mockup only)
const riders = @json($riders); // Laravel collection to JS object

const dateFilter = document.getElementById('dateFilter');
const sortBy = document.getElementById('sortBy');
const riderTableBody = document.getElementById('riderTableBody');

function renderTable(data) {
    riderTableBody.innerHTML = '';
    data.forEach(r => {
        const row = `
        <tr class="border-b hover:bg-green-50">
            <td class="py-2 px-4 border">${r.id}</td>
            <td class="py-2 px-4 border">${r.name}</td>
            <td class="py-2 px-4 border text-green-600 font-semibold">${r.total_delivered}</td>
            <td class="py-2 px-4 border text-blue-600 font-semibold">${r.on_time_delivery}</td>
            <td class="py-2 px-4 border text-yellow-600 font-semibold">${r.pending_orders}</td>
            <td class="py-2 px-4 border text-red-600 font-semibold">${r.cancel_delivery}</td>
        </tr>`;
        riderTableBody.innerHTML += row;
    });
}

function sortData(data, key, order='desc') {
    return data.sort((a,b) => order === 'desc' ? b[key] - a[key] : a[key] - b[key]);
}

function filterData(dateOption) {
    // Mock: frontend filtering example
    // TODO: Replace with backend filter if real orders data
    return riders;
}

// Event listeners
dateFilter.addEventListener('change', () => {
    const filtered = filterData(dateFilter.value);
    const sorted = sortData(filtered, sortBy.value.includes('total_delivered') ? 'total_delivered' : 'pending_orders',
        sortBy.value.includes('desc') ? 'desc' : 'asc');
    renderTable(sorted);
});

sortBy.addEventListener('change', () => {
    const filtered = filterData(dateFilter.value);
    const sorted = sortData(filtered, sortBy.value.includes('total_delivered') ? 'total_delivered' : 'pending_orders',
        sortBy.value.includes('desc') ? 'desc' : 'asc');
    renderTable(sorted);
});
</script>
@endsection
