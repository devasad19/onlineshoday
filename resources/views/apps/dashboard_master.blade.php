<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Shoday - Dashboard</title>
      <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="flex flex-col min-h-screen bg-gray-50 text-gray-800">

 
<div x-data="{ sidebarOpen:false }" class="min-w-0 ">

        @include('backend.patrials.admin_header')

 
  <div class="flex flex-1 min-w-0 overflow-hidden">
    <!-- 🟩 Sidebar -->
        @include('backend.patrials.admin_aside')

    <!-- 🟦 Main Content -->
    <main class="flex-1 min-w-0 overflow-x-hidden p-2 md:p-6">

<!-- 📱 Mobile App-Style Bottom Navbar -->
<!-- 🌈 Modern Colorful Mobile Bottom Navbar -->
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-xl z-50 md:hidden">
  <div class="flex justify-around items-center py-2">

    <!-- 🏠 হোম -->
    <a href="{{ route('front_home') }}" 
       class="flex flex-col items-center group transition-all duration-300">
      <div class="w-9 h-9 flex items-center justify-center rounded-full 
                  {{ request()->routeIs('front_home') ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-600' }}
                  group-hover:bg-green-100 group-hover:text-green-600">
        🏡
      </div>
      <span class="text-xs mt-1 font-medium 
                   {{ request()->routeIs('front_home') ? 'text-green-600' : 'text-gray-700' }}">
        হোম
      </span>
    </a>

    <!-- 🛍️ বাজার -->
    <a href="{{ route('our.bazars') }}" 
       class="flex flex-col items-center group transition-all duration-300">
      <div class="w-9 h-9 flex items-center justify-center rounded-full 
                  {{ request()->routeIs('our.bazars') ? 'bg-pink-100 text-pink-600' : 'bg-gray-100 text-gray-600' }}
                  group-hover:bg-pink-100 group-hover:text-pink-600">
        🛍️
      </div>
      <span class="text-xs mt-1 font-medium 
                   {{ request()->routeIs('our.bazars') ? 'text-pink-600' : 'text-gray-700' }}">
        বাজার
      </span>
    </a>

    <!-- 🎒 ব্যাগ (Middle, Bigger Icon) -->
<!-- 🎒 ব্যাগ (Middle, Bigger Icon with SVG Bag) -->
<button id="cartButtonBottom" 
        class="relative -mt-8 flex flex-col items-center group transition-all duration-300">
  <div class="w-16 h-16 flex items-center justify-center rounded-full bg-white text-white border-4 border-green-200 shadow-lg group-hover:bg-green-200">
    <!-- 🛍️ SVG Bag Icon -->
            <img class="w-16 h-16 p-3 items-center group transition-all" src="{{ url('public/default/bag.svg') }}" alt="">
  </div>
  <span class="text-xs mt-1 text-green-600 font-semibold">ব্যাগ</span>
  <span id="cartCountBottom" 
        class="absolute top-0 right-4 bg-red-500 text-white text-[13px] font-bold w-5 h-5 flex items-center justify-center rounded-full">3</span>
</button>



    <!-- 📜 নীতিমালা -->
    <a href="{{ route('our.policy') }}" 
       class="flex flex-col items-center group transition-all duration-300">
      <div class="w-9 h-9 flex items-center justify-center rounded-full 
                  {{ request()->routeIs('our.policy') ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600' }}
                  group-hover:bg-blue-100 group-hover:text-blue-600">
        📜
      </div>
      <span class="text-xs mt-1 font-medium 
                   {{ request()->routeIs('our.policy') ? 'text-blue-600' : 'text-gray-700' }}">
        নীতিমালা
      </span>
    </a>

    <!-- ☎️ যোগাযোগ -->
    <a href="{{ route('contact_us') }}" 
       class="flex flex-col items-center group transition-all duration-300">
      <div class="w-9 h-9 flex items-center justify-center rounded-full 
                  {{ request()->routeIs('contact_us') ? 'bg-yellow-100 text-yellow-600' : 'bg-gray-100 text-gray-600' }}
                  group-hover:bg-yellow-100 group-hover:text-yellow-600">
        ☎️
      </div>
      <span class="text-xs mt-1 font-medium 
                   {{ request()->routeIs('contact_us') ? 'text-yellow-600' : 'text-gray-700' }}">
        যোগাযোগ
      </span>
    </a>

  </div>
</nav>





      @yield('content')
    </main>
  </div>
 </div>

  <!-- 🌱 Footer -->
  <footer class="bg-gray-900 text-gray-300 text-center py-4 mt-auto">
    <p>© ২০২৫ Online Shoday.com | আপনার বাজার, আপনার ঘরে 🏡</p>
  </footer>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // 🔹 Common Swal Toast helper
    function showToast(icon, title, message) {
        Swal.fire({
            icon: icon,
            title: title,
            text: message,
            timer: 2000,
            showConfirmButton: false,
            position: 'top-end',
            toast: true
        });
      }

  function swalConfirm(message, callback) {
      Swal.fire({
          title: 'আপনি কি নিশ্চিত?',
          text: message,
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'হ্যাঁ',
          cancelButtonText: 'না',
          confirmButtonColor: '#16a34a',
          cancelButtonColor: '#d33'
      }).then((result) => {
          if (result.isConfirmed && typeof callback === "function") {
              callback();
          }
      });
  }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });

</script>

  @yield('scripts')

</body>
</html>
