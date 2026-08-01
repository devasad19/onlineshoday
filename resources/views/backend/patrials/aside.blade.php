<aside class="w-64 bg-white shadow-md hidden md:flex flex-col">
    <div class="p-6">
            @php
                if(Auth::user()->role->name == 'user'){
                    $role = 'ইউজার';
                }elseif (Auth::user()->role->name == 'rider'){
                    $role = 'রাইডার';
                }elseif(Auth::user()->role->name == 'admin') {
                    $role = 'এডমিন';
                }
            @endphp

        <h2 class="text-2xl font-bold text-green-600 mb-6">{{$role ?? ''}} প্যানেল</h2>
        <div class="flex items-center gap-3 mb-6">
            <img src="{{ auth()->user()->photo ? url('uploads/users/' . auth()->user()->photo) : url('public/default/user.jpg') }}" alt="User" class="w-12 h-12 rounded-full object-cover">
            <div>
                <h4 class="font-semibold text-gray-800">{{ Auth::user()->name ?? 'নাম পাওয়া যায় নাই' }}</h4>
                <p class="text-xs text-gray-500">
                    {{ $role?? '' }}
                </p>
            </div>
        </div>

        <nav class="space-y-2">
            <a href="{{ route('user.dashboard') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('user.dashboard') ? 'bg-green-100 font-semibold' : 'hover:bg-green-100' }}">
                🏠 <span>ড্যাশবোর্ড</span>
            </a>

            <a href="{{ route('user.my_orders') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('user.my_orders') ? 'bg-green-100 font-semibold' : 'hover:bg-green-100' }}">
                📦 <span>আমার অর্ডার</span>
            </a>

            <a href="{{ route('user.my_cart') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('user.my_cart') ? 'bg-green-100 font-semibold' : 'hover:bg-green-100' }}">
                🛒 <span>আমার বাজার ব্যাগ</span>
            </a>

            <a href="{{ route('user.settings') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs('user.settings') ? 'bg-green-100 font-semibold' : 'hover:bg-green-100' }}">
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
