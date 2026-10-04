@extends('apps.front_master')

@section('title', 'ব্যবহারকারী নিবন্ধন')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-green-50 py-12">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-lg p-8">
        <!-- Header -->
        <div class="text-center mb-6">
            <h2 class="text-3xl font-extrabold text-green-700">🧍 নতুন ব্যবহারকারী নিবন্ধন</h2>
            <p class="text-gray-600 mt-2">আপনার তথ্য দিয়ে একটি অ্যাকাউন্ট তৈরি করুন</p>
        </div>

@include('alerts.alert')

        <!-- Form -->
        <form action="{{ route('store.new.customer') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <input type="hidden" name="role_id" value="2">
            <input type="hidden" name="package_id" value="{{$package_id}}">
            <!-- নাম -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">নাম</label>
                <input type="text" name="name" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none"
                       placeholder="আপনার পূর্ণ নাম লিখুন">
            </div>

            <!-- পিতার নাম -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">পিতার নাম</label>
                <input type="text" name="father_name" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none"
                       placeholder="আপনার পিতার নাম লিখুন">
            </div>

            <!-- নিজের ফোন -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">নিজের ফোন নম্বর</label>
                <input type="text" name="phone" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none"
                       placeholder="01XXXXXXXXX">
            </div>

            <!-- পিতার ফোন -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">পিতার ফোন নম্বর</label>
                <input type="text" name="father_phone" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none"
                       placeholder="01XXXXXXXXX">
            </div>

            <!-- ঠিকানা -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">ঠিকানা</label>
                <textarea name="address" rows="2"
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none"
                          placeholder="বর্তমান ঠিকানা লিখুন"></textarea>
            </div>

            <!-- বাজার নির্বাচন -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">বাজার নির্বাচন করুন</label>
                <select name="bazar_id" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none">
                    <option value="">-- বাজার নির্বাচন করুন --</option>
                    @foreach($bazars as $bazar)
                        <option value="{{ $bazar->id }}">{{ $bazar->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- প্রোফাইল ছবি -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">প্রোফাইল ছবি</label>
                <input type="file" name="photo"
                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none">
            </div>
                        <!-- ঠিকানা -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">পাসওয়ার্ড</label>
                <input name="password" type="password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none"
                          placeholder="পাসওয়ার্ড লিখুন">
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition">
                    ✅ নিবন্ধন সম্পন্ন করুন
                </button>
            </div>
        </form>

        <!-- Login Link -->
        <div class="text-center mt-4 text-gray-600">
            ইতিমধ্যে একটি অ্যাকাউন্ট আছে?
            <a href="{{ route('login') }}" class="text-green-600 font-semibold hover:underline">লগইন করুন</a>
        </div>
    </div>
</div>
@endsection
