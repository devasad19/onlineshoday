@extends('apps.front_master')
@section('content')

<!-- 🧭 Breadcrumb -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 py-4 sm:py-6">
  <nav class="text-xs sm:text-sm text-gray-500 mb-2 sm:mb-4">
    <a href="{{ url('/') }}" class="hover:text-green-600">হোম</a> /
    <a href="#" class="hover:text-green-600">পণ্যসমূহ</a> /
    <span class="text-green-700 font-semibold">{{ $product->name }}</span>
  </nav>
</section>

<!-- 🛍️ Product Details -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-4">
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">

    <!-- 🧾 Product Details Left -->
    <div class="md:col-span-2 bg-white rounded-2xl shadow p-4 sm:p-6">
      <div class="flex flex-col md:flex-row gap-4 sm:gap-6">

        <!-- 📸 Product Image -->
        <div class="md:w-1/2 flex justify-center mb-4 md:mb-0">
          <img src="{{ url('uploads/products/'.$product->image) }}"
               alt="{{ $product->name }}"
               class="rounded-xl w-full sm:w-72 h-56 sm:h-60 object-cover shadow">
        </div>

        <!-- 🧾 Product Info -->
        <div class="md:w-1/2">
          <h2 class="text-xl sm:text-3xl font-bold text-green-700 mb-2">{{ $product->name }}</h2>
          <p class="text-sm sm:text-lg text-gray-600 mb-3">{{ $product->short_description ?? 'বিবরণ নেই' }}</p>

          <div class="mb-4">
            <p class="text-lg sm:text-2xl font-bold text-green-600 mb-1">৳{{ bnNum($product->price) }} / {{ $product->unit }}</p>
            <p class="text-xs sm:text-sm text-gray-500">বিতরণকারী:
              <span class="font-semibold text-gray-700">ফ্রি আছে, অর্ডার করুন, ইন শা আল্লাহ্‌।</span>
            </p>
            <p class="text-xs sm:text-sm text-gray-500">বাজার:
              <span class="font-semibold text-gray-700">{{ optional($product->bazar)->name ?? 'N/A' }}</span>
            </p>
            <p class="text-xs sm:text-sm text-gray-500">*নোট:
              <span class="font-semibold text-red-600">
                পণ্যের দাম ৫ থেকে ৭ টাকা কম/বেশি হতে পারে।
              </span>
            </p>
          </div>

          <!-- 🛒 Quantity & Add to Cart -->
          <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
            <div class="flex items-center">
              <button type="button" class="bg-indigo-500 text-white hover:bg-indigo-600 px-3 sm:px-4 py-1 sm:py-2 rounded-l-full font-bold" onclick="decreaseQty(this)">-</button>
              <input type="number" value="1" min="1" class="w-12 sm:w-16 text-center border-t border-b border-indigo-300 py-1 sm:py-2 focus:outline-none" />
              <button type="button" class="bg-indigo-500 text-white hover:bg-indigo-600 px-3 sm:px-4 py-1 sm:py-2 rounded-r-full font-bold" onclick="increaseQty(this)">+</button>
            </div>

            <button class="addToCartBtn bg-green-600 text-white px-4 sm:px-6 py-2 text-xs sm:text-sm rounded-lg hover:bg-green-700 transition"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->price }}"
                    data-image="{{ url('uploads/products/'.$product->image) }}">
              🛒 ব্যাগে যোগ করুন
            </button>
          </div>
        </div>
      </div>

      <!-- 🔎 Description -->
      <div class="border-t pt-4 sm:pt-5 mt-4 sm:mt-6 text-gray-700">
        <h4 class="font-semibold mb-2 text-green-700 text-sm sm:text-base">পণ্যের বিস্তারিত বিবরণ:</h4>
        <p class="text-xs sm:text-sm leading-relaxed">
          {{ $product->description ?? 'এই পণ্যের বিস্তারিত বিবরণ পাওয়া যায়নি।' }}
        </p>
      </div>
    </div>

    <!-- 📦 Other Products -->
    <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
      <h3 class="text-lg sm:text-xl font-bold text-green-700 mb-3 sm:mb-4 flex items-center gap-2">🛒 অন্যান্য পণ্য</h3>

      @forelse($othersProducts as $item)
        <div class="flex items-center gap-3 border border-gray-100 rounded-xl p-3 hover:shadow-md transition bg-white mb-3">
          <img src="{{ url('uploads/products/'.$item->image) }}" alt="{{ $item->name }}" class="w-16 sm:w-20 h-16 sm:h-20 rounded-lg object-cover flex-shrink-0">
          <div class="flex flex-col justify-between w-full">
            <div>
              <h4 class="font-semibold text-gray-800 text-sm sm:text-lg">{{ $item->name }}</h4>
              <p class="text-green-600 font-medium text-xs sm:text-sm">৳{{ bnNum($item->price) }} / {{ $item->unit }}</p>
              <p class="text-xs text-gray-500">বাজার: {{ optional($item->bazar)->name ?? 'N/A' }}</p>
            </div>
            <div class="flex justify-between items-center mt-2">
              <button class="addToCartBtn bg-indigo-600 hover:bg-indigo-700 text-sm sm:text-lg sm:text-sm text-white py-1 px-2 sm:px-3 rounded-lg"
                      data-id="{{ $item->id }}"
                      data-name="{{ $item->name }}"
                      data-price="{{ $item->price }}"
                      data-image="{{ url('uploads/products/'.$item->image) }}">
                🛒 যোগ করুন
              </button>
              <a href="{{ route('home.product.details', $item->id) }}" class="text-sm sm:text-lg sm:text-sm bg-green-600 text-white py-1 px-2 rounded-lg hover:bg-green-700 transition text-center">
                বিস্তারিত
              </a>
            </div>
          </div>
        </div>
      @empty
        <p class="text-gray-500 text-center text-sm">এই বাজারে অন্য কোনো পণ্য নেই।</p>
      @endforelse
    </div>
  </div>
