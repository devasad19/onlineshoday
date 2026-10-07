@extends('apps.front_master')

@section('content')

<!-- ================= HERO ================= -->
<section class="bg-gradient-to-br from-green-50 via-white to-orange-50
                border-b border-green-100">

    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 sm:py-14">

        <div class="text-center max-w-3xl mx-auto">

            <div class="inline-flex items-center gap-2
                        bg-green-100 text-green-700
                        px-4 py-2 rounded-full
                        text-xs sm:text-sm font-semibold">
                🎁 Online Shoday Rewards
            </div>

            <h1 class="mt-5 text-3xl sm:text-4xl lg:text-5xl
                       font-extrabold text-gray-800 leading-tight">
                কম্বো প্যাক কিনুন,
                <span class="text-green-600">পয়েন্ট সংগ্রহ করুন</span>
            </h1>

            <p class="mt-4 text-sm sm:text-base lg:text-lg
                      text-gray-600 leading-7 max-w-2xl mx-auto">
                নিজের প্রয়োজনের জন্য কম্বো প্যাক কিনুন,
                অথবা আপনার পরিচিত কাউকে কম্বো প্যাক কিনতে সাহায্য করুন।
                নিয়ম অনুযায়ী উভয় ক্ষেত্রেই পয়েন্ট পাওয়ার সুযোগ রয়েছে।
            </p>

            <div class="flex flex-wrap justify-center gap-3 mt-6">

                <a href="{{ route('home.package.all') }}"
                   class="inline-flex items-center gap-2
                          bg-green-600 hover:bg-green-700
                          text-white px-5 py-2.5
                          rounded-xl font-semibold text-sm
                          shadow-sm transition">
                    🛒 কম্বো প্যাক দেখুন
                </a>

                <a href="#how-it-works"
                   class="inline-flex items-center gap-2
                          bg-white hover:bg-green-50
                          text-green-700
                          border border-green-200
                          px-5 py-2.5
                          rounded-xl font-semibold text-sm
                          transition">
                    ℹ️ কীভাবে কাজ করে?
                </a>

            </div>
        </div>

    </div>
</section>


<!-- ================= QUICK SUMMARY ================= -->
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-10">

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

        <div class="bg-white border border-green-100
                    rounded-2xl p-5 shadow-sm text-center">
            <div class="w-16 h-16 mx-auto rounded-full
                        bg-green-100 flex items-center
                        justify-center text-2xl">
                <img class="w-16 h-16 p-3 items-center group transition-all" src="{{ url('public/default/combo-icons/combo_list.png') }}" alt="">
            </div>

            <h3 class="font-bold text-gray-800 mt-3">
                নিজে কিনুন
            </h3>

            <p class="text-xs sm:text-sm text-gray-500 mt-1 leading-5">
                নিজের প্রয়োজনের কম্বো প্যাক কিনে
                নিয়ম অনুযায়ী পয়েন্ট সংগ্রহ করুন।
            </p>
        </div>


        <div class="bg-white border border-orange-100
                    rounded-2xl p-5 shadow-sm text-center">
            <div class="w-16 h-16 mx-auto rounded-full
                        bg-green-100 flex items-center
                        justify-center text-2xl">
                <img class="w-16 h-16 p-3 items-center group transition-all" src="{{ url('public/default/combo-icons/pkg_buy_help.png') }}" alt="">
            </div>

            <h3 class="font-bold text-gray-800 mt-3">
                অন্যকে কিনতে সাহায্য করুন
            </h3>

            <p class="text-xs sm:text-sm text-gray-500 mt-1 leading-5">
                আপনার মাধ্যমে অন্য কেউ কম্বো প্যাক কিনলে
                নিয়ম অনুযায়ী রিওয়ার্ড পয়েন্ট পেতে পারেন।
            </p>
        </div>


        <div class="bg-white border border-blue-100
                    rounded-2xl p-5 shadow-sm text-center">
            <div class="w-16 h-16 mx-auto rounded-full
                        bg-green-100 flex items-center
                        justify-center text-2xl">
                <img class="w-16 h-16 p-3 items-center group transition-all" src="{{ url('public/default/combo-icons/shopping_by_points.png') }}" alt="">
            </div>

            <h3 class="font-bold text-gray-800 mt-3">
                পয়েন্ট সংগ্রহ করুন
            </h3>

            <p class="text-xs sm:text-sm text-gray-500 mt-1 leading-5">
                আপনার অ্যাকাউন্টে জমা হওয়া পয়েন্ট
                পরবর্তীতে প্রযোজ্য সুবিধায় ব্যবহার করতে পারবেন।
            </p>
        </div>

    </div>
