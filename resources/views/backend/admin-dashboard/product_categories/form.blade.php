@php
    $category = $category ?? null;
@endphp

{{-- Category Name --}}
<div>
    <label class="block font-medium mb-2">
        ক্যাটাগরির নাম *
    </label>

    <input type="text"
           name="name"
           value="{{ old('name', $category->name ?? '') }}"
           class="w-full border border-gray-300 rounded-lg p-3 focus:border-green-500 focus:ring-2 focus:ring-green-100"
           placeholder="যেমন: শাকসবজি"
           required>

    @error('name')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Slug --}}


{{-- Description --}}
<div>
    <label class="block font-medium mb-2">
        ক্যাটাগরির বিবরণ
    </label>

    <textarea name="description"
              rows="4"
              class="w-full border border-gray-300 rounded-lg p-3"
              placeholder="ক্যাটাগরি সম্পর্কে সংক্ষিপ্ত বিবরণ">{{ old('description', $category->description ?? '') }}</textarea>

    @error('description')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Image --}}
<div>
    <label class="block font-medium mb-2">
        ক্যাটাগরির ছবি
    </label>

    @if($category?->image)
        <div class="mb-3">
            <img src="{{ asset('uploads/products-categories/'.$category->image) }}"
                 class="w-24 h-24 rounded-lg object-cover">
        </div>
    @endif

    <input type="file"
           name="image"
           accept="image/jpeg,image/png,image/webp"
           class="w-full border border-gray-300 rounded-lg p-3">

    @error('image')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror

    <p class="text-xs text-gray-500 mt-1">
        JPG, JPEG, PNG, WEBP; সর্বোচ্চ ২ MB।
    </p>
</div>

{{-- Sort Order --}}
<div>
    <label class="block font-medium mb-2">
        প্রদর্শনের ক্রম
    </label>

    <input type="number"
           name="sort_order"
           min="0"
           value="{{ old('sort_order', $category->sort_order ?? 0) }}"
           class="w-full border border-gray-300 rounded-lg p-3">

    @error('sort_order')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Status --}}
  

<div>
    <label class="block font-medium mb-2">ক্যাটাগরি স্ট্যাটাস *</label>

    <select name="status"
           id="category_status"
        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500">

        <option value="Active")>
            Active
        </option>

        <option value="Deactive")>
            Deactive
        </option>

    </select>
</div>

