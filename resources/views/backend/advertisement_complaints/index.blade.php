
@extends('apps.dashboard_master')

@section('content')

@include('backend.patrials.top_bar')

<div class="max-w-6xl mx-auto px-4 py-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">

        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                আমার অভিযোগসমূহ
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                আপনার জমা দেওয়া অভিযোগ এবং সমাধানের অবস্থা দেখুন।
            </p>
        </div>

        <a href="{{ route('dashboard.advertisement-complaints.create') }}"
           class="inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl font-semibold text-sm">

            <span>＋</span>
            নতুন অভিযোগ

        </a>

    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 mb-5">
            {{ session('success') }}
        </div>
    @endif

    {{-- Complaint List --}}
    @if($complaints->isNotEmpty())

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-sm text-left">

                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-5 py-4">Complaint ID</th>
                            <th class="px-5 py-4">বিজ্ঞাপন</th>
                            <th class="px-5 py-4">অভিযোগের ধরন</th>
                            <th class="px-5 py-4">তারিখ</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4 text-right">বিস্তারিত</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($complaints as $complaint)

                            <tr class="hover:bg-gray-50">

                                <td class="px-5 py-4 font-semibold text-gray-800 whitespace-nowrap">
                                    {{ $complaint->complaint_code }}
                                </td>

                                <td class="px-5 py-4 text-gray-600">
                                    {{ $complaint->advertisement?->title ?? 'বিজ্ঞাপনটি আর পাওয়া যাচ্ছে না' }}
                                </td>

                                <td class="px-5 py-4 text-gray-600 whitespace-nowrap">
                                    {{ [
                                        'service_not_received' => 'সেবা না পাওয়া',
                                        'fraud' => 'প্রতারণা',
                                        'wrong_information' => 'ভুল তথ্য',
                                        'extra_charge' => 'অতিরিক্ত মূল্য',
                                        'bad_behavior' => 'খারাপ ব্যবহার',
                                        'poor_service' => 'নিম্নমানের সেবা',
                                        'other' => 'অন্যান্য',
                                    ][$complaint->complaint_type] ?? 'অন্যান্য' }}
                                </td>

                                <td class="px-5 py-4 text-gray-500 whitespace-nowrap">
                                    {{ $complaint->created_at->format('d M Y') }}
                                </td>

                                <td class="px-5 py-4 whitespace-nowrap">

                                    @php
                                        $statusClasses = [
                                            'received' => 'bg-blue-100 text-blue-700',
                                            'under_review' => 'bg-yellow-100 text-yellow-700',
                                            'need_information' => 'bg-purple-100 text-purple-700',
                                            'resolved' => 'bg-green-100 text-green-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                            'closed' => 'bg-gray-100 text-gray-700',
                                        ];
                                    @endphp

                                    <span class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $statusClasses[$complaint->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $complaint->status_label }}
                                    </span>

                                </td>

                                <td class="px-5 py-4 text-right whitespace-nowrap">

                                    <a href="{{ route('dashboard.advertisement-complaints.show', $complaint->id) }}"
                                       class="text-green-700 font-semibold hover:underline">
                                        দেখুন →
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        <div class="mt-5">
            {{ $complaints->links() }}
        </div>

    @else

        {{-- Empty State --}}
        <div class="bg-white border border-dashed border-gray-300 rounded-2xl py-16 px-5 text-center">

            <div class="text-5xl mb-4">📭</div>

            <h3 class="text-lg font-bold text-gray-800">
                এখনো কোনো অভিযোগ জমা দেননি।
            </h3>

            <p class="text-sm text-gray-500 mt-2">
                কোনো বিজ্ঞাপন বা সেবা নিয়ে সমস্যা হলে এখান থেকে অভিযোগ করতে পারবেন।
            </p>

            <a href="{{ route('dashboard.advertisement-complaints.create') }}"
               class="inline-flex mt-5 bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl font-semibold text-sm">
                অভিযোগ জমা দিন
            </a>

        </div>

    @endif

</div>

@endsection
