@extends('apps.dashboard_master')
@section('title', 'আমার পণ্য ব্যবস্থাপনা')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <!-- 🟢 Sidebar -->
    <!-- @include('backend.patrials.rider_aside') -->
 
    <!-- 🟡 Main Content Area -->
    <div class="flex-1 flex flex-col p-4">
        <!-- Top Bar -->
        @include('backend.patrials.top_bar')

    <div class="bg-white shadow rounded-lg p-6">

        
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
 
<h1 class="text-2xl font-bold text-gray-700">
    🛒 ই-কমার্স পণ্য 
</h1>

<a
    href="{{ route('rider.products') }}"
    class="inline-flex items-center justify-center gap-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow-sm transition"
>
    🧩 নিত্যপ্রয়োজনীয় পণ্য তালিকা
</a>
 

</div>

 

        {{-- =========================================================
            CUSTOM PRODUCTS
        ========================================================== --}}

        <div class="bg-white border border-orange-200 shadow-sm rounded-xl p-5">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">

                <div>

                    <h2 class="text-xl font-semibold text-orange-700">
                        🧩 Custom Products
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        কাস্টম পণ্যগুলোর বিস্তারিত তথ্য
                    </p>

                </div>


                <div class="text-sm text-gray-500">
                    মোট {{ $custom_products->total() }} টি কাস্টম পণ্য
                </div>

            </div>


            <div class="overflow-x-auto">

                <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">

                    <thead class="bg-orange-50 text-gray-700">

                        <tr>
                            <th class="p-3 text-left whitespace-nowrap">#</th>
                            <th class="p-3 text-left whitespace-nowrap">পণ্য</th>
                            <th class="p-3 text-left whitespace-nowrap">ক্যাটাগরি</th>
                            <th class="p-3 text-center whitespace-nowrap">ইউনিট</th>
                            <th class="p-3 text-right whitespace-nowrap">মূল দাম</th>
                            <th class="p-3 text-center whitespace-nowrap">ডিসকাউন্ট</th>
                            <th class="p-3 text-center whitespace-nowrap">স্ট্যাটাস</th>
                            <th class="p-3 text-center whitespace-nowrap">অ্যাকশন</th>
                        </tr>

                    </thead>


                    <tbody class="bg-white">

                        @forelse($custom_products as $key => $product)

                            @php
                                $discount = (float) ($product->discount ?? 0);
                                $originalPrice = (float) ($product->price ?? 0);

                                $discountPrice = $discount > 0
                                    ? $originalPrice - (($originalPrice * $discount) / 100)
                                    : $originalPrice;
                            @endphp


                            <tr class="border-t hover:bg-orange-50 transition">

                                {{-- Serial --}}
                                <td class="p-3 align-top">
                                    {{ $custom_products->firstItem() + $key }}
                                </td>


                                {{-- Product --}}
                                <td class="p-3 align-top">

                                    <div class="flex items-center gap-3 min-w-[230px]">

                                        @if($product->image)

                                            <img
                                                src="{{ url('uploads/products/' . $product->image) }}"
                                                alt="{{ $product->name }}"
                                                class="w-14 h-14 rounded-lg object-cover border border-gray-200"
                                            >

                                        @else

                                            <div class="w-14 h-14 rounded-lg bg-orange-50 border border-orange-200 flex items-center justify-center text-orange-400 text-xl">
                                                🧩
                                            </div>

                                        @endif


                                        <div>

                                            <div class="font-semibold text-gray-800">
                                                {{ $product->name }}
                                            </div>

                                            <span class="inline-flex mt-1 px-2 py-0.5 rounded-full bg-orange-100 text-orange-700 text-xs font-medium">
                                                Custom Product
                                            </span>

                                            @if(!empty($product->description))

                                                <div class="text-xs text-gray-500 mt-1 max-w-xs line-clamp-2">
                                                    {{ $product->description }}
                                                </div>

                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- Category --}}
                                <td class="p-3 align-top">

                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-sm">

                                        {{ $product->category->name ?? 'ক্যাটাগরি নেই' }}

                                    </span>

                                </td>


                                {{-- Unit --}}
                                <td class="p-3 text-center align-top">

                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-gray-100 text-gray-700 text-sm">

                                        {{ $product->unit ?: '—' }}

                                    </span>

                                </td>


                                {{-- Price --}}
                                <td class="p-3 text-right align-top whitespace-nowrap">

                                    @if($discount > 0)

                                        <div class="text-sm text-gray-400 line-through">
                                            {{ number_format($originalPrice, 2) }} ৳
                                        </div>

                                        <div class="font-bold text-gray-800">
                                            {{ number_format($discountPrice, 2) }} ৳
                                        </div>

                                    @else

                                        <div class="font-bold text-gray-800">
                                            {{ number_format($originalPrice, 2) }} ৳
                                        </div>

                                    @endif

                                </td>


                                {{-- Discount --}}
                                <td class="p-3 text-center align-top">

                                    @if($discount > 0)

                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-orange-100 text-orange-700 text-sm font-semibold">
                                            {{ number_format($discount, 0) }}%
                                        </span>

                                    @else

                                        <span class="text-gray-400 text-sm">
                                            নেই
                                        </span>

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td class="p-3 text-center align-top whitespace-nowrap">

                                    @if($product->available)

                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                                            ✓ Available
                                        </span>

                                    @else

                                        <!-- <span class="inline-flex px-2.5 py-1 rounded-full bg-red-100 text-red-700 text-sm font-semibold">
                                            ✕ Unavailable
                                        </span> -->

                                    @endif


                                    <div class="mt-1">

                                        @if($product->status)

                                            <span class="text-xs text-green-600">
                                                Active
                                            </span>

                                        @else

                                            <span class="text-xs text-red-600">
                                                Inactive
                                            </span>

                                        @endif

                                    </div>

                                </td>


                                {{-- Details --}}
                                <td class="p-3 text-center align-top">

                                    <a
                                        href="{{ route('home.product.details', $product->id) }}"
                                        class="inline-block bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition"
                                    >
                                        বিস্তারিত
                                    </a>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="8" class="p-8 text-center text-gray-500">
                                    কোনো Custom Product পাওয়া যায়নি।
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Custom Product Pagination --}}
            @if($custom_products->hasPages())

                <div class="mt-6">
                    {{ $custom_products->appends(request()->except('custom_products_page'))->links() }}
                </div>

            @endif

        </div>
        

    </div>

    </div>
</div>
@endsection

@section('scripts')
 
@endsection
