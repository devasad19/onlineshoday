            <div class="w-full overflow-x-auto">
                <table class="min-w-[900px] border-collapse whitespace-nowrap">

<thead class="bg-green-600 text-white">

<tr>

<th class="px-4 py-3 text-left">#</th>
<th class="px-4 py-3 text-left">পণ্যের নাম</th>
<th class="px-4 py-3 text-left">ছবি</th>
<th class="px-4 py-3 text-left">বাজার</th>
<th class="px-4 py-3 text-left">বিভাগ</th>
<th class="px-4 py-3 text-left">মূল্য</th>
<th class="px-4 py-3 text-left">স্ট্যাটাস</th>
<th class="px-4 py-3 text-center">অপশন</th>
<th class="px-4 py-3 text-center">---</th>
<th class="px-4 py-3 text-left">প্রাইস আপডেট</th>

</tr>

</thead>

<tbody class="divide-y divide-gray-200">

@forelse($products as $key=>$product)

<tr>
<td class="px-4 py-3">{{ $products->firstItem()+$key }}</td>

<td class="px-4 py-3">{{ $product->name }}</td>

<td class="px-4 py-3">
    <img src="{{ asset('uploads/products/'.$product->image) }}"
         class="w-20 h-20 rounded border object-cover">
</td>

<td class="px-4 py-3">{{ $product->bazar->name ?? 'N/A' }}</td>

<td class="px-4 py-3">{{ $product->category->name ?? 'N/A' }}</td>

<td class="px-4 py-3" id="price-text-{{ $product->id }}">
    ৳{{ number_format($product->price,2) }}
</td>

<td>

@if($product->status=='active')

<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
সক্রিয়
</span>

@else

<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">
নিষ্ক্রিয়
</span>

@endif

</td>

<td class="text-center">

<button onclick="viewProduct({{ $product->id }})">👁️</button>

<a href="{{ route('admin.products.edit',$product->id) }}"
   class="text-yellow-600">
    ✏️
</a>

<button onclick="confirmDelete({{ $product->id }})">🗑️</button>

</td>
<td>---</td>
 
<td class="min-w-[170px]">

    <div class="flex items-center gap-2">

        <span>৳</span>

        <input
            type="number"
            step="0.01"
            value="{{ $product->price }}"
            class="price-input border rounded px-2 py-1 w-24"
            data-id="{{ $product->id }}">

        <span
            id="price-status-{{ $product->id }}"
            class="text-xs">
        </span>
<span
    id="updated-badge-{{ $product->id }}"
    class="text-xs {{ $product->price_updated_at?->isToday() ? 'text-green-600' : 'text-gray-400' }}">
    
    {{ $product->price_updated_at?->isToday() ? 'Updated' : 'Not Today' }}

</span>
    </div>

</td>
</tr>

@empty

<tr>

<td colspan="6" class="text-center py-5">

কোনো পণ্য পাওয়া যায়নি।

</td>

</tr>

@endforelse

</tbody>

</table>

<div class="mt-5">

{{ $products->links() }}

</div>

</div>