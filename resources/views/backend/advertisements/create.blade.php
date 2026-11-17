@extends('apps.dashboard_master')

@section('content')

<div class="flex min-h-screen bg-gray-50">

    <div class="flex-1 min-w-0">

        @include('backend.patrials.top_bar')

        <div class="p-4 md:p-6">

            <h2 class="text-2xl font-bold text-green-700 mb-6">
                নতুন বিজ্ঞাপন তৈরি করুন
            </h2>

            <form action="{{ route('admin.advertisements.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="bg-white rounded-xl shadow-sm p-5 md:p-7">

                @include('backend.advertisements._form')

            </form>

        </div>

    </div>

</div>

@endsection


@section('scripts')

<script>
 
document.addEventListener('DOMContentLoaded', function () {

    const adType = document.getElementById('ad_type');

    const providerName = document.getElementById('provider_name');
    const providerType = document.getElementById('provider_type');
    const location = document.getElementById('location');
    const phone = document.getElementById('phone');

    // Online Shoday নিজস্ব সেবার ডিফল্ট তথ্য
    const ownService = {
        providerName: 'অনলাইন সদায় নিজস্ব সেবা',
        providerType: 'অনলাইন সদায়',
        location: 'অনলাইন সদায় অফিস, চেয়ারম্যান মার্কেট, চেচুয়া বাজার',
        phone: '+88 01871 403041'
    };

    function updateProviderName() {

        if (adType.value === 'own_service') {

            providerName.value = ownService.providerName;
            providerType.value = ownService.providerType;
            location.value = ownService.location;
            phone.value = ownService.phone;

            // ইনপুট পরিবর্তন বন্ধ
            [providerName, providerType, location, phone].forEach(input => {
                input.readOnly = false;
                input.classList.add('bg-gray-100');
            });

        } else {

            // নিজস্ব সেবার স্বয়ংক্রিয় ভ্যালুগুলো সরানো
            if (providerName.value === ownService.providerName) {
                providerName.value = '';
            }

            if (providerType.value === ownService.providerType) {
                providerType.value = '';
            }

            if (location.value === ownService.location) {
                location.value = '';
            }

            if (phone.value === ownService.phone) {
                phone.value = '';
            }

            // ইনপুট আবার এডিট করা যাবে
            [providerName, providerType, location, phone].forEach(input => {
                input.readOnly = false;
                input.classList.remove('bg-gray-100');
            });
        }
    }

    adType.addEventListener('change', updateProviderName);

    // পেজ লোড হওয়ার সময়
    updateProviderName();

});
</script>
@endsection
