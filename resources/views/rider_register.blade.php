@extends('apps.front_master')
@section('title', 'Become a Rider | '.config('app.name'))

@section('content')
<section class="bg-gray-50 py-12">
    <div class="max-w-5xl mx-auto px-4">

        <!-- Header Section -->
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-green-700 mb-3">🚴‍♂️ আমাদের ডেলিভারি টিমে যোগ দিন!</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                আপনার বাইক বা সাইকেল দিয়ে আমাদের সাথে কাজ করে আয়ের সুযোগ নিন।  
                নিচের ফর্ম পূরণ করে সহজেই রাইডার হিসেবে রেজিস্ট্রেশন করুন।
            </p>
        </div>

        <!-- Rider Registration Form -->
        <div class="bg-white shadow-lg rounded-2xl p-8 border border-gray-200">
        <section class="bg-white p-8 m-6 rounded-2xl shadow border border-gray-200">
            
        @include('alerts.alert')
    
        <h2 class="text-2xl font-semibold text-green-700 mb-6">📝 রাইডার রেজিস্ট্রেশন ফর্ম</h2>
         <form id="riderRegisterForm" action="{{ route('admin.riders.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <!-- Full Name -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">পূর্ণ নাম *</label>
                <input type="text" name="name" required
                       class="w-full border border-gray-400 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500"
                       placeholder="যেমন: রফিকুল ইসলাম">
            </div>

            <!-- Father's Name -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">পিতার নাম *</label>
                <input type="text" name="father_name" required
                       class="w-full border border-gray-400 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500"
                       placeholder="যেমন: আব্দুল করিম">
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">নিজের ফোন নম্বর *</label>
                <input type="text" name="phone" required
                       class="w-full border border-gray-400 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500"
                       placeholder="যেমন: ০১৭XXXXXXXX">
            </div>

            <!-- Father's Phone -->


            <!-- Age -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">বয়স *</label>
                <input type="number" name="age" min="18" required
                       class="w-full border border-gray-400 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500"
                       placeholder="যেমন: ২২">
            </div>

            <!-- Education -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">শিক্ষাগত যোগ্যতা *</label>
                <select name="edu_qualification" required
                        class="w-full border border-gray-400 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">-- নির্বাচন করুন --</option>
                    <option value="ssc নিচে">SSC এর নিচে</option>
                    <option value="ssc">SSC পাস</option>
                    <option value="hsc">HSC পাস</option>
                    <option value="honours">Honours পাস</option>
                </select>
            </div>

            <!-- Institute -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">শিক্ষা প্রতিষ্ঠানের নাম</label>
                <input type="text" name="institute"
                       class="w-full border border-gray-400 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500"
                       placeholder="যেমন: ঢাকা কলেজ">
            </div>
 
            <!-- Vehicle Type -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">যানবাহনের ধরন *</label>
                <select name="vehicle_type" required
                        class="w-full border border-gray-400 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">-- নির্বাচন করুন --</option>
                    <option value="bicycle">সাইকেল</option>
                    <option value="motorcycle">মোটরসাইকেল</option>
                    <option value="van">ভ্যান</option>
                </select>
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

            <!-- Address -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 font-semibold mb-2">ঠিকানা *</label>
                <textarea name="address" rows="3" required
                          class="w-full border border-gray-400 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500"
                          placeholder="যেমন: ময়মনসিংহ সদর, বাংলাদেশ"></textarea>
            </div>

            <!-- NID Image -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">NID ছবি আপলোড *</label>
                <input type="file" name="nid_image" accept="image/*" required
                       class="w-full border border-gray-400 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500">
            </div>

            <!-- Rider Photo -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">নিজের ছবি *</label>
                <input type="file" name="photo" accept="image/*" required onchange="previewImage(event)"
                       class="w-full border border-gray-400 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500">
                <img id="photoPreview" class="hidden mt-3 rounded-lg w-32 h-32 object-cover border" alt="Preview">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">পিতার ফোন নম্বর *</label>
                <input type="text" name="father_phone" required
                       class="w-full border border-gray-400 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500"
                       placeholder="যেমন: ০১৮XXXXXXXX">
            </div>
                  <!-- Password -->
      <div class="relative">
        <label class="block text-gray-700 font-medium mb-1">পাসওয়ার্ড</label>
        <input type="password" name="password" id="password" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-400 outline-none" placeholder="******" required>
        <button type="button" id="togglePassword" class="absolute right-3 top-9 text-gray-500 hover:text-green-600">
          👁️
        </button>
      </div>

            <!-- Submit -->
            <div class="md:col-span-2 flex justify-center mt-6">
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-10 py-3 rounded-lg text-lg font-semibold shadow-lg transition">
                    ✅ রেজিস্টার করুন
                </button>
            </div>
        </form>
        </div>

        <!-- Info Section -->
        <div class="mt-10 text-center">
            <p class="text-gray-600">
                📞 কোনো সহায়তা প্রয়োজন হলে যোগাযোগ করুন: 
                <span class="text-green-600 font-semibold">01300-123456</span>
            </p>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function previewImage(event) {
        const preview = document.getElementById('photoPreview');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        }
    }
</script>
  
<script>
document.addEventListener("DOMContentLoaded", function() {
    const alertBox = document.getElementById('alert-message');
    if (alertBox) {
        // Fade in
        setTimeout(() => {
            alertBox.classList.remove('opacity-0', 'translate-y-[-20px]');
            alertBox.classList.add('opacity-100', 'translate-y-0');
        }, 100);

        // Fade out after 3 seconds
        setTimeout(() => {
            alertBox.classList.remove('opacity-100', 'translate-y-0');
            alertBox.classList.add('opacity-0', 'translate-y-[-20px]');
        }, 3000);

        // Remove from DOM after fade out
        setTimeout(() => alertBox.remove(), 3500);
    }
});
</script>
 
<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.textContent = type === 'password' ? '👁️' : '🙈';
    });
</script>
@endsection