<aside
    class="fixed md:static top-0 left-0 z-50
           w-64 h-screen bg-white shadow-md
           transform transition-transform duration-300
           md:translate-x-0
           flex flex-col"

    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

    <!-- Mobile Header -->
    <div class="md:hidden flex items-center justify-between p-4 border-b">

        <img src="{{ url('public/default/new-logo.png') }}"
             class="h-10">

        <button
            @click="sidebarOpen=false"
            class="text-2xl">

            ✕

        </button>

    </div>

    <div class="p-6 overflow-y-auto flex-1">

        @php
            if(Auth::user()->role->name == 'user'){
                $role = 'ইউজার';
            }elseif(Auth::user()->role->name == 'rider'){
                $role = 'রাইডার';
            }elseif(Auth::user()->role->name == 'admin'){
                $role = 'এডমিন';
            }
        @endphp

        <h2 class="text-2xl font-bold text-green-600 mb-6">

            {{ $role }} প্যানেল

        </h2>

        <div class="flex items-center gap-3 mb-6 pb-4 border-b">

            <img
                src="{{ auth()->user()->photo ? url('uploads/users/'.auth()->user()->photo) : url('public/default/user.jpg') }}"
                class="w-12 h-12 rounded-full object-cover">

            <div>

                <h4 class="font-semibold text-gray-800">

                    {{ Auth::user()->name }}

                </h4>

                <p class="text-xs text-gray-500">

                    {{ $role }}

                </p>

            </div>

        </div>

        <nav class="space-y-2">
      @if(Auth::user()->role->name == 'user')
            <a href="{{ route('user.dashboard') }}"
               @click="sidebarOpen=false"
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('user.dashboard') ? 'bg-green-100 font-semibold' : 'hover:bg-green-100' }}">

                🏠 <span>ড্যাশবোর্ড</span>

            </a>

            <a href="{{ route('user.my_orders') }}"
               @click="sidebarOpen=false"
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('user.my_orders') ? 'bg-green-100 font-semibold' : 'hover:bg-green-100' }}">

                📦 <span>আমার অর্ডার</span>

            </a>

            <a href="{{ route('user.my_cart') }}"
               @click="sidebarOpen=false"
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('user.my_cart') ? 'bg-green-100 font-semibold' : 'hover:bg-green-100' }}">

                🛒 <span>আমার বাজার ব্যাগ</span>

            </a>

            <a href="{{ route('user.settings') }}"
               @click="sidebarOpen=false"
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('user.settings') ? 'bg-green-100 font-semibold' : 'hover:bg-green-100' }}">

                ⚙️ <span>সেটিংস</span>

            </a>
      @elseif (Auth::user()->role->name == 'admin')
         <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('admin.dashboard') ? 'bg-green-100 font-semibold text-green-700' : 'hover:bg-green-100' }}">
                <i class="fa-solid fa-gauge-high w-5 text-green-600"></i>
                <span>ড্যাশবোর্ড</span>
            </a>

            <a href="{{ route('admin.manage_bazar') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('admin.manage_bazar') ? 'bg-green-100 font-semibold text-green-700' : 'hover:bg-green-100' }}">
                <i class="fa-solid fa-store w-5 text-green-600"></i>
                <span>ম্যানেজ বাজার তালিকা</span>
            </a>

            <a href="{{ route('admin.manage_products') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('admin.manage_products') ? 'bg-green-100 font-semibold text-green-700' : 'hover:bg-green-100' }}">
                <i class="fa-solid fa-boxes-stacked w-5 text-green-600"></i>
                <span>পণ্যের তালিকা</span>
            </a>

            <a href="{{ route('admin.package_management') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('admin.package_management') ? 'bg-green-100 font-semibold text-green-700' : 'hover:bg-green-100' }}">
                <i class="fa-solid fa-clipboard-list w-5 text-green-600"></i>
                <span>প্যাকেজ ম্যানেজমেন্ট</span>
            </a>

            <a href="{{ route('admin.all_orders') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('admin.all_orders') ? 'bg-green-100 font-semibold text-green-700' : 'hover:bg-green-100' }}">
                <i class="fa-solid fa-clipboard-list w-5 text-green-600"></i>
                <span>ম্যানেজ অর্ডারস</span>
            </a>

            <a href="{{ route('admin.rider_list') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('admin.rider_list') ? 'bg-green-100 font-semibold text-green-700' : 'hover:bg-green-100' }}">
                <i class="fa-solid fa-motorcycle w-5 text-green-600"></i>
                <span>রাইডার'স তালিকা</span>
            </a>

            <a href="{{ route('admin.customer_list') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('admin.customer_list') ? 'bg-green-100 font-semibold text-green-700' : 'hover:bg-green-100' }}">
                <i class="fa-solid fa-users w-5 text-green-600"></i>
                <span>কাস্টমার তালিকা</span>
            </a>

            <a href="{{ route('admin.staff_list') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('admin.staff_list') ? 'bg-green-100 font-semibold text-green-700' : 'hover:bg-green-100' }}">
                <i class="fa-solid fa-user-tie w-5 text-green-600"></i>
                <span>স্টাফ তালিকা</span>
            </a>

            <a href="{{ route('admin.delivery_charge_rules.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('admin.settings') ? 'bg-green-100 font-semibold text-green-700' : 'hover:bg-green-100' }}">
                <i class="fa-solid fa-gear w-5 text-green-600"></i>
                <span>ডেলিভারি চার্জ সেটিংস</span>
            </a>
            <a href="{{ route('admin.settings') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('admin.settings') ? 'bg-green-100 font-semibold text-green-700' : 'hover:bg-green-100' }}">
                <i class="fa-solid fa-gear w-5 text-green-600"></i>
                <span>সেটিংস</span>
            </a>
      @else
        
  <a href="{{ route('rider.dashboard') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('rider.dashboard') ? 'bg-green-100 font-semibold' : 'hover:bg-green-100' }}">
                🏠 <span>ড্যাশবোর্ড</span>
            </a>

            <a href="{{ route('rider.products') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('rider.products') ? 'bg-green-100 font-semibold' : 'hover:bg-green-100' }}">
                📦 <span>পণ্যের তালিকা </span>
            </a>

            <a href="{{ route('rider.orders') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('rider.orders') ? 'bg-green-100 font-semibold' : 'hover:bg-green-100' }}">
                📦 <span>আমার অর্ডারসমূহ</span>
            </a>


            <a href="{{ route('rider.settings') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('rider.settings') ? 'bg-green-100 font-semibold' : 'hover:bg-green-100' }}">
                ⚙️ <span>সেটিংস</span>
            </a>

      @endif
            <form method="POST"
                  action="{{ route('logout') }}">

                @csrf

                <button
                    type="submit"
                    class="flex items-center gap-3 px-3 py-2 w-full rounded-lg hover:bg-red-100 text-red-600">

                    🔓 <span>লগআউট</span>

                </button>

            </form>

        </nav>

    </div>

</aside>