@extends('apps.dashboard_master')

@section('content')

@include('backend.patrials.top_bar')

<div class="p-4 max-w-3xl mx-auto">

    <div class="mb-6">
        <h2 class="text-xl font-bold">ক্যাটাগরি সম্পাদনা</h2>
        <p class="text-sm text-gray-500">
            {{ $productCategory->name }} ক্যাটাগরির তথ্য পরিবর্তন করুন
        </p>
    </div>

    <form action="{{ route('admin.product-categories.update', $productCategory->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white rounded-xl shadow-sm p-5 space-y-5">

        @csrf
        @method('PUT')

        @include('backend.admin-dashboard.product_categories.form', [
            'category' => $productCategory
        ])

        <div class="flex gap-3">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg">
                পরিবর্তন সংরক্ষণ করুন
            </button>

            <a href="{{ route('admin.product-categories.index') }}"
               class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-lg">
                ফিরে যান
            </a>
        </div>

    </form>

</div>

@endsection