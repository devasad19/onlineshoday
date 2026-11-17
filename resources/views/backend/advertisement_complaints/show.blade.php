
@extends('apps.dashboard_master')

@section('content')

@include('backend.patrials.top_bar')

@php
    $complaintTypes = [
        'service_not_received' => 'সেবা না পাওয়া',
        'fraud' => 'প্রতারণা বা জালিয়াতি',
        'wrong_information' => 'বিজ্ঞাপনে ভুল তথ্য',
        'extra_charge' => 'অতিরিক্ত টাকা দাবি',
        'bad_behavior' => 'খারাপ ব্যবহার',
        'poor_service' => 'নিম্নমানের সেবা',
        'other' => 'অন্যান্য',
    ];

    $resolutions = [
        'get_service' => 'প্রতিশ্রুত সেবা পেতে চাই',
        'refund' => 'টাকা ফেরত চাই',
        'contact' => 'আমার সঙ্গে যোগাযোগ করা হোক',
        'investigation' => 'বিষয়টি তদন্ত করা হোক',
        'other' => 'অন্যান্য',
    ];

    $statusClasses = [
        'received' => 'bg-blue-100 text-blue-700',
        'under_review' => 'bg-yellow-100 text-yellow-700',
        'need_information' => 'bg-purple-100 text-purple-700',
        'resolved' => 'bg-green-100 text-green-700',
        'rejected' => 'bg-red-100 text-red-700',
        'closed' => 'bg-gray-100 text-gray-700',
    ];
@endphp

<div class="max-w-4xl mx-auto px-4 py-6">

    {{-- Back --}}
    <a href="{{ route('dashboard.advertisement-complaints.index') }}"
       class="text-sm text-green-700 hover:underline">
        ← আমার অভিযোগসমূহ
    </a>

    {{-- Success --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 mt-5">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mt-5 mb-6">

        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                অভিযোগের বিস্তারিত
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                {{ $complaint->complaint_code }}
            </p>
        </div>

        <span class="inline-flex w-fit px-4 py-2 rounded-full text-sm font-semibold {{ $statusClasses[$complaint->status] ?? 'bg-gray-100 text-gray-700' }}">
            {{ $complaint->status_label }}
        </span>

    </div>

    {{-- Complaint Information --}}
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 sm:p-7 space-y-5">

        <div>
            <p class="text-xs text-gray-400 mb-1">সংশ্লিষ্ট বিজ্ঞাপন</p>

            @if($complaint->advertisement)
                <a href="{{ route('advertisement.show', $complaint->advertisement->slug) }}"
                   class="font-semibold text-green-700 hover:underline">
                    {{ $complaint->advertisement->title }}
                </a>
            @else
                <p class="font-semibold text-gray-700">
                    বিজ্ঞাপনটি আর পাওয়া যাচ্ছে না।
                </p>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

            <div>
                <p class="text-xs text-gray-400 mb-1">অভিযোগের ধরন</p>

                <p class="font-semibold text-gray-800">
                    {{ $complaintTypes[$complaint->complaint_type] ?? 'অন্যান্য' }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-400 mb-1">জমা দেওয়ার তারিখ</p>

                <p class="font-semibold text-gray-800">
                    {{ $complaint->created_at->format('d M Y, h:i A') }}
                </p>
            </div>

        </div>

        <div>
            <p class="text-xs text-gray-400 mb-2">অভিযোগের বিবরণ</p>

            <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-700 leading-7 whitespace-pre-line">
                {{ $complaint->description }}
            </div>
        </div>

        @if($complaint->evidence)
            <div>
                <p class="text-xs text-gray-400 mb-2">জমা দেওয়া প্রমাণ</p>

                <a href="{{ asset('storage/' . $complaint->evidence) }}"
                   target="_blank"
                   rel="noopener noreferrer">

                    <img src="{{ asset('storage/' . $complaint->evidence) }}"
                         alt="অভিযোগের প্রমাণ"
                         class="max-w-xs w-full rounded-xl border border-gray-200">

                </a>
            </div>
        @endif

        @if($complaint->desired_resolution)
            <div>
                <p class="text-xs text-gray-400 mb-1">আপনার কাঙ্ক্ষিত সমাধান</p>

                <p class="font-semibold text-gray-800">
                    {{ $resolutions[$complaint->desired_resolution] ?? 'অন্যান্য' }}
                </p>
            </div>
        @endif

        <div class="border-t border-gray-100 pt-5">

            <h3 class="font-bold text-gray-800 mb-3">
                Online Shoday-এর উত্তর
            </h3>

            @if($complaint->admin_response)

                <div class="bg-green-50 border border-green-100 rounded-xl p-4 text-sm text-gray-700 leading-7 whitespace-pre-line">
                    {{ $complaint->admin_response }}
                </div>

            @else

                <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-500">
                    আপনার অভিযোগটি গ্রহণ করা হয়েছে। Admin পর্যালোচনা করলে এখানে উত্তর দেখতে পাবেন।
                </div>

            @endif

            @if($complaint->resolved_at)
                <p class="text-xs text-gray-400 mt-3">
                    নিষ্পত্তির তারিখ:
                    {{ $complaint->resolved_at->format('d M Y, h:i A') }}
                </p>
            @endif

        </div>

    </div>

</div>

@endsection