</section>


<!-- ================= HOW IT WORKS ================= -->
<section id="how-it-works"
         class="bg-gray-50 border-y border-gray-100">

    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 sm:py-14">

        <div class="text-center mb-8 sm:mb-10">

            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">
                🔄 কীভাবে পয়েন্ট পাবেন?
            </h2>

            <p class="text-sm text-gray-500 mt-2">
                বিষয়টি খুবই সহজ
            </p>

        </div>


        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

            <!-- SELF PURCHASE -->
            <div class="bg-white rounded-2xl
                        border border-green-100
                        shadow-sm overflow-hidden">

                <div class="bg-green-600 text-white px-5 py-4">

                    <div class="flex items-center gap-3">
                        <div class="w-16 h-16 rounded-xl
                                    bg-white/20
                                    flex items-center justify-center
                                    text-2xl">
                            <img class="w-16 h-16 p-3 items-center group transition-all" src="{{ url('public/default/combo-icons/combo.png') }}" alt="">
                        </div>

                        <div>
                            <h3 class="font-bold text-lg">
                                ১. নিজে কম্বো প্যাক কিনলে
                            </h3>

                            <p class="text-xs text-green-100">
                                নিজের প্রয়োজন মেটানোর পাশাপাশি পয়েন্ট
                            </p>
                        </div>
                    </div>

                </div>


                <div class="p-5">

                    <div class="flex gap-3">

                        <div class="w-8 h-8 rounded-full
                                    bg-green-100 text-green-700
                                    flex-shrink-0
                                    flex items-center justify-center
                                    font-bold">
                            ১
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-800">
                                একটি কম্বো প্যাক নির্বাচন করুন
                            </h4>

                            <p class="text-sm text-gray-500 mt-1 leading-6">
                                আপনার প্রয়োজন অনুযায়ী পছন্দের কম্বো প্যাক
                                বেছে নিন।
                            </p>
                        </div>

                    </div>


                    <div class="flex gap-3 mt-5">

                        <div class="w-8 h-8 rounded-full
                                    bg-green-100 text-green-700
                                    flex-shrink-0
                                    flex items-center justify-center
                                    font-bold">
                            ২
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-800">
                                অর্ডার সম্পন্ন করুন
                            </h4>

                            <p class="text-sm text-gray-500 mt-1 leading-6">
                                আপনার ঠিকানা ও প্রয়োজনীয় তথ্য দিয়ে
                                অর্ডার সম্পন্ন করুন।
                            </p>
                        </div>

                    </div>


                    <div class="flex gap-3 mt-5">

                        <div class="w-8 h-8 rounded-full
                                    bg-green-100 text-green-700
                                    flex-shrink-0
                                    flex items-center justify-center
                                    font-bold">
                            ৩
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-800">
                                অর্ডার সফল হলে পয়েন্ট
                            </h4>

                            <p class="text-sm text-gray-500 mt-1 leading-6">
                                নির্ধারিত নিয়ম অনুযায়ী অর্ডার সম্পন্ন হলে
                                আপনার অ্যাকাউন্টে পয়েন্ট যোগ হবে।
                            </p>
                        </div>

                    </div>


                    <div class="mt-5 bg-green-50
                                border border-green-100
                                rounded-xl p-4">

                        <div class="flex items-center gap-2
                                    text-green-700 font-semibold text-sm">
                            ⭐ আপনার নিজের কেনাকাটাতেও পয়েন্ট!
                        </div>

                        <p class="text-xs text-gray-600 mt-1 leading-5">
                            পয়েন্ট কত হবে তা সংশ্লিষ্ট কম্বো প্যাক ও
                            বর্তমান নিয়ম অনুযায়ী নির্ধারিত হবে।
                        </p>

                    </div>

                </div>
            </div>


            <!-- REFERRAL PURCHASE -->
            <div class="bg-white rounded-2xl
                        border border-orange-100
                        shadow-sm overflow-hidden">

                <div class="bg-orange-500 text-white px-5 py-4">

                    <div class="flex items-center gap-3">
                        <div class="w-16 h-16 rounded-xl
                                    bg-white/20
                                    flex items-center justify-center
                                    text-2xl">
                            <img class="w-16 h-16 p-3 items-center group transition-all" src="{{ url('public/default/combo-icons/package_advantage.png') }}" alt="">
                        </div>

                        <div>
                            <h3 class="font-bold text-lg">
                                ২. অন্যকে কিনতে সাহায্য করলে
                            </h3>

                            <p class="text-xs text-orange-100">
                                আপনার মাধ্যমে নতুন অর্ডার
                            </p>
                        </div>
                    </div>

                </div>


                <div class="p-5">

                    <div class="flex gap-3">

                        <div class="w-8 h-8 rounded-full
                                    bg-orange-100 text-orange-700
                                    flex-shrink-0
                                    flex items-center justify-center
                                    font-bold">
                            ১
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-800">
                                আপনার রেফারেল শেয়ার করুন
                            </h4>

                            <p class="text-sm text-gray-500 mt-1 leading-6">
                                আপনার দেওয়া রেফারেল লিংক/কোডের মাধ্যমে
                                পরিচিত কাউকে কম্বো প্যাক সম্পর্কে জানান।
                            </p>
                        </div>

                    </div>


                    <div class="flex gap-3 mt-5">

                        <div class="w-8 h-8 rounded-full
                                    bg-orange-100 text-orange-700
                                    flex-shrink-0
                                    flex items-center justify-center
                                    font-bold">
                            ২
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-800">
                                তিনি কম্বো প্যাক অর্ডার করবেন
                            </h4>

                            <p class="text-sm text-gray-500 mt-1 leading-6">
                                আপনার রেফারেল অনুসরণ করে তিনি অর্ডার
                                সম্পন্ন করবেন।
                            </p>
                        </div>

                    </div>


                    <div class="flex gap-3 mt-5">

                        <div class="w-8 h-8 rounded-full
                                    bg-orange-100 text-orange-700
                                    flex-shrink-0
                                    flex items-center justify-center
                                    font-bold">
                            ৩
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-800">
                                অর্ডার সফল হলে রিওয়ার্ড
                            </h4>

                            <p class="text-sm text-gray-500 mt-1 leading-6">
                                প্রযোজ্য নিয়ম পূরণ হলে আপনার অ্যাকাউন্টে
                                রেফারেল পয়েন্ট/রিওয়ার্ড যোগ হতে পারে।
                            </p>
                        </div>

                    </div>


                    <div class="mt-5 bg-orange-50
                                border border-orange-100
                                rounded-xl p-4">

                        <div class="flex items-center gap-2
                                    text-orange-700 font-semibold text-sm">
                            🎁 পরিচিতদের জানান, পয়েন্ট সংগ্রহ করুন
                        </div>

                        <p class="text-xs text-gray-600 mt-1 leading-5">
                            রিওয়ার্ড পাওয়ার জন্য অর্ডারটি অবশ্যই
                            প্রযোজ্য নিয়ম অনুযায়ী সম্পন্ন হতে হবে।
                        </p>

                    </div>

                </div>
            </div>

        </div>

    </div>
