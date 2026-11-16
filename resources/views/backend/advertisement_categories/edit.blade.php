@extends('apps.dashboard_master')

@section('content')

@include('backend.patrials.top_bar')

<div class="p-4 sm:p-6 max-w-4xl mx-auto">

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            ক্যাটাগরি Edit করুন
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            {{ $category->name }}
        </p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 text-red-700 rounded-xl p-4 mb-4">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.advertisement-categories.update', $category->id) }}"
          method="POST">
        @csrf
        @method('PUT')

        @include('backend.advertisement_categories._form')

    </form>

</div>

@endsection