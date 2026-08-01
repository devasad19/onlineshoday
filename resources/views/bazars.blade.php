@extends('apps.front_master')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">🏪 আমাদের বাজার তালিকা</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($bazars as $bazar)
    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition flex flex-col gap-3">
        <div class="flex-1">
            <h3 class="text-2xl font-semibold text-gray-800 mb-2">{{ $bazar->name }}</h3>
            <p class="text-gray-600">রাইডার সংখ্যা: <strong>{{ count($bazar->riders) }}</strong></p>
            <p class="text-gray-600">পণ্যের সংখ্যা: <strong>{{ count($bazar->products) }}</strong></p>

            <p class="text-gray-600 mt-2">কভার করা এলাকা/গ্রাম:</p>
            <div class="flex flex-wrap mt-2 gap-2">
                @forelse($bazar->areas as $area)
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">{{ $area->name }}</span>
                @empty
                <div class="col-span-4 text-yellow-500 text-xs text-gray-500 py-1">
                    🚫 কোনো এলাকা/গ্রাম পাওয়া যায়নি।
                </div>
                @endforelse
            </div>
        </div>
 
    </div>
    @endforeach
</div>


        <!-- Pagination -->
      

    </div>
</div>
@endsection