</section>


<!-- ================= POINT EXAMPLE ================= -->
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-10 sm:py-14">

 
<div class="text-center mb-7">

    <h2 class="flex items-center justify-center gap-2 text-2xl sm:text-2xl font-bold text-green-700">

        <img
            class="w-12 h-12 sm:w-14 sm:h-14 object-contain flex-shrink-0"
            src="{{ url('public/default/combo-icons/package_advantage.png') }}"
            alt="কম্বো প্যাক"
        >

        <span>
            সহজ একটি উদাহরণ
        </span>

    </h2>

    <p class="text-sm text-gray-500 mt-2">
        পয়েন্ট কীভাবে জমতে পারে—একটি সহজ ধারণা
    </p>

</div>
 



    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="rounded-2xl bg-green-50
                    border border-green-100 p-5 text-center">

            <div class="text-3xl">🛒</div>

            <h3 class="font-bold text-gray-800 mt-3">
                আপনি কিনলেন
            </h3>

            <p class="text-sm text-gray-600 mt-2">
                ১টি কম্বো প্যাক
            </p>

            <div class="mt-3 text-green-700
                        font-bold text-lg">
                + নিজের পয়েন্ট
            </div>

        </div>


        <div class="rounded-2xl bg-orange-50
                    border border-orange-100 p-5 text-center">

            <div class="text-3xl">👨‍👩‍👧</div>

            <h3 class="font-bold text-gray-800 mt-3">
                পরিচিত একজন কিনলেন
            </h3>

            <p class="text-sm text-gray-600 mt-2">
                আপনার রেফারেল দিয়ে
            </p>

            <div class="mt-3 text-orange-700
                        font-bold text-lg">
                + রেফারেল পয়েন্ট
            </div>

        </div>


        <div class="rounded-2xl bg-blue-50
                    border border-blue-100 p-5 text-center">

            <div class="text-3xl">⭐</div>

            <h3 class="font-bold text-gray-800 mt-3">
                পয়েন্ট জমবে
            </h3>

            <p class="text-sm text-gray-600 mt-2">
                নিয়ম অনুযায়ী আপনার অ্যাকাউন্টে
            </p>

            <div class="mt-3 text-blue-700
                        font-bold text-lg">
                পয়েন্ট + রিওয়ার্ড
            </div>

        </div>

    </div>

