
@extends('apps.dashboard_master')

@section('content')

<div class="flex min-h-screen bg-gray-50">

    <div class="flex-1 min-w-0">

        @include('backend.patrials.top_bar')

        <div class="p-4 md:p-6">

            <h2 class="text-2xl font-bold text-green-700 mb-6">
                বিজ্ঞাপন সম্পাদনা করুন
            </h2>

            <form action="{{ route('admin.advertisements.update', $advertisement->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="bg-white rounded-xl shadow-sm p-5 md:p-7">

                @method('PUT')

                @include('backend.advertisements._form')

            </form>

        </div>

    </div>

</div>

@endsection
