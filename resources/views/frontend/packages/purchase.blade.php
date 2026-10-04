@extends('apps.front_master')

@section('title', 'প্যাকেজ অর্ডার')

@section('content')

{{-- =========================================================
    SELECT2 CSS
========================================================= --}}
<link
    href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
    rel="stylesheet"
/>

<style>
    .purchase-tab {
        transition: all 0.2s ease;
    }

    .purchase-tab.active {
        background: #ffffff;
        color: #15803d;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.10);
    }

    .purchase-tab:not(.active) {
        color: #6b7280;
    }

    .purchase-tab:not(.active):hover {
        color: #15803d;
    }

    /* =====================================================
       SELECT2 CUSTOM STYLE
    ===================================================== */

    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single {
        height: 50px !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 12px !important;
        background: #ffffff !important;
        display: flex !important;
        align-items: center !important;
        padding: 0 42px 0 16px !important;
        box-shadow: none !important;
    }

    .select2-container--default
    .select2-selection--single
    .select2-selection__rendered {
        color: #374151 !important;
        line-height: normal !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .select2-container--default
    .select2-selection--single
    .select2-selection__placeholder {
        color: #9ca3af !important;
    }

    .select2-container--default
    .select2-selection--single
    .select2-selection__arrow {
        height: 48px !important;
        right: 12px !important;
    }

    .select2-container--default.select2-container--focus
    .select2-selection--single,
    .select2-container--default.select2-container--open
    .select2-selection--single {
        border-color: #86efac !important;
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.10) !important;
    }

    .select2-dropdown {
        border: 1px solid #e5e7eb !important;
        border-radius: 12px !important;
        overflow: hidden !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.10) !important;
        z-index: 99999 !important;
    }

    .select2-search--dropdown {
        padding: 10px !important;
        background: #ffffff !important;
    }

    .select2-container--default
    .select2-search--dropdown
    .select2-search__field {
        height: 42px !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 9px !important;
        padding: 0 12px !important;
        outline: none !important;
    }

    .select2-container--default
    .select2-search--dropdown
    .select2-search__field:focus {
        border-color: #86efac !important;
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.10) !important;
    }

    .select2-container--default .select2-results__option {
        padding: 11px 14px !important;
        font-size: 14px !important;
    }

    .select2-container--default
    .select2-results__option--highlighted[aria-selected] {
        background: #16a34a !important;
        color: #ffffff !important;
    }

    .select2-container--default
    .select2-results__option[aria-selected="true"] {
        background: #f0fdf4 !important;
        color: #15803d !important;
    }

    .select2-container--default
    .select2-selection--single
    .select2-selection__clear {
        margin-right: 20px !important;
        color: #9ca3af !important;
        font-size: 18px !important;
    }

    .select2-container--default
    .select2-selection--single
    .select2-selection__clear:hover {
        color: #ef4444 !important;
    }

    @media (max-width: 640px) {
        .select2-container--default
        .select2-selection--single {
            height: 48px !important;
        }
    }
</style>