</section>


<!-- ================= IMPORTANT RULES ================= -->
<section class="bg-gray-50 border-y border-gray-100">

    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-10 sm:py-12">

        <div class="bg-white rounded-2xl
                    border border-yellow-100
                    shadow-sm p-5 sm:p-7">

            <div class="flex items-start gap-3">

                <div class="w-11 h-11 rounded-xl
                            bg-yellow-100
                            flex items-center justify-center
                            text-2xl flex-shrink-0">
                    ⚠️
                </div>

                <div>

                    <h2 class="text-xl sm:text-2xl
                               font-bold text-gray-800">
                        গুরুত্বপূর্ণ নিয়ম
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        পয়েন্ট ও রিওয়ার্ড ব্যবহারের আগে নিয়মগুলো জেনে নিন।
                    </p>

                </div>

            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-6">

                <div class="flex gap-2 bg-gray-50 rounded-xl p-3">
                    <span class="text-green-600">✓</span>
                    <p class="text-xs sm:text-sm text-gray-600">
                        অর্ডার সফলভাবে সম্পন্ন হওয়ার পর প্রযোজ্য পয়েন্ট
                        যোগ করা হবে।
                    </p>
                </div>

                <div class="flex gap-2 bg-gray-50 rounded-xl p-3">
                    <span class="text-green-600">✓</span>
                    <p class="text-xs sm:text-sm text-gray-600">
                        বাতিল বা অসম্পূর্ণ অর্ডারের ক্ষেত্রে পয়েন্ট
                        প্রযোজ্য নাও হতে পারে।
                    </p>
                </div>

                <div class="flex gap-2 bg-gray-50 rounded-xl p-3">
                    <span class="text-green-600">✓</span>
                    <p class="text-xs sm:text-sm text-gray-600">
                        একই ব্যক্তি বা একই অর্ডার নিয়ে একাধিকবার
                        পয়েন্ট দাবি করা যাবে না।
                    </p>
                </div>

                <div class="flex gap-2 bg-gray-50 rounded-xl p-3">
                    <span class="text-green-600">✓</span>
                    <p class="text-xs sm:text-sm text-gray-600">
                        পয়েন্টের পরিমাণ ও ব্যবহারের নিয়ম সময়ের সাথে
                        পরিবর্তন হতে পারে।
                    </p>
                </div>

            </div>


            <div class="mt-5 p-4 rounded-xl
                        bg-red-50 border border-red-100">

                <p class="text-xs sm:text-sm text-red-700 leading-6">
                    <strong>সতর্কতা:</strong>
                    পয়েন্ট বা রিওয়ার্ড পাওয়ার জন্য কোনো ধরনের
                    ভুয়া অর্ডার, ভুল তথ্য বা নিয়মের অপব্যবহার করা যাবে না।
                    এমন কোনো কার্যক্রম ধরা পড়লে সংশ্লিষ্ট পয়েন্ট
                    বাতিল করা হতে পারে।
                </p>

            </div>

        </div>

    </div>

