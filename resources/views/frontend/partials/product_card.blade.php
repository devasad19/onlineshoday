    @forelse($products as $product)
      <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-4 relative group">
        <img src="{{ url('uploads/products/'.$product->image) }}" 
             alt="{{ $product->name }}" 
             class="rounded-lg w-full h-44 object-cover group-hover:scale-105 transition duration-300">
        <button class="absolute top-3 right-3 bg-white p-2 rounded-full shadow hover:text-red-500">
          ❤️
        </button>
        <div class="mt-4">
          <h4 class="font-bold text-lg">{{ $product->name }}</h4>
          <p class="text-green-600 font-semibold">৳{{ $product->price }} / {{ $product->unit }}</p>
          <!-- <p class="text-sm text-gray-500">
            বিতরণকারী: 
            {{ optional($product->rider)->name ?? 'N/A' }}
          </p> -->
          <p class="text-sm text-gray-500 mb-3">
            বাজার: 
            {{ optional($product->bazar)->name ?? 'N/A' }}
          </p>
          <a href="{{ route('home.product.details', $product->id) }}" 
             class="block bg-green-600 text-white w-full py-2 rounded-lg hover:bg-green-700 transition text-center">
            বিস্তারিত দেখুন
          </a>
        </div>
      </div>
    @empty
      <div class="col-span-4 text-center text-gray-500 py-10">
        🚫 কোনো পণ্য পাওয়া যায়নি।
      </div>
    @endforelse