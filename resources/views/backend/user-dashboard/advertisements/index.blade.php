
@extends('apps.dashboard_master')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-6">

    <div class="flex flex-wrap justify-between items-center gap-3 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                আমার বিজ্ঞাপন
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                আপনার জমা দেওয়া সব বিজ্ঞাপনের তালিকা।
            </p>
        </div>

        <a href="{{ route('user.advertisements.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl font-semibold">
            <i class="fas fa-plus mr-2"></i>
            নতুন বিজ্ঞাপন
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 mb-5">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">

                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="p-4">বিজ্ঞাপন</th>
                        <th class="p-4">ক্যাটাগরি</th>
                        <th class="p-4">তারিখ</th>
                        <th class="p-4">স্ট্যাটাস</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($advertisements as $ad)

                        <tr>
                            <td class="p-4 min-w-56">
                                <div class="flex items-center gap-3">

                                    @if($ad->image)
                                        <img src="{{ asset('uploads/advertisements/'.$ad->image) }}"
                                             class="w-14 h-14 rounded-lg object-cover"
                                             alt="">
                                    @endif

                                    <div>
                                        <p class="font-semibold text-gray-800">
                                            {{ $ad->title }}
                                        </p>

                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $ad->provider_name }}
                                        </p>
                                    </div>

                                </div>
                            </td>

                            <td class="p-4">
                                {{ $ad->category }}
                            </td>

                            <td class="p-4 whitespace-nowrap">
                                {{ $ad->created_at->format('d M Y') }}
                            </td>

                            <td class="p-4 whitespace-nowrap">

                                @if($ad->status == 'approved')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        অনুমোদিত
                                    </span>

                                @elseif($ad->status == 'rejected')
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        বাতিল
                                    </span>

                                @else
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        অপেক্ষমাণ
                                    </span>
                                @endif

                                @if($ad->status == 'rejected' && $ad->rejection_reason)
                                    <p class="text-xs text-red-600 mt-2">
                                        কারণ: {{ $ad->rejection_reason }}
                                    </p>
                                @endif

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="text-center py-12 text-gray-500">
                                <i class="fas fa-bullhorn text-4xl text-gray-300 mb-3"></i>
                                <p>আপনি এখনো কোনো বিজ্ঞাপন জমা দেননি।</p>
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $advertisements->links() }}
        </div>

    </div>

</div>

@endsection
