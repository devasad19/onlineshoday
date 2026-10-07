<aside class="w-64 bg-white shadow-md hidden md:flex flex-col">
    <div class="p-6">
        <h2 class="text-2xl font-bold text-green-600 mb-6">রাইডার প্যানেল</h2>
        <div class="flex items-center gap-3 mb-6">
            <img src="{{ url('uploads/riders/' . auth()->user()->photo) ?? url('public/default/user.jpg') }}" alt="User" class="w-12 h-12 rounded-full object-cover">
            <div>
                <h4 class="font-semibold text-gray-800">{{ Auth::user()->name ?? 'নাম পাওয়া যায় নাই' }}</h4>
                <p class="text-xs text-gray-500">রাইডার</p>
            </div>
        </div>

        <nav class="space-y-2">
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


        <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="flex items-center gap-3 px-3 py-2 w-full  rounded-lg hover:bg-red-100 transition text-red-600">
                  🔓 <span>লগআউট</span>
              </button>
          </form>

        </nav>
    </div>
</aside>
