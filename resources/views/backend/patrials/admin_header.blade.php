
<header class="sticky top-0 z-40">

    <!-- =========================
        MOBILE HEADER
    ========================== -->
    <div class="bg-white shadow md:hidden">

        <div class="flex items-center justify-between h-16 px-4">

            <!-- Menu -->


            <!-- Logo -->

            <a href="{{ route('front_home') }}">

                <img
                    src="{{ url('public/default/new-logo.png') }}"
                    class="h-11"
                    alt="">

            </a>

            <!-- User -->

          
            <button
                @click="sidebarOpen=true"
                class="p-1">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-8 h-8"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>

                </svg>

            </button>
        </div>

    </div>

    <!-- =========================
        DESKTOP HEADER
    ========================== -->

    <div class="hidden md:block bg-white shadow">

        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-3">

            <h2 class="text-2xl font-bold text-green-600">

                eBazar Dashboard

            </h2>

            <div class="flex items-center gap-4">

                <span class="text-gray-700">

                    স্বাগতম,
                    {{ Auth::user()->name }}

                </span>

                <form method="POST"
                      action="{{ route('logout') }}">

                    @csrf

                    <button
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">

                        লগআউট

                    </button>

                </form>

            </div>

        </div>

    </div>


<!-- ===========================
    Mobile Overlay
=========================== -->
<div
    x-show="sidebarOpen"
    x-cloak
    x-transition.opacity
    @click="sidebarOpen=false"
    class="fixed inset-0 bg-black/50 z-40 md:hidden">
</div>



</header>