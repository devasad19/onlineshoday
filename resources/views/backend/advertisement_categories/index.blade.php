
@extends('apps.dashboard_master')

@section('content')

@include('backend.patrials.top_bar')

<div class="p-4 sm:p-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">

        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                বিজ্ঞাপন ক্যাটাগরি
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                বিজ্ঞাপনের ক্যাটাগরি তৈরি ও পরিচালনা করুন।
            </p>
        </div>

        <a href="{{ route('admin.advertisement-categories.create') }}"
           class="inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl font-semibold text-sm">
            <span>+</span> নতুন ক্যাটাগরি
        </a>

    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-5 py-4">ক্রম</th>
                        <th class="px-5 py-4">ক্যাটাগরি</th>
                        <th class="px-5 py-4">Slug</th>
                        <th class="px-5 py-4 text-center">বিজ্ঞাপন</th>
                        <th class="px-5 py-4 text-center">ক্রম</th>
                        <th class="px-5 py-4 text-center">স্ট্যাটাস</th>
                        <th class="px-5 py-4 text-right">অ্যাকশন</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($categories as $category)

                        <tr class="hover:bg-gray-50">

                            <td class="px-5 py-4 text-gray-500">
                                {{ $categories->firstItem() + $loop->index }}
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl">
                                        {{ $category->icon ?: '📁' }}
                                    </span>

                                    <span class="font-semibold text-gray-800">
                                        {{ $category->name }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-5 py-4 text-gray-500">
                                {{ $category->slug }}
                            </td>

                            <td class="px-5 py-4 text-center">
                                <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full font-semibold">
                                    {{ $category->ads_count }}
                                </span>
                            </td>

                            <td class="px-5 py-4 text-center text-gray-600">
                                {{ $category->sort_order }}
                            </td>

                            <td class="px-5 py-4 text-center">
                                @if($category->is_active)
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Active
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-2">

                                    <a href="{{ route('admin.advertisement-categories.edit', $category->id) }}"
                                       class="bg-blue-50 hover:bg-blue-100 text-blue-700 px-3 py-2 rounded-lg text-xs font-semibold">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.advertisement-categories.toggle-status', $category->id) }}"
                                          method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                class="bg-yellow-50 hover:bg-yellow-100 text-yellow-700 px-3 py-2 rounded-lg text-xs font-semibold">
                                            {{ $category->is_active ? 'Inactive' : 'Active' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.advertisement-categories.destroy', $category->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই ক্যাটাগরি Delete করতে চান?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="bg-red-50 hover:bg-red-100 text-red-700 px-3 py-2 rounded-lg text-xs font-semibold">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-gray-500">
                                এখনো কোনো ক্যাটাগরি তৈরি করা হয়নি।
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $categories->links() }}
        </div>

    </div>

</div>

@endsection
