@extends('apps.dashboard_master')

@section('title', 'রাইডার সেটিংস')

@section('content')

<div class="flex min-h-screen bg-gray-50">


<div class="flex-1 flex flex-col p-4">

    @include('backend.patrials.top_bar')


    <div class="max-w-5xl mx-auto w-full space-y-6">


        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

            <div class="flex items-center gap-4">

                @if($user->photo)

                    <img
                        src="{{ url('uploads/users/' . $user->photo) }}"
                        alt="{{ $user->name }}"
                        class="w-20 h-20 rounded-full object-cover border-4 border-green-100"
                    >

                @else

                    <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center text-3xl">
                        🚴
                    </div>

                @endif


                <div>

                    <h1 class="text-2xl font-bold text-gray-800">
                        Rider Settings
                    </h1>

                    <p class="text-gray-500 mt-1">
                        আপনার প্রোফাইল ও পাসওয়ার্ড পরিচালনা করুন
                    </p>

                </div>

            </div>

        </div>


        {{-- =====================================================
             ALERT
        ====================================================== --}}

        @include('alerts.alert')


        @if($errors->any())

            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4">

                <div class="font-semibold mb-2">
                    ⚠️ কিছু সমস্যা হয়েছে
                </div>

                <ul class="list-disc list-inside text-sm space-y-1">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- =====================================================
             PROFILE INFORMATION
        ====================================================== --}}

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

            <div class="mb-6">

                <h2 class="text-xl font-bold text-gray-800">
                    👤 প্রোফাইল তথ্য
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    আপনার ব্যক্তিগত তথ্য পরিবর্তন করতে পারবেন।
                </p>

            </div>


            <form
                action="{{ route('rider.settings.profile.update') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                    {{-- Name --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            পূর্ণ নাম *
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none"
                        >

                    </div>


                    {{-- Father Name --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            পিতার নাম *
                        </label>

                        <input
                            type="text"
                            name="father_name"
                            value="{{ old('father_name', $user->father_name) }}"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none"
                        >

                    </div>


                    {{-- Phone --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            নিজের ফোন নম্বর *
                        </label>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone', $user->phone) }}"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none"
                        >

                    </div>


                    {{-- Father Phone --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            পিতার ফোন নম্বর *
                        </label>

                        <input
                            type="text"
                            name="father_phone"
                            value="{{ old('father_phone', $user->father_phone) }}"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none"
                        >

                    </div>


                    {{-- Age --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            বয়স *
                        </label>

                        <input
                            type="number"
                            name="age"
                            value="{{ old('age', $rider->age ?? '') }}"
                            min="18"
                            max="70"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none"
                        >

                    </div>


                    {{-- Education --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            শিক্ষাগত যোগ্যতা *
                        </label>

                        <select
                            name="edu_qualification"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none"
                        >

                            <option value="">
                                -- নির্বাচন করুন --
                            </option>

                            <option
                                value="ssc নিচে"
                                {{ old('edu_qualification', $rider->edu_qualification ?? '') == 'ssc নিচে' ? 'selected' : '' }}
                            >
                                SSC এর নিচে
                            </option>

                            <option
                                value="ssc"
                                {{ old('edu_qualification', $rider->edu_qualification ?? '') == 'ssc' ? 'selected' : '' }}
                            >
                                SSC পাস
                            </option>

                            <option
                                value="hsc"
                                {{ old('edu_qualification', $rider->edu_qualification ?? '') == 'hsc' ? 'selected' : '' }}
                            >
                                HSC পাস
                            </option>

                            <option
                                value="honours"
                                {{ old('edu_qualification', $rider->edu_qualification ?? '') == 'honours' ? 'selected' : '' }}
                            >
                                Honours পাস
                            </option>

                        </select>

                    </div>


                    {{-- Institute --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            শিক্ষা প্রতিষ্ঠানের নাম
                        </label>

                        <input
                            type="text"
                            name="institute"
                            value="{{ old('institute', $rider->institute ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none"
                        >

                    </div>


                    {{-- Vehicle --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            যানবাহনের ধরন *
                        </label>

                        <select
                            name="vehicle_type"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none"
                        >

                            <option value="">
                                -- নির্বাচন করুন --
                            </option>

                            <option
                                value="bicycle"
                                {{ old('vehicle_type', $rider->vehicle_type ?? '') == 'bicycle' ? 'selected' : '' }}
                            >
                                সাইকেল
                            </option>

                            <option
                                value="motorcycle"
                                {{ old('vehicle_type', $rider->vehicle_type ?? '') == 'motorcycle' ? 'selected' : '' }}
                            >
                                মোটরসাইকেল
                            </option>

                            <option
                                value="van"
                                {{ old('vehicle_type', $rider->vehicle_type ?? '') == 'van' ? 'selected' : '' }}
                            >
                                ভ্যান
                            </option>

                        </select>

                    </div>


                    {{-- Address --}}
                    <div class="md:col-span-2">

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            ঠিকানা *
                        </label>

                        <textarea
                            name="address"
                            rows="3"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none"
                        >{{ old('address', $user->address) }}</textarea>

                    </div>


                    {{-- Photo --}}
                    <div class="md:col-span-2">

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            প্রোফাইল ছবি
                        </label>

                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">

                            @if($user->photo)

                                <img
                                    id="photoPreview"
                                    src="{{ url('uploads/users/' . $user->photo) }}"
                                    alt="Profile"
                                    class="w-24 h-24 rounded-xl object-cover border"
                                >

                            @else

                                <div
                                    id="photoPreviewBox"
                                    class="w-24 h-24 rounded-xl bg-gray-100 border flex items-center justify-center text-3xl"
                                >
                                    🚴
                                </div>

                                <img
                                    id="photoPreview"
                                    class="hidden w-24 h-24 rounded-xl object-cover border"
                                    alt="Preview"
                                >

                            @endif


                            <input
                                type="file"
                                name="photo"
                                accept="image/jpeg,image/png,image/jpg"
                                onchange="previewRiderPhoto(event)"
                                class="w-full sm:w-auto border border-gray-300 rounded-lg px-3 py-2"
                            >

                        </div>

                        <p class="text-xs text-gray-500 mt-2">
                            JPG, JPEG অথবা PNG। সর্বোচ্চ 2MB।
                        </p>

                    </div>

                </div>


                <div class="mt-6 pt-5 border-t border-gray-200 flex justify-end">

                    <button
                        type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg shadow-sm transition"
                    >
                        💾 তথ্য আপডেট করুন
                    </button>

                </div>

            </form>

        </div>


        {{-- =====================================================
             PASSWORD
        ====================================================== --}}

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

            <div class="mb-6">

                <h2 class="text-xl font-bold text-gray-800">
                    🔐 পাসওয়ার্ড পরিবর্তন
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    নিরাপত্তার জন্য পুরোনো পাসওয়ার্ড সঠিক হতে হবে।
                </p>

            </div>


            <form
                action="{{ route('rider.settings.password.update') }}"
                method="POST"
            >

                @csrf


                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">


                    {{-- Old Password --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            পুরোনো পাসওয়ার্ড *
                        </label>

                        <input
                            type="password"
                            name="old_password"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none"
                            placeholder="পুরোনো পাসওয়ার্ড"
                        >

                    </div>


                    {{-- New Password --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            নতুন পাসওয়ার্ড *
                        </label>

                        <input
                            type="password"
                            name="password"
                            required
                            minlength="6"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none"
                            placeholder="কমপক্ষে ৬ অক্ষর"
                        >

                    </div>


                    {{-- Confirm Password --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            নতুন পাসওয়ার্ড আবার লিখুন *
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            required
                            minlength="6"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none"
                            placeholder="নতুন পাসওয়ার্ড"
                        >

                    </div>

                </div>


                <div class="mt-6 pt-5 border-t border-gray-200 flex justify-end">

                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-sm transition"
                    >
                        🔑 পাসওয়ার্ড পরিবর্তন করুন
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


</div>

@endsection

@section('scripts')

<script>

function previewRiderPhoto(event)
{
    const file = event.target.files[0];

    if (!file) {
        return;
    }

    const preview = document.getElementById('photoPreview');
    const previewBox = document.getElementById('photoPreviewBox');

    if (preview) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
    }

    if (previewBox) {
        previewBox.classList.add('hidden');
    }
}

</script>

@endsection
