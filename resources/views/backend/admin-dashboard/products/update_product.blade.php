@extends('apps.dashboard_master')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    

    <!-- 🟡 Main Content -->
    <div class="flex-1 flex flex-col">
        @include('backend.patrials.top_bar')

        <!-- Content Body -->
        <section class="bg-white p-2 md:p-6 m-2 md:m-6 rounded-2xl shadow border border-gray-200">

        @include('alerts.alert')

            <h2 class="text-2xl font-bold text-green-700 mb-6">➕ পণ্য সংশোধন করুন</h2>

            <!-- Product Add Form -->
            <form id="editProductForm"
                action="{{ route('admin.products.update',$product->id) }}"
                method="POST"
                enctype="multipart/form-data"
                class="grid grid-cols-1 md:grid-cols-2 gap-6">

                @csrf
               

                <!-- Product Name -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">পণ্যের নাম *</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name',$product->name) }}"
                        required
                        class="w-full border border-gray-400 rounded-lg px-3 py-2">
                </div>

                <!-- Bazar -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">বাজার নির্বাচন *</label>

                    <select
                        name="bazar_id"
                        required
                        class="w-full border border-gray-400 rounded-lg px-3 py-2">

                        @foreach($bazars as $bazar)

                            <option
                                value="{{ $bazar->id }}"
                                {{ old('bazar_id',$product->bazar_id)==$bazar->id ? 'selected' : '' }}>

                                {{ $bazar->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <!-- Category -->

                <div>

                    <label class="block font-semibold text-gray-700 mb-2">

                        ক্যাটাগরি *

                    </label>

                    <select
                        name="category_id"
                        required
                        class="w-full border border-gray-400 rounded-lg px-3 py-2">

                        @foreach($categories as $cat)

                            <option
                                value="{{ $cat->id }}"
                                {{ old('category_id',$product->category_id)==$cat->id ? 'selected' : '' }}>

                                {{ $cat->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <!-- Price -->

                <div>

                    <label class="block font-semibold text-gray-700 mb-2">

                        মূল্য

                    </label>

                    <input
                        type="number"
                        min="0"
                        step="0.01"
                        name="price"
                        value="{{ old('price',$product->price) }}"
                        class="w-full border border-gray-400 rounded-lg px-3 py-2">

                </div>

                <!-- Unit -->

                <div>

                    <label class="block font-semibold text-gray-700 mb-2">

                        ইউনিট

                    </label>

                    <select
                        name="unit"
                        class="w-full border border-gray-400 rounded-lg px-3 py-2">

                        @php

                            $units=[
                                'কেজি',
                                'পিস',
                                'ডজন',
                                'লিটার',
                                'প্যাকেট'
                            ];

                        @endphp

                        @foreach($units as $unit)

                            <option
                                value="{{ $unit }}"
                                {{ old('unit',$product->unit)==$unit ? 'selected' : '' }}>

                                {{ $unit }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <!-- Status -->

                <div>

                    <label class="block font-semibold text-gray-700 mb-2">

                        স্ট্যাটাস

                    </label>

                    <select
                        name="status"
                        class="w-full border border-gray-400 rounded-lg px-3 py-2">

                        <option
                            value="active"
                            {{ old('status',$product->status)=='active' ? 'selected' : '' }}>

                            Active

                        </option>

                        <option
                            value="inactive"
                            {{ old('status',$product->status)=='inactive' ? 'selected' : '' }}>

                            Inactive

                        </option>

                    </select>

                </div>

                <!-- Image -->

                <div>

                    <label class="block font-semibold text-gray-700 mb-2">

                        বর্তমান ছবি

                    </label>

                    <img
                        src="{{ asset('uploads/products/'.$product->image) }}"
                        class="w-24 h-24 rounded border object-cover mb-2">

                    <input
                        type="file"
                        name="image"
                        class="w-full border border-gray-400 rounded-lg px-3 py-2">

                </div>

                <!-- Description -->

                <div class="md:col-span-2">

                    <label class="block font-semibold text-gray-700 mb-2">

                        বর্ণনা

                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        class="w-full border border-gray-400 rounded-lg px-3 py-2">{{ old('description',$product->description) }}</textarea>

                </div>

                <div class="md:col-span-2 flex justify-end">

                    <button
                        id="saveBtn"
                        class="bg-green-600 text-white px-6 py-2 rounded-lg">

                        ✏️ Update Product

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





$("#editProductForm").submit(function(e){

    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({

        url: $(this).attr("action"),

        type: "POST",

        data: formData,

        processData: false,

        contentType: false,

        success: function(res){

            Swal.fire({
                icon:'success',
                title:res.message,
                timer:1500,
                showConfirmButton:false
            }).then(()=>{
                window.location.href="{{ route('admin.manage_products') }}";
            });

        }

    });

});







</script>
@endsection

