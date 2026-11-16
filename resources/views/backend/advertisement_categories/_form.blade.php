
@php
    $isEdit = isset($category);
@endphp

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 sm:p-7">

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

        {{-- Category Name --}}
        <div class="sm:col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                ক্যাটাগরির নাম <span class="text-red-500">*</span>
            </label>

            <input type="text"
                   name="name"
                   value="{{ old('name', $category->name ?? '') }}"
                   placeholder="যেমন: নাগরিক সেবা"
                   required
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">

            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Icon --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                ক্যাটাগরি আইকন
            </label>

            <input type="text"
                   name="icon"
                   value="{{ old('icon', $category->icon ?? '') }}"
                   placeholder="যেমন: 🔧"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">

            <p class="text-xs text-gray-400 mt-1">
                Emoji ব্যবহার করতে পারেন।
            </p>

            @error('icon')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Sort Order --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                প্রদর্শনের ক্রম
            </label>

            <input type="number"
                   name="sort_order"
                   min="0"
                   value="{{ old('sort_order', $category->sort_order ?? 0) }}"
                   placeholder="0"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">

            <p class="text-xs text-gray-400 mt-1">
                ছোট সংখ্যা আগে দেখাবে।
            </p>
        </div>

        {{-- Status --}}
        <div class="sm:col-span-2">
            <label class="flex items-center gap-3 cursor-pointer">

                <input type="checkbox"
                       name="is_active"
                       value="1"
                       {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}
                       class="w-5 h-5 accent-green-600">

                <span class="text-sm font-semibold text-gray-700">
                    ক্যাটাগরি Active রাখুন
                </span>

            </label>
        </div>

    </div>

    <div class="flex flex-wrap gap-3 mt-7 pt-5 border-t border-gray-100">

        <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-7 py-3 rounded-xl transition">
            {{ $isEdit ? 'আপডেট করুন' : 'ক্যাটাগরি তৈরি করুন' }}
        </button>

        <a href="{{ route('admin.advertisement-categories.index') }}"
           class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-7 py-3 rounded-xl transition">
            ফিরে যান
        </a>

    </div>

</div>
