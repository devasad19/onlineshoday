@extends('apps.front_master')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- শিরোনাম -->
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-green-700 mb-3">📞 যোগাযোগ করুন</h2>
            <p class="text-gray-600 text-lg">আমাদের সঙ্গে যোগাযোগ করতে নিচের তথ্য বা ফর্মটি ব্যবহার করুন।</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- ✅ Success message --}}
            @if(session('success'))
                <div id="alert-message"
                     class="fixed top-5 right-5 z-50 w-auto max-w-sm bg-green-100 text-green-800 border border-green-300 rounded-lg shadow-lg p-4 opacity-0 -translate-y-5 transition-all duration-700 ease-in-out">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ❌ Error message --}}
            @if(session('error'))
                <div id="alert-message"
                     class="fixed top-5 right-5 z-50 w-auto max-w-sm bg-red-100 text-red-800 border border-red-300 rounded-lg shadow-lg p-4 opacity-0 -translate-y-5 transition-all duration-700 ease-in-out">
                    {{ session('error') }}
                </div>
            @endif


            <!-- যোগাযোগের তথ্য -->
            <div class="bg-white rounded-2xl shadow p-8">
                <h3 class="text-2xl font-semibold text-green-700 mb-6">📍 আমাদের ঠিকানা</h3>
                <div class="space-y-4 text-gray-700">
                    <div class="flex items-start gap-3">
                        <span class="text-green-600 text-xl">🏠</span>
                        <p>সঠিকপথ অফিস,<br>৩য় তলা, ময়মনসিংহ, বাংলাদেশ</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-green-600 text-xl">📞</span>
                        <p>+880 1XXX-XXXXXX</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-green-600 text-xl">✉️</span>
                        <p>support@sothikpath.com</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-green-600 text-xl">⏰</span>
                        <p>শনিবার - বৃহস্পতিবার: সকাল ৯টা - রাত ৮টা<br>শুক্রবার বন্ধ</p>
                    </div>
                </div>
            </div>

            <!-- যোগাযোগ ফর্ম -->
            <div class="bg-white rounded-2xl shadow p-8">
                <h3 class="text-2xl font-semibold text-green-700 mb-6">📝 মেসেজ পাঠান</h3>

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">নাম</label>
                        <input type="text" name="name" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-300">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">ইমেইল</label>
                        <input type="email" name="email" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-300">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">বিষয়</label>
                        <input type="text" name="subject" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-300">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">বার্তা</label>
                        <textarea name="message" rows="5" required
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-300"></textarea>
                    </div>

                    <div class="text-right">
                        <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                            ✉️ পাঠান
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

{{-- ✅ Success message fade-in + fade-out --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const alert = document.getElementById("alert-message");
    if (alert) {
        // Fade In (after slight delay)
        setTimeout(() => {
            alert.classList.remove("opacity-0", "-translate-y-5");
            alert.classList.add("opacity-100", "translate-y-0");
        }, 100);

        // Fade Out (after 4 seconds)
        setTimeout(() => {
            alert.classList.remove("opacity-100", "translate-y-0");
            alert.classList.add("opacity-0", "-translate-y-5");
        }, 4000);
    }
});
</script>
@endsection