@include('alerts.alert')
<div class="min-h-screen bg-gray-50 py-6">

    <div class="max-w-4xl mx-auto px-4">

        {{-- =====================================================
            HEADER
        ====================================================== --}}
        <div class="mb-5">

            <a
                href="{{ url()->previous() }}"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-green-600 mb-4"
            >
                <i class="fa-solid fa-arrow-left"></i>
                ফিরে যান
            </a>

            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                প্যাকেজ অর্ডার
            </h1>

            <p class="text-gray-500 mt-1">
                আপনার পছন্দের প্যাকেজটি অর্ডার করুন
            </p>

        </div>


        {{-- =====================================================
            FORM
        ====================================================== --}}
        <form
            action="{{ route('packages.purchase.store', $package->id) }}"
            method="POST"
            id="packagePurchaseForm"
        >

            @csrf

            {{-- Final selected customer DB user ID --}}
            <input
                type="hidden"
                name="customer_id"
                id="customer_id"
                value=""
            >


            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">


                {{-- =================================================
                    LEFT SIDE
                ================================================= --}}
                <div class="lg:col-span-2 space-y-5">


                    {{-- =================================================
                        PACKAGE CARD
                    ================================================= --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                        <div class="p-5">

                            <div class="flex flex-col sm:flex-row gap-4">

                                {{-- Package Image --}}
                                <div class="w-full sm:w-36 h-36 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">

                                    @if($package->image)

                                        <img
                                            src="{{ url('uploads/packages', $package->image) }}"
                                            alt="{{ $package->name }}"
                                            class="w-full h-full object-cover"
                                        >

                                    @else

                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <i class="fa-solid fa-box text-4xl"></i>
                                        </div>

                                    @endif

                                </div>


                                {{-- Package Information --}}
                                <div class="flex-1">

                                    <div class="flex items-start justify-between gap-3">

                                        <div>

                                            <h2 class="text-xl font-bold text-gray-800">
                                                {{ $package->name }}
                                            </h2>

                                            @if($package->description)

                                                <p class="text-sm text-gray-500 mt-1">
                                                    {{ $package->description }}
                                                </p>

                                            @endif

                                        </div>


                                        @if($package->discount > 0)

                                            <span
                                                class="bg-red-50 text-red-600 text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap"
                                            >
                                                {{ $package->discount }}% ছাড়
                                            </span>

                                        @endif

                                    </div>


                                    <div class="mt-4">

                                        @if($package->discount > 0)

                                            <span class="text-gray-400 line-through text-sm">
                                                ৳{{ number_format($package->price, 2) }}
                                            </span>

                                            <span class="text-2xl font-bold text-green-600 ml-2">
                                                ৳{{
                                                    number_format(
                                                        $package->price -
                                                        (($package->price * $package->discount) / 100),
                                                        2
                                                    )
                                                }}
                                            </span>

                                        @else

                                            <span class="text-2xl font-bold text-green-600">
                                                ৳{{ number_format($package->price, 2) }}
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        PURCHASE TYPE + DELIVERY
                    ================================================= --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">


                        {{-- Header --}}
                        <div class="px-5 py-4 border-b border-gray-100">

                            <h2 class="font-bold text-gray-800 flex items-center gap-2">

                                <i class="fa-solid fa-users text-green-600"></i>

                                কার জন্য প্যাকেজ কিনছেন?

                            </h2>

                            <p class="text-xs text-gray-500 mt-1">
                                নিজের জন্য অথবা আপনার Referral Customer-এর জন্য প্যাকেজ কিনতে পারেন।
                            </p>

                        </div>


                        {{-- =================================================
                            TABS
                        ================================================= --}}
                        <div class="p-4 pb-0">

                            <div class="bg-gray-100 rounded-xl p-1 flex gap-1">

                                {{-- Own --}}
                                <button
                                    type="button"
                                    id="ownCustomerTab"
                                    class="purchase-tab active flex-1 rounded-lg px-4 py-3 text-sm font-semibold flex items-center justify-center gap-2"
                                    onclick="selectPurchaseType('own')"
                                >
                                    <i class="fa-solid fa-user"></i>
                                    নিজের জন্য
                                </button>


                                {{-- Other --}}
                                <button
                                    type="button"
                                    id="otherCustomerTab"
                                    class="purchase-tab flex-1 rounded-lg px-4 py-3 text-sm font-semibold flex items-center justify-center gap-2"
                                    onclick="selectPurchaseType('other')"
                                >
                                    <i class="fa-solid fa-users"></i>
                                    অন্য Customer-এর জন্য
                                </button>

                            </div>

                        </div>


                        {{-- =================================================
                            OWN CUSTOMER
                        ================================================= --}}
                        <div
                            id="ownCustomerSection"
                            class="p-5"
                        >

                            <div class="bg-green-50 border border-green-100 rounded-xl p-4 mb-5">

                                <div class="flex items-start gap-3">

                                    <div
                                        class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0"
                                    >
                                        <i class="fa-solid fa-user"></i>
                                    </div>

                                    <div>

                                        <p class="font-bold text-gray-800">
                                            নিজের জন্য প্যাকেজ
                                        </p>

                                        <p class="text-sm text-gray-500 mt-1">
                                            আপনার নিজের Account-এর তথ্য অনুযায়ী প্যাকেজটি ডেলিভারি হবে।
                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- Delivery Information --}}
                            <div>

                                <div class="flex items-center gap-2 mb-4">

                                    <i class="fa-solid fa-location-dot text-green-600"></i>

                                    <h3 class="font-bold text-gray-800">
                                        Delivery Information
                                    </h3>

                                </div>


                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                    {{-- Name --}}
                                    <div>

                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Customer Name
                                        </label>

                                        <input
                                            type="text"
                                            value="{{ auth()->user()->name }}"
                                            readonly
                                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700"
                                        >

                                    </div>


                                    {{-- Phone --}}
                                    <div>

                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            মোবাইল নম্বর
                                        </label>

                                        <input
                                            type="text"
                                            value="{{ auth()->user()->phone }}"
                                            readonly
                                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700"
                                        >

                                    </div>


                                    {{-- Address --}}
                                    <div class="md:col-span-2">

                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            ঠিকানা
                                        </label>

                                        <textarea
                                            readonly
                                            rows="3"
                                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700"
                                        >{{ auth()->user()->address ?: 'ঠিকানা দেওয়া হয়নি' }}</textarea>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                            OTHER CUSTOMER
                        ================================================= --}}
                        <div
                            id="otherCustomerSection"
                            class="hidden p-5"
                        >


                            {{-- Info --}}
                            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-5">

                                <div class="flex items-start gap-3">

                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0"
                                    >
                                        <i class="fa-solid fa-user-group"></i>
                                    </div>

                                    <div class="flex-1">

                                        <p class="font-bold text-gray-800">
                                            অন্য Customer-এর জন্য
                                        </p>

                                        <p class="text-sm text-gray-500 mt-1">
                                            আপনার Referral Customer list থেকে একজন Customer নির্বাচন করুন।
                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- =================================================
                                CUSTOMER SELECT
                            ================================================= --}}
                            <div>

                                <div class="flex items-center justify-between gap-3 mb-2">

                                    <label
                                        for="referral_customer_select"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        Customer নির্বাচন করুন
                                    </label>


                                    {{-- New Account --}}
                                    <a
                                        href="{{ route('new.customer.register', $package->id) }}"
                                        class="inline-flex items-center gap-1
                                               text-xs font-semibold text-green-600
                                               hover:text-green-700
                                               border border-green-200
                                               bg-green-50 hover:bg-green-100
                                               px-3 py-1.5 rounded-lg whitespace-nowrap"
                                    >
                                        <i class="fa-solid fa-user-plus"></i>
                                        নতুন Account
                                    </a>

                                </div>


                                {{-- Select2 --}}
                                <select
                                    id="referral_customer_select"
                                    class="w-full"
                                >

                                    <option value="">
                                        Customer নির্বাচন করুন
                                    </option>


                                    @foreach($referralCustomers as $referral)

                                        <option
                                            value="{{ $referral->id }}"
                                            data-customer-id="{{ $referral->customer_id }}"
                                            data-name="{{ $referral->name }}"
                                            data-phone="{{ $referral->phone }}"
                                            data-address="{{ $referral->address }}"
                                        >

                                            {{ $referral->name }}

                                            @if($referral->customer_id)
                                                — ID: {{ $referral->customer_id }}
                                            @endif

                                            @if($referral->phone)
                                                — {{ $referral->phone }}
                                            @endif

                                        </option>

                                    @endforeach

                                </select>


                                <p class="text-xs text-gray-400 mt-2">

                                    <i class="fa-solid fa-circle-info mr-1"></i>

                                    Customer-এর Account না থাকলে উপরের
                                    <span class="font-semibold text-green-600">
                                        নতুন Account
                                    </span>
                                    অপশন ব্যবহার করুন।

                                </p>

                            </div>


                            {{-- =================================================
                                SELECTED CUSTOMER
                            ================================================= --}}
                            <div
                                id="selectedCustomerInfo"
                                class="hidden mt-5"
                            >

                                <div class="bg-green-50 border border-green-100 rounded-xl p-4">

                                    <div class="flex items-start gap-3">

                                        <div
                                            class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0"
                                        >
                                            <i class="fa-solid fa-user-check"></i>
                                        </div>


                                        <div class="text-sm flex-1">

                                            <p class="font-bold text-gray-800">

                                                <span id="selectedCustomerName"></span>

                                            </p>


                                            <p
                                                id="selectedCustomerId"
                                                class="text-xs text-green-600 mt-1"
                                            ></p>


                                            <p
                                                id="selectedCustomerPhone"
                                                class="text-gray-600 mt-2"
                                            ></p>


                                            <p
                                                id="selectedCustomerAddress"
                                                class="text-gray-500 mt-1"
                                            ></p>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- =================================================
                                DELIVERY INFORMATION
                            ================================================= --}}
                            <div class="mt-6 pt-5 border-t border-gray-100">

                                <div class="flex items-center gap-2 mb-4">

                                    <i class="fa-solid fa-location-dot text-green-600"></i>

                                    <h3 class="font-bold text-gray-800">
                                        Delivery Information
                                    </h3>

                                </div>


                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                                    {{-- Name --}}
                                    <div>

                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Customer Name
                                        </label>

                                        <input
                                            type="text"
                                            id="deliveryCustomerName"
                                            readonly
                                            placeholder="Customer নির্বাচন করুন"
                                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700"
                                        >

                                    </div>


                                    {{-- Phone --}}
                                    <div>

                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            মোবাইল নম্বর
                                        </label>

                                        <input
                                            type="text"
                                            id="deliveryCustomerPhone"
                                            readonly
                                            placeholder="Customer নির্বাচন করুন"
                                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700"
                                        >

                                    </div>


                                    {{-- Address --}}
                                    <div class="md:col-span-2">

                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            ঠিকানা
                                        </label>

                                        <textarea
                                            id="deliveryCustomerAddress"
                                            readonly
                                            rows="3"
                                            placeholder="Customer নির্বাচন করলে ঠিকানা এখানে দেখাবে"
                                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700"
                                        ></textarea>

                                    </div>

                                </div>


                                {{-- Delivery Note --}}
                                <div
                                    id="deliveryCustomerNote"
                                    class="hidden mt-3 bg-green-50 border border-green-100 rounded-lg px-3 py-2 text-xs text-green-700"
                                >

                                    <i class="fa-solid fa-circle-check mr-1"></i>

                                    এই Customer-এর ঠিকানায় প্যাকেজটি ডেলিভারি হবে।

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        PACKAGE ITEMS
                    ================================================= --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">

                        <div class="px-5 py-4 border-b border-gray-100">

                            <h2 class="font-bold text-gray-800 flex items-center gap-2">

                                <i class="fa-solid fa-box-open text-green-600"></i>

                                প্যাকেজে যা যা থাকছে

                            </h2>

                        </div>


                        <div class="divide-y divide-gray-100">

                            @foreach($package->items as $item)

                                <div class="p-4 flex items-center gap-4">


                                    {{-- Product Image --}}
                                    <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">

                                        @if($item->product && $item->product->image)

                                            <img
                                                src="{{ url('uploads/products', $item->product->image) }}"
                                                class="w-full h-full object-cover"
                                                alt="{{ $item->product->name }}"
                                            >

                                        @else

                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <i class="fa-solid fa-box"></i>
                                            </div>

                                        @endif

                                    </div>


                                    {{-- Product --}}
                                    <div class="flex-1 min-w-0">

                                        <h3 class="font-semibold text-gray-800 truncate">

                                            {{ $item->product->name ?? 'Product unavailable' }}

                                        </h3>


                                        <p class="text-sm text-gray-500 mt-1">

                                            {{ $item->quantity }}
                                            {{ $item->product->unit ?? $item->unit }}

                                        </p>

                                    </div>


                                    {{-- Product Price --}}
                                    <div class="text-right">

                                        @if($item->product)

                                            <p class="font-semibold text-gray-700">

                                                ৳{{ number_format($item->product->price, 2) }}

                                            </p>

                                        @endif

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    RIGHT SUMMARY
                ================================================= --}}
                <div class="lg:col-span-1">

                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 sticky top-5 overflow-hidden"
                    >

                        <div class="px-5 py-4 bg-green-600 text-white">

                            <h2 class="font-bold text-lg">
                                Order Summary
                            </h2>

                        </div>


                        <div class="p-5">


                            {{-- Package Price --}}
                            <div class="flex justify-between text-sm mb-3">

                                <span class="text-gray-600">
                                    প্যাকেজ মূল্য
                                </span>

                                <span class="font-semibold text-gray-800">

                                    ৳{{ number_format($package->price, 2) }}

                                </span>

                            </div>


                            {{-- Discount --}}
                            @if($package->discount > 0)

                                <div class="flex justify-between text-sm mb-3">

                                    <span class="text-gray-600">
                                        Discount ({{ $package->discount }}%)
                                    </span>

                                    <span class="font-semibold text-red-500">

                                        -
                                        ৳{{
                                            number_format(
                                                ($package->price * $package->discount) / 100,
                                                2
                                            )
                                        }}

                                    </span>

                                </div>

                            @endif


                            <div class="border-t border-dashed border-gray-200 my-4"></div>


                            {{-- Total --}}
                            <div class="flex justify-between items-center">

                                <span class="font-bold text-gray-800">
                                    মোট
                                </span>

                                <span class="text-2xl font-bold text-green-600">

                                    ৳{{
                                        number_format(
                                            $package->price -
                                            (($package->price * $package->discount) / 100),
                                            2
                                        )
                                    }}

                                </span>

                            </div>


                            {{-- COD --}}
                            <div class="mt-5 bg-green-50 rounded-xl p-3">

                                <div class="flex items-center gap-2 text-green-700">

                                    <i class="fa-solid fa-money-bill-wave"></i>

                                    <span class="text-sm font-semibold">
                                        Cash on Delivery
                                    </span>

                                </div>

                            </div>


                            {{-- Confirm --}}
                            <button
                                type="submit"
                                id="submitOrderButton"
                                class="w-full mt-5 bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 px-4 rounded-xl transition flex items-center justify-center gap-2"
                            >

                                <i class="fa-solid fa-check"></i>

                                প্যাকেজ অর্ডার করুন

                            </button>


                            <p class="text-xs text-gray-400 text-center mt-3">
                                অর্ডার করার আগে আপনার তথ্যগুলো যাচাই করুন।
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection


