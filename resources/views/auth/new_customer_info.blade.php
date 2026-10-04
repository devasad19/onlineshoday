@extends('apps.front_master')

@section('title', 'Customer Information')

@section('content')

<div class="min-h-screen bg-gray-50 py-8">

    <div class="max-w-2xl mx-auto px-4">

        {{-- Success --}}
        @if(session('success'))

            <div class="mb-5 bg-green-50 border border-green-200
                        text-green-700 rounded-xl p-4">

                <div class="flex items-start gap-3">

                    <i class="fa-solid fa-circle-check text-xl mt-0.5"></i>

                    <div>
                        <p class="font-bold">
                            সফল হয়েছে
                        </p>

                        <p class="text-sm mt-1">
                            {{ session('success') }}
                        </p>
                    </div>

                </div>

            </div>

        @endif


        {{-- Customer Card --}}
        <div class="bg-white rounded-2xl shadow-sm
                    border border-gray-100 overflow-hidden">


            {{-- Header --}}
            <div class="bg-green-600 text-white px-6 py-5">

                <div class="flex items-center gap-3">

                    <div class="w-12 h-12 rounded-full
                                bg-white/20
                                flex items-center justify-center">

                        <i class="fa-solid fa-user-check text-xl"></i>

                    </div>

                    <div>

                        <h1 class="text-xl font-bold">
                            Customer Account তৈরি হয়েছে
                        </h1>

                        <p class="text-green-100 text-sm mt-1">
                            Customer-এর তথ্যগুলো সংরক্ষণ করা হয়েছে।
                        </p>

                    </div>

                </div>

            </div>



            {{-- Customer Information --}}
            <div class="p-6">

                <div class="space-y-4">


                    {{-- Customer ID --}}
                    <div class="bg-green-50 border border-green-100
                                rounded-xl p-4">

                        <p class="text-xs text-gray-500 mb-1">
                            Customer ID
                        </p>

                        <p class="text-2xl font-bold text-green-700 tracking-wider">

                            {{ $customer->customer_id }}

                        </p>

                    </div>



                    {{-- Name --}}
                    <div class="flex items-center justify-between
                                border-b border-gray-100 pb-3">

                        <span class="text-gray-500 text-sm">
                            নাম
                        </span>

                        <span class="font-semibold text-gray-800">
                            {{ $customer->name }}
                        </span>

                    </div>



                    {{-- Father Name --}}
                    <div class="flex items-center justify-between
                                border-b border-gray-100 pb-3">

                        <span class="text-gray-500 text-sm">
                            পিতার নাম
                        </span>

                        <span class="font-semibold text-gray-800">
                            {{ $customer->father_name }}
                        </span>

                    </div>



                    {{-- Phone --}}
                    <div class="flex items-center justify-between
                                border-b border-gray-100 pb-3">

                        <span class="text-gray-500 text-sm">
                            মোবাইল
                        </span>

                        <span class="font-semibold text-gray-800">
                            {{ $customer->phone }}
                        </span>

                    </div>



                    {{-- Father Phone --}}
                    @if($customer->father_phone)

                        <div class="flex items-center justify-between
                                    border-b border-gray-100 pb-3">

                            <span class="text-gray-500 text-sm">
                                পিতার মোবাইল
                            </span>

                            <span class="font-semibold text-gray-800">
                                {{ $customer->father_phone }}
                            </span>

                        </div>

                    @endif



                    {{-- Address --}}
                    <div class="border-b border-gray-100 pb-3">

                        <p class="text-gray-500 text-sm mb-1">
                            ঠিকানা
                        </p>

                        <p class="font-semibold text-gray-800">

                            {{ $customer->address ?: 'ঠিকানা দেওয়া হয়নি' }}

                        </p>

                    </div>

                </div>



                {{-- Important Note --}}
                <div class="mt-6 bg-yellow-50 border border-yellow-200
                            rounded-xl p-4">

                    <div class="flex gap-3">

                        <i class="fa-solid fa-circle-info
                                  text-yellow-600 mt-0.5"></i>

                        <div>

                            <p class="font-semibold text-gray-800">
                                Customer ID সংরক্ষণ করুন
                            </p>

                            <p class="text-sm text-gray-600 mt-1">
                                ভবিষ্যতে Package বা অন্যান্য সেবা নেওয়ার সময়
                                এই Customer ID প্রয়োজন হতে পারে।
                            </p>

                        </div>

                    </div>

                </div>



                {{-- Buttons --}}
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">


                    {{-- Back to Package --}}
                    @if($packageId)

                        <a href="{{ route('packages.purchase', $packageId) }}"
                           class="inline-flex items-center justify-center
                                  gap-2 bg-green-600 hover:bg-green-700
                                  text-white font-bold
                                  py-3.5 px-4 rounded-xl
                                  transition">

                            <i class="fa-solid fa-arrow-left"></i>

                            আগের Package Purchase

                        </a>

                    @endif



                    {{-- Home --}}
                    <a href="{{ route('front_home') }}"
                       class="inline-flex items-center justify-center
                              gap-2 bg-gray-100 hover:bg-gray-200
                              text-gray-700 font-semibold
                              py-3.5 px-4 rounded-xl
                              transition">

                        <i class="fa-solid fa-house"></i>

                        Home

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

