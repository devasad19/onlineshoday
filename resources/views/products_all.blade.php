@extends('apps.front_master')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">🛍️ সব পণ্য দেখুন</h2>

        <!-- 🔍 Filter Section -->
        <form method="GET" action="{{ route('products.filter') }}" class="bg-white p-6 rounded-2xl shadow mb-8">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <input type="text" name="keyword" value="{{ $keyword}}" placeholder="🔎 পণ্য সার্চ করুন"
                    class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none">

                <select name="category_id" class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                    <option value="">ক্যাটাগরি</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                <select name="bazar_id" class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                    <option value="">বাজার</option>
                    @foreach($bazars as $bz)
                        <option value="{{ $bz->id }}" {{ $bazar_id == $bz->id ? 'selected' : '' }}>
                            {{ $bz->name }}
                        </option>
                    @endforeach
                </select>
  
                
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg font-semibold transition">
                    🔍 ফিল্টার করুন
                </button>
            </div>
            <div class="mt-4 flex justify-end">
            </div>
        </form>

        <!-- 🧺 Product List -->
        @if($products->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
      <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-4 relative group">
        <img src="{{ url('uploads/products/'.$product->image) }}" 
             alt="{{ $product->name }}" 
             class="rounded-lg w-full h-44 object-cover group-hover:scale-105 transition duration-300">
        <button class="absolute top-3 right-3 bg-white p-2 rounded-full shadow hover:text-red-500">
          ❤️
        </button>
        <div class="mt-4">
           <a href="{{ route('home.product.details', $product->id) }}"  class="font-bold text-lg">{{ $product->name }}</a>
          <p class="text-green-600 font-semibold">৳{{ bnNum($product->price) }} / {{ $product->unit }}</p>
          <!-- <p class="text-sm text-gray-500">
            বিতরণকারী: 
            {{ optional($product->rider)->name ?? 'N/A' }}
          </p> -->
          <p class="text-sm text-gray-500 mb-3">
            বাজার:  {{ optional($product->bazar)->name ?? 'N/A' }}
          </p>
          <div class="flex justify-between items-center">
              <button class="addToCartBtn inline-block bg-indigo-600 hover:bg-indigo-700 text-sm text-white py-2 px-3 rounded-lg text-sm"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->price }}"
                    data-image="{{ url('uploads/products/'.$product->image) }}">
              🛒 ব্যাগে যোগ করুন
            </button>
            <a href="{{ route('home.product.details', $product->id) }}"  class="inline-block text-sm bg-green-600 text-white py-2 px-3 rounded-lg hover:bg-green-700 transition text-center">
              বিস্তারিত </a>
        </div>
        </div>
      </div>
                @endforeach
            </div>

            <div class="mt-8">
                 
            </div>
        @else
            <p class="text-center text-gray-600 text-lg mt-10">❌ কোনো পণ্য পাওয়া যায়নি।</p>
        @endif
    </div>
</div>
@endsection