</section>

<!-- 🔄 Related Products -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 sm:pb-16">
  <div class="flex justify-between items-center mb-4 sm:mb-6">
    <h3 class="text-lg sm:text-2xl font-bold text-green-700">🔄 সম্পর্কিত পণ্য</h3>
    <a href="#" class="text-xs sm:text-sm text-green-600 hover:underline">সব দেখুন →</a>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
    @forelse($relatedProducts as $product)
      <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-3 sm:p-4 relative group">
        <img src="{{ $product->image ? url('uploads/products/'.$product->image) : url('public/default/img.jpg') }}" 
            alt="{{ $product->name }}" 
            class="rounded-lg w-full h-36 sm:h-44 object-cover group-hover:scale-105 transition duration-300">
        <button class="absolute top-2 right-2 bg-white p-1 sm:p-2 rounded-full shadow hover:text-red-500">❤️</button>
        <div class="mt-3 sm:mt-4">
          <h4 class="font-bold text-sm sm:text-lg">{{ $product->name }}</h4>
          <p class="text-green-600 font-semibold text-sm sm:text-lg sm:text-sm">৳{{ bnNum($product->price) }} / {{ $product->unit }}</p>
          <p class="text-sm sm:text-lg sm:text-sm text-gray-500">বাজার: {{ optional($product->bazar)->name ?? 'N/A' }}</p>
          <div class="flex justify-between items-center mt-2">
            <button class="addToCartBtn bg-indigo-600 hover:bg-indigo-700 text-sm sm:text-lg sm:text-sm text-white py-1 px-2 rounded-lg"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->price }}"
                    data-image="{{ url('uploads/products/'.$product->image) }}">
              🛒 যোগ করুন
            </button>
            <a href="{{ route('home.product.details', $product->id) }}" class="text-sm sm:text-lg sm:text-sm bg-green-600 text-white py-1 px-2 rounded-lg hover:bg-green-700 transition text-center">
              বিস্তারিত
            </a>
          </div>
        </div>
      </div>
    @empty
      <div class="col-span-4 text-center text-gray-500 py-8 sm:py-10 text-sm sm:text-base">
        🚫 কোনো পণ্য পাওয়া যায়নি।
      </div>
    @endforelse
  </div>
</section>

@endsection
