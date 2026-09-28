@extends('apps.dashboard_master')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    

    <!-- 🟡 Main Content -->
    <div class="flex-1 flex flex-col">
        @include('backend.patrials.top_bar')

        <!-- Content Body -->
        <section class="bg-white p-2 md:p-6 m-2 md:m-6 rounded-2xl shadow border border-gray-200">

        @include('alerts.alert')
 

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-green-700">➕ ই-কমার্স পণ্য যোগ করুন</h2>
                 

                <a href="{{ route('admin.product.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition"
                        >
                    ➕ নিত্যপ্রয়োজনীয় পণ্য
            </a>

            </div>




            <!-- Product Add Form -->
            <form id="addProductForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf

                <input type="hidden" value="1" name="ecom">

                <!-- Product Name -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">পণ্যের নাম *</label>
                    <input type="text" name="name" required
                           class="w-full border border-gray-400 rounded-lg focus:ring-green-500 focus:border-green-600 px-3 py-2" 
                           placeholder="যেমন: মধু, খেজুর, ব্রাশ, ...">
                </div>
 
                <!-- Category -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">ক্যাটাগরি </label>
                    <select name="category_id" 
                            class="w-full border border-gray-400 rounded-lg focus:ring-green-500 focus:border-green-600 px-3 py-2">
                        <!-- <option value="">-- ক্যাটাগরি নির্বাচন করুন --</option> -->
                        <!-- @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach -->
                    </select>
                </div>

                <!-- Price -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">মূল্য (৳)</label>
                    <input type="number" name="price" min="0" required
                           class="w-full border border-gray-400 rounded-lg focus:ring-green-500 focus:border-green-600 px-3 py-2"
                           placeholder="যেমন: ৮০">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">ডিসকাউন্ট (%)</label>
                    <input type="number" name="discount" min="0" required
                           class="w-full border border-gray-400 rounded-lg focus:ring-green-500 focus:border-green-600 px-3 py-2"
                           placeholder="যেমন: ৫">
                </div>
 
                <!-- Unit -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">পণ্যের ইউনিট *</label>
                    <select name="unit" required
                            class="w-full border border-gray-400 rounded-lg focus:ring-green-500 focus:border-green-600 px-3 py-2">
                        <option value="">-- ইউনিট নির্বাচন করুন --</option>
                        <option value="পিস">পিস</option>
                        <option value="প্যাকেট">প্যাকেট</option>
                        <option value="ডজন">ডজন</option>
                        <option value="লিটার">লিটার</option>
                        <option value="কেজি">কেজি</option>
                    </select>
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

                <!-- Product Image -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">পণ্যের ছবি *</label>
                    <input type="file" name="image" accept="image/*" required
                           class="w-full border border-gray-400 rounded-lg focus:ring-green-500 focus:border-green-600 px-3 py-2">
                </div>
 

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block font-semibold text-gray-700 mb-2">পণ্যের সংক্ষিপ্ত বর্ণনা (Optional)</label>
                    <textarea name="description" rows="4"
                              class="w-full border border-gray-400 rounded-lg focus:ring-green-500 focus:border-green-600 px-3 py-2"
                              placeholder="পণ্যের সংক্ষিপ্ত বর্ণনা লিখুন..."></textarea>
                </div>

                <!-- Submit Button -->
                <div class="md:col-span-2 flex justify-end mt-4">
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow font-semibold transition">
                        🛒 পণ্য সংরক্ষণ করুন
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

