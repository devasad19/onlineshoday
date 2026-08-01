        <!-- Top Bar -->
        <header class="bg-white shadow-md py-4 px-6 flex justify-between items-center mb-5 hidden md:flex">
            <h1 class="text-xl font-bold text-gray-700">ড্যাশবোর্ড</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('front_home') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-sm text-white py-2 px-3 rounded-lg text-sm">হোম পেজ</a>
                <span class="text-gray-600 text-sm hidden sm:block">{{ Auth::user()->phone ?? 'পাওয়া যায় নাই' }}</span>
                <img src="{{ auth()->user()->photo ? url('uploads/users/' . auth()->user()->photo) : url('public/default/user.jpg') }}" alt="User" class="w-10 h-10 rounded-full object-cover">
            </div>
        </header>