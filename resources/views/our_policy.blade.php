@extends('apps.front_master')

@section('content')

<section class="max-w-4xl mx-auto px-4 sm:px-6 md:px-6 py-6 sm:py-8 text-center">
    <div class="bg-white rounded-2xl shadow p-4 sm:p-6 md:p-6">

        <section class="bg-white rounded-2xl sm:p-6 md:p-6" aria-labelledby="policy-heading">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 sm:gap-6">
                <div>
                    <h2 id="policy-heading" class="text-2xl sm:text-3xl font-extrabold text-gray-800">আমাদের নীতিমালা</h2>
                    <p class="mt-2 text-gray-600 text-sm sm:text-base">
                        আপনি অনলাইন অর্ডার দিলে আমরা আপনার পরিবর্তে বাজার করে পণ্য আপনার দোরগোড়ায় পৌঁছে দিই — দ্রুত, নির্ভরযোগ্য এবং স্বচ্ছ।
                        নিচের নীতিগুলো আমাদের কাজের রূপরেখা ও আপনার জন্য গুরুত্বপূর্ণ নির্দেশনা ব্যাখ্যা করে।
                    </p>
                </div>
            </div>

            <hr class="my-5 sm:my-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

                <article class="prose max-w-none text-left" aria-labelledby="service-heading">

                    <div class="bg-white border mb-4 sm:mb-5 p-3 sm:p-4 rounded-lg shadow-sm">
                        <h4 class="font-semibold text-base sm:text-lg">১. আমাদের সেবা সম্পর্কে</h4>
                        <p class="mt-2 text-sm text-gray-600">
                            eBazar.com-এ আপনি অনলাইনে পণ্যের তালিকা (শপিং লিস্ট) পাঠালে আমাদের রাইডার/পার্টনার আপনার নিকটস্থ বাজার থেকে তা সংগ্রহ করে নির্ধারিত ঠিকানায় পৌঁছে দেবে।
                            আমরা বিশ্বাসযোগ্য দোকান ও সরবরাহকারীর সাথে কাজ করি এবং পণ্যের মান ও সততা নিশ্চিত করার চেষ্টা করি।
                        </p>
                    </div>

                    <div class="bg-green-50 border border-green-100 mb-4 sm:mb-5 p-3 sm:p-4 rounded-lg">
                        <h4 class="font-semibold text-base sm:text-lg">২. বাজারের মূল্য ও পরিবর্তনশীলতা</h4>
                        <p class="text-sm text-gray-700 mt-1">
                            কাঁচামাল, মাছ, মাংস, সবজি ইত্যাদি সময় ও বাজারের ওপর নির্ভর করে দামের ওঠানামা করেঃ তাই অনলাইন প্রদর্শিত মুল্য ও বাজারমূল্যের মাঝে সামান্য পার্থক্য
                            (সাধারণত প্রতি কেজিতে ৫-১০ টাকা পর্যন্ত) হতে পারে। রাইডার ক্রয় করার আগে আপনাকে প্রকৃত মূল্য জানিয়ে সম্মতি নেবে — আপনার অনুমোদন ব্যতীত অতিরিক্ত চার্জ আরোপ করা হবে না।
                        </p>
                    </div>

                    <div class="bg-white border border-green-100 p-3 sm:p-4 rounded-lg">
                        <h4 class="font-semibold text-base sm:text-lg">৩. অর্ডার সংশোধন ও ঘাটতি</h4>
                        <p class="text-sm text-gray-700 mt-1">
                            অর্ডার কনফার্ম করার পরও জরুরি কারণে পরিমাণ বা ব্র্যান্ড পরিবর্তন করতে হলে রাইডারকে বদলানোর অনুরোধ জানাতে পারেন।
                            যদি আপনার অর্ডার অনুযায়ী পণ্য পরিমাণ কমে থাকে বা কোন পণ্য অনুপস্থিত থাকে, আমরা দ্রুত খতিপূরণ (refund) অথবা ক্রেডিট হিসেবে পরবর্তী অর্ডারে সমন্বয় করব।
                            অভিযোগ প্রমাণিত হলে সংশ্লিষ্ট রাইডার বা বিক্রেতার বিরুদ্ধে প্রয়োজনীয় ব্যবস্থা নেওয়া হবে।
                        </p>
                    </div>
                </article>

                <aside class="space-y-4 sm:space-y-6" aria-labelledby="support-heading">

                    <div class="bg-green-50 border border-green-100 p-3 sm:p-4 rounded-lg">
                        <h4 class="font-semibold text-base sm:text-lg">৪. ডেলিভারি সময় ও অঙ্গীকার</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            আমরা নির্ধারিত সময়ে অর্ডার পৌঁছে দেওয়ার জন্য প্রতিশ্রুতিবদ্ধ। তবুও ট্রাফিক, আবহাওয়া, বা বাজারের অবস্থার কারণে বিলম্ব ঘটলে আমরা দ্রুততর ডেলিভারি নিশ্চিত করার জন্য কাজ করব।
                        </p>
                        <ul class="mt-3 text-sm text-gray-600 list-disc list-inside">
                            <li>ডেলিভারি ট্র্যাকিং ইন-অ্যাপ বা এসএমএসের মাধ্যমে প্রদান করা হতে পারে।</li>
                            <li>ডেলিভারির সময় রাইডারকে সঠিক নির্দেশনা ও সহজ প্রবেশাধিকার নিশ্চিত করুন।</li>
                        </ul>
                    </div>

                    <div class="bg-white border p-3 sm:p-4 rounded-lg shadow-sm">
                        <h4 class="font-semibold text-base sm:text-lg">৫. পেমেন্ট ও গ্রাহক সহযোগিতা</h4>
                        <ul class="mt-2 text-sm text-gray-600 list-disc list-inside">
                            <li>ডেলিভারি পাওয়ার পরে অনুগ্রহ করে সম্পূর্ণ বিল পরিশোধ করুন — রাইডারের সময় নষ্ট করবেন না।</li>
                            <li>পেমেন্ট পদ্ধতি: ক্যাশ অন ডেলিভারি (COD) বা অনলাইন পেমেন্ট (যদি উপলব্ধ)।</li>
                            <li>পেমেন্ট নিশ্চিত হলে অর্ডার "ডেলিভারড" হিসেবে চিহ্নিত হবে; কোনো ফেরত বা অভিযোগ পেলে আমাদের রিটার্ন/রিফাণ্ড প্রসেস অনুযায়ী করা হবে।</li>
                        </ul>
                    </div>

                    <div class="bg-green-50 border border-green-100 p-3 sm:p-4 rounded-lg">
                        <h4 class="font-semibold text-base sm:text-lg">৬. অভিযোগ, রিফান্ড ও যোগাযোগ</h4>
                        <p class="text-sm text-gray-600">
                            পণ্য বা সেবা সম্পর্কে কোনো অসন্তোষ থাকলে দ্রুত আমাদের কাস্টমার সাপোর্টে জানাতে পারেন — অভিযোগ যাচাই করে আমরা সম্ভাব্য দ্রুত সমাধান দেব।
                        </p>
                        <div class="mt-3 text-sm">
                            <p><strong>হেল্পলাইন:</strong> <a href="tel:01700000000" class="text-green-600 hover:underline">০১৭ - ০০০ ০০০০০</a></p>
                            <p><strong>ইমেইল:</strong> <a href="mailto:support@ebazar.com" class="text-green-600 hover:underline">support@ebazar.com</a></p>
                        </div>
                    </div>

                </aside>
            </div>

            <hr class="my-5 sm:my-6">

            <section class="space-y-4">
                <div class="bg-white border border-green-100 p-3 sm:p-4 rounded-lg">
                    <h4 class="font-semibold text-base sm:text-lg">৭. দায়-জবাব (Disclaimer)</h4>
                    <p class="text-sm text-gray-700 mt-1">
                        eBazar.com নিজে কোনো পণ্য উৎপাদন বা সরবরাহকারীর দায়ভার ধারণ করে না; আমরা কেবল আপনার হয়ে বাজার থেকে পণ্য সংগ্রহ করে সরবরাহ করি।
                        বাজারের দাম, পণ্যের মান বা বিক্রেতার প্রদত্ত ভুল তথ্যের জন্য চূড়ান্তভাবে বিক্রেতা বা বাজার দায়ী; তারপরও গ্রাহকের সন্তুষ্টি নিশ্চিত করতে আমরা সর্বাত্মক প্রচেষ্টা চালিয়ে যাব।
                    </p>
                </div>

                <div class="bg-green-50 border border-green-100 p-3 sm:p-4 rounded-lg">
                    <h4 class="font-semibold text-base sm:text-lg">৮. আমাদের অনুরোধ ও ব্যবহারিক টিপস</h4>
                    <ul class="list-disc list-inside text-sm text-gray-600 mt-1">
                        <li>রাইডার পৌঁছলে দয়া করে দ্রুত পেমেন্ট সম্পন্ন করুন এবং সময় নষ্ট না করার জন্য সহযোগিতা করুন।</li>
                        <li>অর্ডার কনফার্মেশন হবার পর পরিবর্তন সীমিত হতে পারে — জরুরি পরিবর্তনের জন্য যত দ্রুত সম্ভব আমাদের জানান।</li>
                        <li>বিশেষ দ্রষ্টব্য: পাকা, নরম বা সহজে নষ্ট হওয়া পণ্যের ক্ষেত্রে আমরা অতিরিক্ত যত্ন নেব, কিন্তু পরিবেশগত কারণে সামান্য অবনতি হতে পারে।</li>
                    </ul>
                </div>

                <div class="mt-4 text-xs sm:text-sm text-gray-500">
                    এই নীতিমালা সময়ের সঙ্গে পরিবর্তিত হতে পারে; যে কোন পরিবর্তন ওয়েবসাইটে প্রকাশিত হালনাগাদের তারিখ অনুযায়ী কার্যকর হবে।
                </div>
            </section>

        </section>
    </div>
</section>

@endsection