@section('scripts')

{{-- =========================================================
    JQUERY
========================================================= --}}

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


{{-- =========================================================
    SELECT2 JS
========================================================= --}}

<script
    src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"
></script>


<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | ELEMENTS
    |--------------------------------------------------------------------------
    */

    const ownTab = document.getElementById('ownCustomerTab');
    const otherTab = document.getElementById('otherCustomerTab');

    const ownSection = document.getElementById('ownCustomerSection');
    const otherSection = document.getElementById('otherCustomerSection');

    const customerIdInput = document.getElementById('customer_id');

    const selectedCustomerInfo =
        document.getElementById('selectedCustomerInfo');

    const selectedCustomerName =
        document.getElementById('selectedCustomerName');

    const selectedCustomerId =
        document.getElementById('selectedCustomerId');

    const selectedCustomerPhone =
        document.getElementById('selectedCustomerPhone');

    const selectedCustomerAddress =
        document.getElementById('selectedCustomerAddress');

    const deliveryCustomerName =
        document.getElementById('deliveryCustomerName');

    const deliveryCustomerPhone =
        document.getElementById('deliveryCustomerPhone');

    const deliveryCustomerAddress =
        document.getElementById('deliveryCustomerAddress');

    const deliveryCustomerNote =
        document.getElementById('deliveryCustomerNote');

    const packagePurchaseForm =
        document.getElementById('packagePurchaseForm');

    const customerSelect =
        $('#referral_customer_select');


    /*
    |--------------------------------------------------------------------------
    | CHECK
    |--------------------------------------------------------------------------
    */

    if (
        !ownTab ||
        !otherTab ||
        !ownSection ||
        !otherSection ||
        !customerIdInput ||
        !packagePurchaseForm ||
        !customerSelect.length
    ) {
        console.error('Package purchase elements পাওয়া যায়নি।');
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | SELECT2 INITIALIZE
    |--------------------------------------------------------------------------
    */

    customerSelect.select2({

        placeholder: 'Customer নির্বাচন করুন',

        allowClear: true,

        width: '100%',

        dropdownParent: $('#otherCustomerSection'),

        language: {

            searching: function () {
                return 'খোঁজা হচ্ছে...';
            },

            noResults: function () {
                return 'কোনো Customer পাওয়া যায়নি';
            },

            inputTooShort: function () {
                return 'Customer খুঁজতে লিখুন';
            }

        }

    });


    /*
    |--------------------------------------------------------------------------
    | TAB STYLE
    |--------------------------------------------------------------------------
    */

    function activateTab(activeTab, inactiveTab) {

        activeTab.classList.add(
            'active',
            'bg-white',
            'text-green-700',
            'shadow-sm'
        );

        activeTab.classList.remove(
            'text-gray-500'
        );


        inactiveTab.classList.remove(
            'active',
            'bg-white',
            'text-green-700',
            'shadow-sm'
        );

        inactiveTab.classList.add(
            'text-gray-500'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CLEAR SELECTED CUSTOMER
    |--------------------------------------------------------------------------
    */

    function clearSelectedCustomer() {

        customerIdInput.value = '';

        selectedCustomerInfo.classList.add('hidden');

        selectedCustomerName.textContent = '';

        selectedCustomerId.textContent = '';

        selectedCustomerPhone.textContent = '';

        selectedCustomerAddress.textContent = '';


        deliveryCustomerName.value = '';

        deliveryCustomerPhone.value = '';

        deliveryCustomerAddress.value = '';

        deliveryCustomerNote.classList.add('hidden');

    }


    /*
    |--------------------------------------------------------------------------
    | OWN CUSTOMER
    |--------------------------------------------------------------------------
    */

    function loadOwnCustomer() {

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT
        | Own purchase হলে logged-in user's DB ID যাবে
        |--------------------------------------------------------------------------
        */

        customerIdInput.value = "{{ auth()->id() }}";


        ownSection.classList.remove('hidden');

        otherSection.classList.add('hidden');


        activateTab(
            ownTab,
            otherTab
        );


        /*
        |--------------------------------------------------------------------------
        | Clear referral selection
        |--------------------------------------------------------------------------
        */

        customerSelect.val(null).trigger('change');


        clearSelectedCustomer();

        /*
        |--------------------------------------------------------------------------
        | Again set own ID
        | কারণ clearSelectedCustomer() উপরের ID clear করেছে
        |--------------------------------------------------------------------------
        */

        customerIdInput.value = "{{ auth()->id() }}";

    }


    /*
    |--------------------------------------------------------------------------
    | OTHER CUSTOMER
    |--------------------------------------------------------------------------
    */

    function loadOtherCustomer() {

        ownSection.classList.add('hidden');

        otherSection.classList.remove('hidden');


        activateTab(
            otherTab,
            ownTab
        );


        /*
        |--------------------------------------------------------------------------
        | Other customer হলে আগে কোনো customer selected থাকবে না
        |--------------------------------------------------------------------------
        */

        customerIdInput.value = '';

        customerSelect.val(null).trigger('change');

        clearSelectedCustomer();

    }


    /*
    |--------------------------------------------------------------------------
    | GLOBAL TAB FUNCTION
    |--------------------------------------------------------------------------
    */

    window.selectPurchaseType = function (type) {

        if (type === 'own') {

            loadOwnCustomer();

        }

        if (type === 'other') {

            loadOtherCustomer();

        }

    };


    /*
    |--------------------------------------------------------------------------
    | SELECT2 CUSTOMER CHANGE
    |--------------------------------------------------------------------------
    */

    customerSelect.on('change', function () {

        const selectedOption =
            this.options[this.selectedIndex];


        /*
        |--------------------------------------------------------------------------
        | No customer selected
        |--------------------------------------------------------------------------
        */

        if (!this.value) {

            clearSelectedCustomer();

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | DB USER ID
        |--------------------------------------------------------------------------
        */

        customerIdInput.value = this.value;


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER DATA
        |--------------------------------------------------------------------------
        */

        const name =
            selectedOption.dataset.name || '';

        const customerId =
            selectedOption.dataset.customerId || '';

        const phone =
            selectedOption.dataset.phone || '';

        const address =
            selectedOption.dataset.address || 'ঠিকানা দেওয়া হয়নি';


        /*
        |--------------------------------------------------------------------------
        | SELECTED CUSTOMER CARD
        |--------------------------------------------------------------------------
        */

        selectedCustomerName.textContent =
            name;

        selectedCustomerId.textContent =
            customerId
                ? 'Customer ID: ' + customerId
                : '';

        selectedCustomerPhone.textContent =
            phone
                ? 'মোবাইল: ' + phone
                : '';

        selectedCustomerAddress.textContent =
            'ঠিকানা: ' + address;


        selectedCustomerInfo.classList.remove(
            'hidden'
        );


        /*
        |--------------------------------------------------------------------------
        | DELIVERY INFORMATION
        |--------------------------------------------------------------------------
        */

        deliveryCustomerName.value =
            name;

        deliveryCustomerPhone.value =
            phone;

        deliveryCustomerAddress.value =
            address;


        deliveryCustomerNote.classList.remove(
            'hidden'
        );

    });


    /*
    |--------------------------------------------------------------------------
    | FORM SUBMIT VALIDATION
    |--------------------------------------------------------------------------
    */

    packagePurchaseForm.addEventListener(
        'submit',
        function (event) {

            const otherIsActive =
                !otherSection.classList.contains('hidden');


            /*
            |--------------------------------------------------------------------------
            | Other customer হলে customer অবশ্যই select করতে হবে
            |--------------------------------------------------------------------------
            */

            if (
                otherIsActive &&
                !customerIdInput.value
            ) {

                event.preventDefault();


                alert(
                    'অনুগ্রহ করে একজন Customer নির্বাচন করুন।'
                );


                customerSelect.select2('open');


                return false;

            }


            /*
            |--------------------------------------------------------------------------
            | Own customer হলে logged-in user ID
            |--------------------------------------------------------------------------
            */

            if (
                !otherIsActive &&
                !customerIdInput.value
            ) {

                customerIdInput.value =
                    "{{ auth()->id() }}";

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | DEFAULT = OWN CUSTOMER
    |--------------------------------------------------------------------------
    */

    loadOwnCustomer();

});

</script>


@endsection