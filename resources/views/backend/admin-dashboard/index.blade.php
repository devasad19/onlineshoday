@extends('apps.dashboard_master')

@section('content')

<div class="flex min-h-screen bg-gray-50">

    <div class="flex-1 flex flex-col">

        @include('backend.patrials.top_bar')


        <!-- ========================================================= -->
        <!-- Dashboard Content -->
        <!-- ========================================================= -->

        <section class="bg-gray-50 p-3 md:p-6">


            <!-- ===================================================== -->
            <!-- Header -->
            <!-- ===================================================== -->

            <div class="mb-6">

                <h2 class="text-2xl md:text-3xl font-bold text-green-700">
                    📊 অ্যাডমিন ড্যাশবোর্ড
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Online Shoday-এর গুরুত্বপূর্ণ ব্যবসায়িক তথ্য ও রিপোর্ট
                </p>

            </div>



            <!-- ===================================================== -->
            <!-- Sales Overview -->
            <!-- ===================================================== -->

            <div class="mb-8">

                <div class="flex items-center justify-between mb-4">

                    <h3 class="text-lg md:text-xl font-bold text-gray-800">
                        💰 বিক্রয় ও আয়
                    </h3>

                </div>


                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">


                    <!-- Total Sell -->

                    <div class="bg-white rounded-2xl shadow-sm border border-green-100 p-5">

                        <div class="flex items-start justify-between">

                            <div>

                                <p class="text-sm text-gray-500">
                                    মোট বিক্রয়
                                </p>

                                <h3 class="text-2xl md:text-3xl font-bold text-green-700 mt-2">
                                    ৳{{ number_format($totalSell, 2) }}
                                </h3>

                                <p class="text-xs text-gray-400 mt-2">
                                    Delivered Orders থেকে
                                </p>

                            </div>

                            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-2xl">
                                💰
                            </div>

                        </div>

                        <a
                            href="{{ route('admin.all_orders') }}"
                            class="inline-block mt-4 text-sm font-semibold text-green-600 hover:text-green-800"
                        >
                            বিস্তারিত দেখুন →
                        </a>

                    </div>



                    <!-- Today Pending Amount -->

                    <div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-5">

                        <div class="flex items-start justify-between">

                            <div>

                                <p class="text-sm text-gray-500">
                                    আজকের Pending Amount
                                </p>

                                <h3 class="text-2xl md:text-3xl font-bold text-orange-600 mt-2">
                                    ৳{{ number_format($todayPendingAmount, 2) }}
                                </h3>

                                <p class="text-xs text-gray-400 mt-2">
                                    আজকের Delivered নয় এমন Order
                                </p>

                            </div>

                            <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center text-2xl">
                                ⏳
                            </div>

                        </div>

                        <a
                            href="{{ route('admin.all_orders') }}"
                            class="inline-block mt-4 text-sm font-semibold text-orange-600 hover:text-orange-800"
                        >
                            Pending Order দেখুন →
                        </a>

                    </div>

                </div>

            </div>



            <!-- ===================================================== -->
            <!-- Order Overview -->
            <!-- ===================================================== -->

            <div class="mb-8">

                <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-4">
                    🛒 অর্ডার রিপোর্ট
                </h3>


                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">


                    <!-- Total Orders -->

                    <div class="bg-white rounded-2xl shadow-sm border p-4">

                        <div class="text-2xl mb-2">
                            🛒
                        </div>

                        <p class="text-sm text-gray-500">
                            মোট অর্ডার
                        </p>

                        <p class="text-2xl font-bold text-blue-700 mt-1">
                            {{ number_format($totalOrders) }}
                        </p>

                        <a
                            href="{{ route('admin.all_orders') }}"
                            class="text-xs text-blue-600 font-semibold inline-block mt-3"
                        >
                            বিস্তারিত →
                        </a>

                    </div>



                    <!-- Today Orders -->

                    <div class="bg-white rounded-2xl shadow-sm border p-4">

                        <div class="text-2xl mb-2">
                            📅
                        </div>

                        <p class="text-sm text-gray-500">
                            আজকের অর্ডার
                        </p>

                        <p class="text-2xl font-bold text-green-700 mt-1">
                            {{ number_format($todayOrders) }}
                        </p>

                        <a
                            href="{{ route('admin.all_orders') }}"
                            class="text-xs text-green-600 font-semibold inline-block mt-3"
                        >
                            বিস্তারিত →
                        </a>

                    </div>



                    <!-- Pending Orders -->

                    <div class="bg-white rounded-2xl shadow-sm border p-4">

                        <div class="text-2xl mb-2">
                            ⏳
                        </div>

                        <p class="text-sm text-gray-500">
                            Pending Order
                        </p>

                        <p class="text-2xl font-bold text-orange-600 mt-1">
                            {{ number_format($pendingOrders) }}
                        </p>

                        <a
                            href="{{ route('admin.all_orders') }}"
                            class="text-xs text-orange-600 font-semibold inline-block mt-3"
                        >
                            বিস্তারিত →
                        </a>

                    </div>



                    <!-- Cancel Orders -->

                    <div class="bg-white rounded-2xl shadow-sm border p-4">

                        <div class="text-2xl mb-2">
                            ❌
                        </div>

                        <p class="text-sm text-gray-500">
                            Cancel Order
                        </p>

                        <p class="text-2xl font-bold text-red-600 mt-1">
                            {{ number_format($cancelOrders) }}
                        </p>

                        <a
                            href="{{ route('admin.all_orders') }}"
                            class="text-xs text-red-600 font-semibold inline-block mt-3"
                        >
                            বিস্তারিত →
                        </a>

                    </div>

                </div>

            </div>



            <!-- ===================================================== -->
            <!-- Delivery Charge -->
            <!-- ===================================================== -->

            <div class="mb-8">

                <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-4">
                    🚚 ডেলিভারি চার্জ
                </h3>


                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">


                    <!-- Total Delivery Charge -->

                    <div class="bg-white rounded-2xl shadow-sm border border-purple-100 p-5">

                        <div class="flex items-start justify-between">

                            <div>

                                <p class="text-sm text-gray-500">
                                    মোট Delivery Charge
                                </p>

                                <h3 class="text-2xl md:text-3xl font-bold text-purple-700 mt-2">
                                    ৳{{ number_format($totalDeliveryCharge, 2) }}
                                </h3>

                                <p class="text-xs text-gray-400 mt-2">
                                    Delivered Orders
                                </p>

                            </div>

                            <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center text-2xl">
                                🚚
                            </div>

                        </div>

                        <a
                            href="{{ route('admin.all_orders') }}"
                            class="inline-block mt-4 text-sm font-semibold text-purple-600 hover:text-purple-800"
                        >
                            বিস্তারিত দেখুন →
                        </a>

                    </div>



                    <!-- Today Delivery Charge -->

                    <div class="bg-white rounded-2xl shadow-sm border border-indigo-100 p-5">

                        <div class="flex items-start justify-between">

                            <div>

                                <p class="text-sm text-gray-500">
                                    আজকের Delivery Charge
                                </p>

                                <h3 class="text-2xl md:text-3xl font-bold text-indigo-700 mt-2">
                                    ৳{{ number_format($todayDeliveryCharge, 2) }}
                                </h3>

                                <p class="text-xs text-gray-400 mt-2">
                                    আজ Delivered হওয়া Order
                                </p>

                            </div>

                            <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-2xl">
                                📦
                            </div>

                        </div>

                        <a
                            href="{{ route('admin.all_orders') }}"
                            class="inline-block mt-4 text-sm font-semibold text-indigo-600 hover:text-indigo-800"
                        >
                            বিস্তারিত দেখুন →
                        </a>

                    </div>

                </div>

            </div>



            <!-- ===================================================== -->
            <!-- Products / Customers / Packages -->
            <!-- ===================================================== -->

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">


                <!-- ================================================= -->
                <!-- Products -->
                <!-- ================================================= -->

                <div class="bg-white rounded-2xl shadow-sm border p-5">

                    <div class="flex items-center justify-between mb-5">

                        <div>

                            <h3 class="text-lg font-bold text-gray-800">
                                📦 Products
                            </h3>

                            <p class="text-xs text-gray-500 mt-1">
                                পণ্যের বর্তমান অবস্থা
                            </p>

                        </div>

                        <div class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center text-xl">
                            📦
                        </div>

                    </div>


                    <div class="space-y-4">


                        <div class="flex justify-between items-center">

                            <span class="text-gray-600">
                                মোট Product
                            </span>

                            <span class="font-bold text-blue-700">
                                {{ number_format($totalProducts) }}
                            </span>

                        </div>


                        <div class="flex justify-between items-center">

                            <span class="text-gray-600">
                                Inactive Product
                            </span>

                            <span class="font-bold text-red-600">
                                {{ number_format($inactiveProducts) }}
                            </span>

                        </div>

                    </div>


                    <a
                        href="{{ url('admin/products') }}"
                        class="block text-center mt-5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold py-2.5 rounded-xl transition"
                    >
                        Product বিস্তারিত দেখুন →
                    </a>

                </div>



                <!-- ================================================= -->
                <!-- Customers -->
                <!-- ================================================= -->

                <div class="bg-white rounded-2xl shadow-sm border p-5">

                    <div class="flex items-center justify-between mb-5">

                        <div>

                            <h3 class="text-lg font-bold text-gray-800">
                                👥 Customers
                            </h3>

                            <p class="text-xs text-gray-500 mt-1">
                                Customer activity
                            </p>

                        </div>

                        <div class="w-11 h-11 rounded-xl bg-green-100 flex items-center justify-center text-xl">
                            👥
                        </div>

                    </div>


                    <div class="space-y-4">


                        <div class="flex justify-between items-center">

                            <span class="text-gray-600">
                                মোট Customer
                            </span>

                            <span class="font-bold text-green-700">
                                {{ number_format($totalCustomers) }}
                            </span>

                        </div>


                        <div class="flex justify-between items-center">

                            <span class="text-gray-600">
                                আজ নতুন Customer
                            </span>

                            <span class="font-bold text-blue-600">
                                {{ number_format($todayCustomers) }}
                            </span>

                        </div>

                    </div>


                    <a
                        href="{{ url('admin/customers') }}"
                        class="block text-center mt-5 bg-green-50 hover:bg-green-100 text-green-700 font-semibold py-2.5 rounded-xl transition"
                    >
                        Customer বিস্তারিত দেখুন →
                    </a>

                </div>



                <!-- ================================================= -->
                <!-- Packages -->
                <!-- ================================================= -->

                <div class="bg-white rounded-2xl shadow-sm border p-5">

                    <div class="flex items-center justify-between mb-5">

                        <div>

                            <h3 class="text-lg font-bold text-gray-800">
                                🎁 Combo Packages
                            </h3>

                            <p class="text-xs text-gray-500 mt-1">
                                Package status
                            </p>

                        </div>

                        <div class="w-11 h-11 rounded-xl bg-orange-100 flex items-center justify-center text-xl">
                            🎁
                        </div>

                    </div>


                    <div class="space-y-4">


                        <div class="flex justify-between items-center">

                            <span class="text-gray-600">
                                মোট Package
                            </span>

                            <span class="font-bold text-orange-700">
                                {{ number_format($totalPackages) }}
                            </span>

                        </div>


                        <div class="flex justify-between items-center">

                            <span class="text-gray-600">
                                Active
                            </span>

                            <span class="font-bold text-green-600">
                                {{ number_format($activePackages) }}
                            </span>

                        </div>


                        <div class="flex justify-between items-center">

                            <span class="text-gray-600">
                                Inactive
                            </span>

                            <span class="font-bold text-red-600">
                                {{ number_format($inactivePackages) }}
                            </span>

                        </div>

                    </div>


                    <a
                        href="{{ url('admin/packages') }}"
                        class="block text-center mt-5 bg-orange-50 hover:bg-orange-100 text-orange-700 font-semibold py-2.5 rounded-xl transition"
                    >
                        Package বিস্তারিত দেখুন →
                    </a>

                </div>

            </div>



            <!-- ===================================================== -->
            <!-- Quick Summary -->
            <!-- ===================================================== -->

            <div class="bg-white rounded-2xl shadow-sm border p-5">


                <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-5">
                    📋 আজকের সংক্ষিপ্ত রিপোর্ট
                </h3>


                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">


                    <div class="bg-green-50 rounded-xl p-4">

                        <p class="text-sm text-green-700">
                            আজকের অর্ডার
                        </p>

                        <p class="text-2xl font-bold text-green-800 mt-1">
                            {{ number_format($todayOrders) }}
                        </p>

                    </div>


                    <div class="bg-orange-50 rounded-xl p-4">

                        <p class="text-sm text-orange-700">
                            Pending Amount
                        </p>

                        <p class="text-2xl font-bold text-orange-800 mt-1">
                            ৳{{ number_format($todayPendingAmount, 2) }}
                        </p>

                    </div>


                    <div class="bg-purple-50 rounded-xl p-4">

                        <p class="text-sm text-purple-700">
                            আজ Delivery Charge
                        </p>

                        <p class="text-2xl font-bold text-purple-800 mt-1">
                            ৳{{ number_format($todayDeliveryCharge, 2) }}
                        </p>

                    </div>


                    <div class="bg-blue-50 rounded-xl p-4">

                        <p class="text-sm text-blue-700">
                            আজ নতুন Customer
                        </p>

                        <p class="text-2xl font-bold text-blue-800 mt-1">
                            {{ number_format($todayCustomers) }}
                        </p>

                    </div>

                </div>

            </div>


        </section>

    </div>

</div>

@endsection


@section('scripts')

<script>
    console.log("📊 Admin Dashboard Loaded Successfully");
</script>

@endsection
 
