@extends('apps.front_master')
@section('content')

<section class="max-w-3xl mx-auto px-6 py-16 text-center">
    <div class="bg-white rounded-2xl shadow p-10">
        <!-- ✅ Success Icon -->
        <div class="text-green-600 text-6xl mb-6">
            ✅
        </div>

        @if(session('orderId') == null)
            <h2 class="text-3xl font-bold text-green-700 mb-4">অর্ডার সফলভাবে সম্পন্ন হয়েছে!</h2>
            <p class="text-gray-600 mb-6">পুনরায় অর্ডার করুন! আমাদের ডেলিভারি টিম দ্রুত আপনার ঠিকানায় পৌঁছিয়ে দিবে, ইন শা আল্লাহ্‌।</p>
        @else
        <!-- 🎉 Success Message -->
            <h2 class="text-3xl font-bold text-green-700 mb-4">অর্ডার সফলভাবে সম্পন্ন হয়েছে!</h2>
            <p class="text-gray-600 mb-6">আপনার অর্ডার ধন্যবাদ! আমাদের ডেলিভারি টিম দ্রুত আপনার ঠিকানায় পৌঁছাবে।</p>

        <!-- 🆔 Order Details -->
        <div class="bg-gray-50 rounded-xl p-5 mb-6 text-left">
            <p class="text-gray-700"><span class="font-semibold">অর্ডার নম্বর:</span> #{{ session('orderId', '123456') }}</p>
            <p class="text-gray-700"><span class="font-semibold">মোট:</span> ৳{{ bnNum(session('total', 0)) }}</p>
            <p class="text-gray-700"><span class="font-semibold">ডেলিভারি ঠিকানা:</span> {{ session('address', 'রামাকানা, দুল্লা, চেচুয়ায় বাজার') }}</p>
            <p class="text-gray-700"><span class="font-semibold">মোবাইল নম্বর:</span> {{ session('phone', '০১২৪৭৮৮৫৫৫৫৫') }}</p>
        </div>
        @endif
        <!-- 🛍 Buttons -->
        <div class="flex justify-center gap-4">
            <a href="{{ route('front_home') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-semibold">
                হোমে ফিরে যান
            </a>
            <a href="{{ route('products.filter') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition font-semibold">
                আরও শপিং করুন
            </a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            timer: 2500,
            showConfirmButton: false,
            position: 'top-end',
            toast: true
        });
    @endif
});
</script>
@endsection