</section>


<!-- ================= CONTACT ================= -->
<section class="max-w-5xl mx-auto px-4 sm:px-6 py-10 sm:py-14">

    <div class="relative overflow-hidden
                bg-gradient-to-r from-green-600 to-green-700
                rounded-2xl sm:rounded-3xl
                p-6 sm:p-8 lg:p-10 text-white">

        <div class="absolute -right-16 -top-16
                    w-48 h-48 rounded-full
                    bg-white/10"></div>

        <div class="absolute -left-16 -bottom-20
                    w-48 h-48 rounded-full
                    bg-white/10"></div>


        <div class="relative z-10">

            <div class="text-center">

                <div class="text-3xl">💬</div>

                <h2 class="text-2xl sm:text-3xl font-bold mt-3">
                    কোনো কিছু বুঝতে সমস্যা হচ্ছে?
                </h2>

                <p class="text-green-100 text-sm sm:text-base
                          mt-2 leading-6">
                    পয়েন্ট, রেফারেল, অর্ডার বা রিওয়ার্ড সম্পর্কে
                    জানতে আমাদের সাথে যোগাযোগ করুন।
                </p>

            </div>


            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-7">

                <!-- PHONE -->
                <a href="tel:+8801710121044"
                   class="bg-white/10 hover:bg-white/20
                          border border-white/20
                          rounded-xl p-4 transition">

                    <div class="text-2xl">📞</div>

                    <div class="font-semibold mt-2">
                        ফোন করুন
                    </div>

                    <div class="text-xs text-green-100 mt-1">
                        01710-121044
                    </div>

                </a>


                <!-- WHATSAPP -->
                <a href="https://wa.me/8801710121044"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="bg-white/10 hover:bg-white/20
                          border border-white/20
                          rounded-xl p-4 transition">

                    <div class="text-2xl">💬</div>

                    <div class="font-semibold mt-2">
                        WhatsApp
                    </div>

                    <div class="text-xs text-green-100 mt-1">
                        সরাসরি মেসেজ করুন
                    </div>

                </a>


                <!-- FACEBOOK -->
                <a href="https://www.facebook.com/onlineshoday"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="bg-white/10 hover:bg-white/20
                          border border-white/20
                          rounded-xl p-4 transition">

                    <div class="text-2xl">ⓕ</div>

                    <div class="font-semibold mt-2">
                        Facebook
                    </div>

                    <div class="text-xs text-green-100 mt-1">
                        আমাদের পেজে যোগাযোগ করুন
                    </div>

                </a>

            </div>


            <div class="mt-6 pt-5 border-t border-white/20
                        text-center">

                <p class="text-xs text-green-100">
                    Online Shoday — সহজ বাজার, ঘরে ডেলিভারি
                </p>

            </div>

        </div>

    </div>

</section>

@endsection