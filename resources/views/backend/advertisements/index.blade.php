
@extends('apps.dashboard_master')

@section('content')

<div class="flex min-h-screen bg-gray-50">

    <div class="flex-1 min-w-0 flex flex-col">

        @include('backend.patrials.top_bar')

        <div class="p-4 md:p-6">

            {{-- Header --}}
            <div class="flex flex-wrap justify-between items-center gap-3 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-green-700">
                        বিজ্ঞাপন ম্যানেজমেন্ট
                    </h2>
                    <p class="text-sm text-gray-500">
                        নিজের সেবা ও গ্রাহকদের বিজ্ঞাপন পরিচালনা করুন।
                    </p>
                </div>

                <a href="{{ route('admin.advertisements.create') }}"
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    + নতুন বিজ্ঞাপন
                </a>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Statistics --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">

                @foreach([
                    ['সব বিজ্ঞাপন', $counts['all'], 'gray'],
                    ['অনুমোদনের অপেক্ষায়', $counts['pending'], 'yellow'],
                    ['প্রকাশিত', $counts['approved'], 'green'],
                    ['বাতিল', $counts['rejected'], 'red']
                ] as $item)

                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <p class="text-sm text-gray-500">
                            {{ $item[0] }}
                        </p>
                        <h3 class="text-2xl font-bold mt-1 text-{{ $item[2] }}-600">
                            {{ $item[1] }}
                        </h3>
                    </div>

                @endforeach

            </div>

            {{-- Filters --}}
            <form method="GET"
                  class="bg-white p-4 rounded-xl shadow-sm mb-5 grid grid-cols-1 md:grid-cols-4 gap-3">

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="বিজ্ঞাপনের নাম লিখুন"
                       class="border rounded-lg px-3 py-2">

                <select name="category"
                        class="border rounded-lg px-3 py-2">
                    <option value="">সব ক্যাটাগরি</option>
                         @foreach(
        \App\Models\AdvertisementCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get() as $category
    )
        <option value="{{ $category->name }}"
            {{ old('category', $advertisement->category ?? '') == $category->name ? 'selected' : '' }}>
            {{ $category->icon }} {{ $category->name }}
        </option>
    @endforeach
                </select>

                <select name="status"
                        class="border rounded-lg px-3 py-2">
                    <option value="">সব স্ট্যাটাস</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>

                <button class="bg-gray-800 text-white rounded-lg px-4 py-2">
                    Filter
                </button>

            </form>

            {{-- Advertisement List --}}
            <div class="bg-white rounded-xl shadow-sm overflow-x-auto">

                <table class="w-full text-sm text-left">

                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="p-3">ছবি</th>
                            <th class="p-3">বিজ্ঞাপনের নাম</th>
                            <th class="p-3">ক্যাটাগরি</th>
                            <th class="p-3">ধরন</th>
                            <th class="p-3">স্ট্যাটাস</th>
                            <th class="p-3">কার্যক্রম</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($advertisements as $ad)

                            <tr class="border-t hover:bg-gray-50">

                                <td class="p-3">
                                    @if($ad->image)
                                        <img src="{{ asset('uploads/advertisements/'.$ad->image) }}"
                                             class="w-14 h-12 object-cover rounded">
                                    @else
                                        <div class="w-14 h-12 bg-gray-100 rounded flex items-center justify-center">
                                            <span class="text-gray-400 text-xs">No Image</span>
                                        </div>
                                    @endif
                                </td>

                                <td class="p-3">
                                    <p class="font-semibold">
                                        {{ $ad->title }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $ad->provider_name }}
                                    </p>
                                </td>

                                <td class="p-3">
                                    {{ $ad->category }}
                                </td>

                                <td class="p-3">
                                    @if($ad->ad_type == 'own_service')
                                        <span class="text-green-700">নিজস্ব সেবা</span>
                                    @elseif($ad->ad_type == 'partner_service')
                                        <span class="text-blue-700">পার্টনার সেবা</span>
                                    @else
                                        <span class="text-purple-700">সাধারণ বিজ্ঞাপন</span>
                                    @endif
                                </td>

                                <td class="p-3">

                                    @if($ad->status == 'approved')
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded">
                                            Approved
                                        </span>
                                    @elseif($ad->status == 'pending')
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">
                                            Pending
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded">
                                            Rejected
                                        </span>
                                    @endif

                                </td>

                                <td class="p-3">

                                    <div class="flex flex-wrap gap-2">

                                        <a href="{{ route('admin.advertisements.edit', $ad->id) }}"
                                           class="text-blue-600 hover:underline">
                                            Edit
                                        </a>

                                        @if($ad->status != 'approved')
                                            <form action="{{ route('admin.advertisements.approve', $ad->id) }}"
                                                  method="POST">
                                                @csrf
                                                <button class="text-green-600 hover:underline">
                                                    Approve
                                                </button>
                                            </form>
                                        @endif

                                        @if($ad->status != 'rejected')
                                            <form action="{{ route('admin.advertisements.reject', $ad->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('বিজ্ঞাপনটি বাতিল করবেন?')">
                                                @csrf
                                                <input type="hidden"
                                                       name="rejection_reason"
                                                       value="Admin কর্তৃক বাতিল করা হয়েছে।">
                                                <button class="text-orange-600 hover:underline">
                                                    Reject
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.advertisements.destroy', $ad->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('বিজ্ঞাপনটি মুছে ফেলবেন?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:underline">
                                                Delete
                                            </button>
                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center p-8 text-gray-500">
                                    কোনো বিজ্ঞাপন পাওয়া যায়নি।
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

                <div class="p-4">
                    {{ $advertisements->links() }}
                </div>

            </div>

        </div>

    </div>

</div>

@endsection
