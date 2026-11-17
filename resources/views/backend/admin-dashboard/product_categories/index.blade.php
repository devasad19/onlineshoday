@extends('apps.dashboard_master')

@section('content')

@include('backend.patrials.top_bar')

<div class="p-4">

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl font-bold">পণ্যের ক্যাটাগরি</h2>
            <p class="text-sm text-gray-500">সকল পণ্যের ক্যাটাগরি পরিচালনা করুন</p>
        </div>

        <a href="{{ route('admin.product-categories.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
            + নতুন ক্যাটাগরি
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-x-auto">

        <table class="w-full text-sm text-left">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">ছবি</th>
                    <th class="p-3">ক্যাটাগরির নাম</th>
                    <th class="p-3">Slug</th>
                    <th class="p-3 text-center">পণ্য সংখ্যা</th>
                    <th class="p-3 text-center">ক্রম</th>
                    <th class="p-3 text-center">স্ট্যাটাস</th>
                    <th class="p-3 text-center">অ্যাকশন</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($categories as $category)

                    <tr>
                        <td class="p-3">
                            @if($category->image)
                                <img src="{{ asset('uploads/products-categories/'.$category->image) }}"
                                     class="w-12 h-12 rounded-lg object-cover">
                            @else
                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                    📦
                                </div>
                            @endif
                        </td>

                        <td class="p-3 font-semibold">
                            {{ $category->name }}
                        </td>

                        <td class="p-3 text-gray-500">
                            {{ $category->slug }}
                        </td>

                        <td class="p-3 text-center">
                            {{ $category->products_count }}
                        </td>

                        <td class="p-3 text-center">
                            {{ $category->sort_order }}
                        </td>

                        <td class="p-3 text-center">
                            @if($category->status == 'Active')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">
                                    Active
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">
                                    Deactive
                                </span>
                            @endif
                        </td>

                        <td class="p-3">
                            <div class="flex items-center justify-center gap-2">

                                <a href="{{ route('admin.product-categories.edit', $category->id) }}"
                                   class="bg-blue-100 text-blue-700 px-3 py-1.5 rounded-lg">
                                    Edit
                                </a>

                                <form action="{{ route('admin.product-categories.destroy', $category->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('আপনি কি এই ক্যাটাগরি মুছে ফেলতে চান?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="bg-red-100 text-red-700 px-3 py-1.5 rounded-lg">
                                        Delete
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-500">
                            কোনো ক্যাটাগরি পাওয়া যায়নি।
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>

    </div>

    <div class="mt-5">
        {{ $categories->links() }}
    </div>

</div>

@endsection