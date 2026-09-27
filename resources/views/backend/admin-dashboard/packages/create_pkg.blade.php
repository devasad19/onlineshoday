@extends('apps.dashboard_master')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    

    <!-- 🟡 Main Content -->
    <div class="flex-1 flex flex-col">
        @include('backend.patrials.top_bar')

        <!-- Content Body -->
        <section class="bg-white p-2 md:p-6 m-2 md:m-6 rounded-2xl shadow border border-gray-200">

        @include('alerts.alert')

            <h2 class="text-2xl font-bold text-green-700 mb-6">➕ নতুন প্যাকেজ যোগ করুন</h2>

            <!-- Product Add Form -->
            <form id="addProductForm" action="{{ route('admin.pakcage.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf

                <!-- Product Name -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">প্যাকেজের নাম *</label>
                    <input type="text" name="name" required
                           class="w-full border border-gray-400 rounded-lg focus:ring-green-500 focus:border-green-600 px-3 py-2" 
                           placeholder="যেমন: মাসিক বাজার প্যাকেজ, ফ্যামিলি প্যাকেজ, ...">
                </div>
                <!-- Product Image -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">প্যাকেজের ছবি *</label>
                    <input type="file" name="image" accept="image/*" required
                           class="w-full border border-gray-400 rounded-lg focus:ring-green-500 focus:border-green-600 px-3 py-2">
                </div>
        

                <!-- Price -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">মূল্য (৳)</label>
                    <input type="number" name="price" min="0" required
                           class="w-full border border-gray-400 rounded-lg focus:ring-green-500 focus:border-green-600 px-3 py-2"
                           placeholder="যেমন: 1000">
                </div>
                <!-- Price -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">ডিসকাউন্ট (৳)</label>
                    <input type="number" name="discount" min="0" required
                           class="w-full border border-gray-400 rounded-lg focus:ring-green-500 focus:border-green-600 px-3 py-2"
                           placeholder="যেমন: 15">
                </div>
  

                <!-- Status -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">স্ট্যাটাস *</label>
                    <select name="status"
                            class="w-full border border-gray-400 rounded-lg focus:ring-green-500 focus:border-green-600 px-3 py-2">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>



                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block font-semibold text-gray-700 mb-2">প্যাকেজের সংক্ষিপ্ত বর্ণনা (Optional)</label>
                    <textarea name="description" rows="4"
                              class="w-full border border-gray-400 rounded-lg focus:ring-green-500 focus:border-green-600 px-3 py-2"
                              placeholder="প্যাকেজের সংক্ষিপ্ত বর্ণনা লিখুন..."></textarea>
                </div>

                <!-- Submit Button -->
                <div class="md:col-span-2 flex justify-end mt-4">
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow font-semibold transition">
                        🛒 প্যাকেজ সংরক্ষণ করুন
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection

@section('scripts')
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
@endsection

