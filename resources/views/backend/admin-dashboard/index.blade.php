@extends('apps.dashboard_master')

@section('content')
 
<div class="flex min-h-screen bg-gray-50">
 

    <!-- Main Area -->
    <div class="flex-1 flex flex-col">

        @include('backend.patrials.top_bar')

        <!-- Content -->
         <!-- 🧩 Dashboard Body -->
        <!-- Content -->
        <section class="bg-white p-2 md:p-6 rounded-2xl shadow "> 

      
            <h2 class="text-2xl font-bold text-green-700 mb-6">📊 অ্যাডমিন ড্যাশবোর্ড</h2>

            <!-- 🔹 Stats Overview -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white shadow rounded-2xl p-5 text-center border-t-4 border-green-500">
                    <h3 class="text-gray-600 font-semibold">মোট ইউজার</h3>
                    <p class="text-3xl font-bold text-green-700 mt-2">1,245</p>
                </div>

                <div class="bg-white shadow rounded-2xl p-5 text-center border-t-4 border-blue-500">
                    <h3 class="text-gray-600 font-semibold">মোট অর্ডার</h3>
                    <p class="text-3xl font-bold text-blue-700 mt-2">856</p>
                </div>

                <div class="bg-white shadow rounded-2xl p-5 text-center border-t-4 border-yellow-500">
                    <h3 class="text-gray-600 font-semibold">মোট রেভিনিউ</h3>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">৳ 4,25,000</p>
                </div>

                <div class="bg-white shadow rounded-2xl p-5 text-center border-t-4 border-pink-500">
                    <h3 class="text-gray-600 font-semibold">পেন্ডিং অর্ডার</h3>
                    <p class="text-3xl font-bold text-pink-600 mt-2">42</p>
                </div>
            </div>

            <!-- 🔸 Recent Orders -->
            <div class="bg-white shadow rounded-2xl p-2 md:p-6 mb-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">🛒 সাম্প্রতিক অর্ডার</h3>
                    <a href="{{ route('admin.all_orders') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">সব অর্ডার দেখুন →</a>
                </div>

                <div class="overflow-x-auto">
                  <!-- 🔸 Recent Orders -->
<div class="bg-white shadow rounded-2xl p-1 mb-4">

   

    <div class="space-y-2">

        <!-- Order -->
        <div class="border rounded-xl p-4 hover:shadow transition">

            <div class="flex justify-between items-start">

                <div>
                    <h4 class="font-bold text-lg text-gray-800">
                        #1001
                    </h4>

                    <p class="text-gray-600">
                        👤 আল-আমিন
                    </p>
                </div>

                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                    সম্পন্ন
                </span>

            </div>

            <div class="grid grid-cols-2 gap-3 mt-4 text-sm">

                <div>
                    <span class="text-gray-500">
                        তারিখ
                    </span>

                    <p class="font-medium">
                        ২২ অক্টোবর, ২০২৫
                    </p>
                </div>

                <div>
                    <span class="text-gray-500">
                        পরিমাণ
                    </span>

                    <p class="font-bold text-green-700">
                        ৳ 2,500
                    </p>
                </div>

            </div>

        </div>

        <!-- Order -->
        <div class="border rounded-xl p-4 hover:shadow transition">

            <div class="flex justify-between items-start">

                <div>
                    <h4 class="font-bold text-lg text-gray-800">
                        #1002
                    </h4>

                    <p class="text-gray-600">
                        👤 মেহেদী হাসান
                    </p>
                </div>

                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                    পেন্ডিং
                </span>

            </div>

            <div class="grid grid-cols-2 gap-3 mt-4 text-sm">

                <div>
                    <span class="text-gray-500">
                        তারিখ
                    </span>

                    <p class="font-medium">
                        ২১ অক্টোবর, ২০২৫
                    </p>
                </div>

                <div>
                    <span class="text-gray-500">
                        পরিমাণ
                    </span>

                    <p class="font-bold text-green-700">
                        ৳ 1,200
                    </p>
                </div>

            </div>

        </div>

        <!-- Order -->
        <div class="border rounded-xl p-4 hover:shadow transition">

            <div class="flex justify-between items-start">

                <div>
                    <h4 class="font-bold text-lg text-gray-800">
                        #1003
                    </h4>

                    <p class="text-gray-600">
                        👤 রিয়াজ উদ্দিন
                    </p>
                </div>

                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                    বাতিল
                </span>

            </div>

            <div class="grid grid-cols-2 gap-3 mt-4 text-sm">

                <div>
                    <span class="text-gray-500">
                        তারিখ
                    </span>

                    <p class="font-medium">
                        ২০ অক্টোবর, ২০২৫
                    </p>
                </div>

                <div>
                    <span class="text-gray-500">
                        পরিমাণ
                    </span>

                    <p class="font-bold text-green-700">
                        ৳ 900
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>
                </div>
            </div>

            <!-- 🔹 Activity Summary -->
            <div class="bg-white shadow rounded-2xl p-5">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">📈 সাইট সারাংশ</h3>
                <ul class="space-y-2 text-gray-700">
                    <li>✅ আজ নতুন ইউজার: <strong>32</strong></li>
                    <li>🛍️ আজ নতুন অর্ডার: <strong>15</strong></li>
                    <li>💰 আজকের আয়: <strong>৳ 12,500</strong></li>
                    <li>📦 মোট প্রোডাক্ট: <strong>285</strong></li>
                </ul>
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
