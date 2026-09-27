@extends('apps.dashboard_master')

@section('content')
<div class="flex min-h-screen bg-gray-50">

    

    <!-- 🟡 Main Content Area -->
    <div class="flex-1 min-w-0 flex flex-col">
        @include('backend.patrials.top_bar')

        <!-- Content -->
        <section class="p-6 bg-gray-50 rounded-2xl shadow">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-green-700">🛒 প্যাকেজ তালিকা</h2>
                <a href="{{ route('admin.package_create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow">
                    ➕ নতুন প্যাকেজ যোগ করুন
</a>
            </div>

            <!-- Table -->
<div class="w-full overflow-x-auto">
    <table class="min-w-[900px] border-collapse whitespace-nowrap">
                    <thead class="bg-green-50 border-b border-gray-200">
                        <tr>
                            <th class="py-3 px-4 text-gray-700 font-semibold">#</th>
                            <th class="py-3 px-4 text-gray-700 font-semibold">প্যাকেজের নাম</th>
                            <th class="py-3 px-4 text-gray-700 font-semibold">ছবি</th>
                            <th class="py-3 px-4 text-gray-700 font-semibold">পণ্য সমুহ</th>
                            <th class="py-3 px-4 text-gray-700 font-semibold">বর্তমান পণ্যের প্রাইস</th>
                            <th class="py-3 px-4 text-gray-700 font-semibold">প্যাকেজ প্রাইস</th>
                            <th class="py-3 px-4 text-gray-700 font-semibold">স্ট্যাটাস</th>
                            <th class="py-3 px-4 text-gray-700 font-semibold text-right">অপশন</th>
                        </tr>
                    </thead>
                    <tbody id="bazarTable">
                        @foreach($packages as $index => $package)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-4">{{ $index + 1 }}</td>
                            <td class="py-3 px-4">{{ $package->name }}</td>
                            <td class="py-3 px-4"><img class="h-28" src="{{ url('uploads/packages', $package->image) }}" alt=""></td>
                            <td class="py-3 px-4">
<div class="space-y-2">

    @forelse($package->package_items as $item)

        <div class="flex justify-between items-center bg-white p-3 md:p-4 rounded-lg mb-2 border">

            <div class="flex items-center gap-3 w-full">

                @if($item->product && $item->product->image)
                    <img src="{{ asset('uploads/products/' . $item->product->image) }}"
                         class="w-12 h-12 object-cover rounded-lg border"
                         onerror="this.style.display='none'">
                @endif

    <!-- Content -->
    <div class="flex-1 min-w-0">

        <div class="font-semibold text-gray-800">
            {{ $loop->iteration }}.
            {{ $item->product->name ?? 'Product not found' }}
        </div>

        <div class="flex justify-between items-center w-full">

            <div class="text-sm text-gray-500">
                ৳{{ $item->product->price }}
            </div>

            <div class="text-sm text-gray-500 whitespace-nowrap">
                {{ $item->quantity }} {{ $item->product->unit }}
            </div>

        </div>

    </div>

            </div>

        </div>

    @empty

        <div class="text-yellow-500 text-sm py-3 text-center">
            🚫 কোনো প্যাকেজ আইটেম পাওয়া যায়নি।
        </div>

    @endforelse

</div>
                            </td>
                            <td class="py-3 px-4">
    ৳{{ number_format($package->package_items->sum(fn($item) => $item->product->price), 2) }}
</td>
                            <td class="py-3 px-4">৳{{ $package->price }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded text-xs font-semibold 
                                    {{ $package->status == 'Active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                    {{ $package->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <button onclick="openEditModal({{ $package }})" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">✏️ Edit</button>
                                <button onclick="deletPkg({{ $package->id }})" class="text-red-600 hover:text-red-800 font-semibold text-sm ml-3">🗑️ Delete</button>
                                <button onclick="openAreaModal('{{ $package->id }}', '{{ $package->name }}')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow text-sm ml-3">➕ প্যাকেজ আইটেম</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<!-- 🟢 প্যাকেজ Add/Edit Modal -->
<div id="bazarModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-6 relative">
        <h3 id="modalTitle" class="text-xl font-bold text-green-700 mb-4">প্যাকেজ সম্পাদনা করুন</h3>
        <form id="bazarForm">
            <input type="hidden" id="packageId" name="id">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">প্যাকেজের নাম</label>
                <input type="text" id="bazarName" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-green-200" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">স্ট্যাটাস</label>
                <select id="bazarStatus" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-green-200">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal()" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">বাতিল</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold">সেভ করুন</button>
            </div>
        </form>
        <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">✖</button>
    </div>
</div>

<!-- 📍 এলাকা Modal -->
<div id="areaModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
  <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 relative">
      <h3 id="areaModalTitle" class="text-xl font-bold text-green-700 mb-4">📍 প্যাকেজের এলাকা সমূহ</h3>
      <input type="hidden" id="areapackageId">

      <!-- Area List -->
      <div id="areaList" class="mb-4 max-h-60 overflow-y-auto border rounded-lg p-3 bg-gray-50">
          <p class="text-gray-500 text-sm">লোড হচ্ছে...</p>
      </div>

      <!-- Add Area -->
<div class="flex-1">
    <label class="block font-semibold text-gray-700 mb-2">
        প্রোডাক্ট সিলেক্ট করুন
    </label>

    <select id="newPackageProduct"
            class="w-full border border-gray-400 rounded-lg px-3 py-2">
        <option value="">প্রোডাক্ট খুঁজুন...</option>

        @foreach ($products as $product)
            <option value="{{ $product->id }}">
                {{ $product->name }}
            </option>
        @endforeach
    </select>
</div>
<div class="flex-1">
    <label class="block font-semibold text-gray-700 mb-2">
        প্রোডাক্ট কোয়ান্টিটি
    </label>

    <input type="text" id="quantity" value="1" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-green-200" required>
</div>


<button onclick="AddPackageItems()"
        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg h-fit mt-8">
    ➕ যোগ করুন
</button>

      <div class="flex justify-end mt-6">
          <button onclick="closeAreaModal()" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">বন্ধ করুন</button>
      </div>

      <button onclick="closeAreaModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">✖</button>
  </div>
</div>


<!-- 🟢 Edit Modal -->
<!-- 🟢 Add Modal -->
<div id="addModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-6 relative">

        <h3 class="text-xl font-bold text-green-700 mb-4">
            ➕ নতুন প্যাকেজ যোগ করুন
        </h3>

        <form id="addForm">

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">
                    প্যাকেজের নাম
                </label>

                <input
                    type="text"
                    id="addName"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-green-200"
                    required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">
                    স্ট্যাটাস
                </label>

                <select id="addStatus"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-green-200">

                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>

                </select>
            </div>

            <div class="flex justify-end gap-3 mt-6">

                <button type="button"
                        onclick="closeAddModal()"
                        class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">

                    বাতিল

                </button>

                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold">

                    সংরক্ষণ

                </button>

            </div>

        </form>

        <button onclick="closeAddModal()"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">

            ✖

        </button>

    </div>

</div>

<!-- 🟢 Edit Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 relative">

        <h3 class="text-xl font-bold text-green-700 mb-4">
            ✏️ প্যাকেজ আপডেট করুন
        </h3>

        <form id="editForm" enctype="multipart/form-data">

            <input type="hidden" name="id" id="editId">

            <!-- Package Name -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">
                    প্যাকেজের নাম *
                </label>

                <input type="text"
                       name="name"
                       id="editName"
                       required
                       class="w-full border border-gray-400 rounded-lg focus:ring-green-500 focus:border-green-600 px-3 py-2"
                       placeholder="যেমন: মাসিক বাজার প্যাকেজ">
            </div>

            <!-- Current Image -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">
                    বর্তমান ছবি
                </label>

                <img id="editImagePreview"
                     src=""
                     class="w-20 h-20 object-cover rounded-lg border mb-2 hidden">
            </div>

            <!-- New Image -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">
                    নতুন ছবি
                </label>

                <input type="file"
                       name="image"
                       id="editImage"
                       accept="image/*"
                       class="w-full border border-gray-400 rounded-lg focus:ring-green-500 focus:border-green-600 px-3 py-2">
            </div>

            <!-- Price -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">
                    মূল্য (৳) *
                </label>

                <input type="number"
                       name="price"
                       id="editPrice"
                       min="0"
                       required
                       class="w-full border border-gray-400 rounded-lg focus:ring-green-500 focus:border-green-600 px-3 py-2">
            </div>

            <!-- Discount -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">
                    ডিসকাউন্ট (৳)
                </label>

                <input type="number"
                       name="discount"
                       id="editDiscount"
                       min="0"
                       value="0"
                       class="w-full border border-gray-400 rounded-lg focus:ring-green-500 focus:border-green-600 px-3 py-2">
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">
                    স্ট্যাটাস *
                </label>

                <select name="status"
                        id="editStatus"
                        class="w-full border border-gray-400 rounded-lg focus:ring-green-500 focus:border-green-600 px-3 py-2">

                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>

                </select>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">
                    প্যাকেজের সংক্ষিপ্ত বর্ণনা
                </label>

                <textarea name="description"
                          id="editDescription"
                          rows="4"
                          class="w-full border border-gray-400 rounded-lg focus:ring-green-500 focus:border-green-600 px-3 py-2"
                          placeholder="প্যাকেজের সংক্ষিপ্ত বর্ণনা লিখুন..."></textarea>
            </div>

            <!-- Submit -->
            <div class="flex justify-end mt-4">
                <button type="submit"
                        id="editSubmitBtn"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow font-semibold transition">
                    💾 আপডেট করুন
                </button>
            </div>

        </form>

        <button onclick="closeEditModal()"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
            ✖
        </button>

    </div>
</div>






@endsection

@section('scripts')




<script>

$(document).ready(function () {
    $('#newPackageProduct').select2({
        placeholder: 'প্রোডাক্ট খুঁজুন...',
        allowClear: true,
        width: '100%'
    });
});


function openAddModal() {
    $('#addForm')[0].reset();
    $('#addModal').removeClass('hidden');
}

function closeAddModal() {
    $('#addModal').addClass('hidden');
}

 


/* 🔹 Area Modal Functions */
function openAreaModal(packageId, name) {
    $('#areapackageId').val(packageId);
    $('#areaModalTitle').text('📍 ' + name + ' আইটেম');
    $('#areaModal').removeClass('hidden');
    loadPackageItems(packageId);
}

function closeAreaModal() {
    $('#areaModal').addClass('hidden');
}

/* 🔹 Load Areas */
function loadPackageItems(packageId) {
const productImageUrl = "{{ asset('uploads/products') }}";

    $.ajax({
        url: '{{ route("admin.package.items") }}',
        type: 'POST',

        data: {
            _token: '{{ csrf_token() }}',
            package_id: packageId,
        },

        success: function(response) {

            let html = '';

            if (response.items.length > 0) {

                response.items.forEach((item, index) => {

                    html += `
                        <div class="flex justify-between items-center bg-white p-3 md:p-4 rounded-lg mb-2 border">

                            <div class="flex items-center gap-3">
                                ${
                                    item.product && item.product.image
                                    ? `<img src="${productImageUrl}/${item.product.image}"
                                            class="w-12 h-12 object-cover rounded-lg border"
                                            onerror="this.style.display='none'">`
                                    : ''
                                }
                                <div>
                                    <div class="font-semibold text-gray-800">
                                        ${index + 1}. ${item.product ? item.product.name : 'Product not found'}
                                    </div>

                                    <div class="text-sm text-gray-500">
                                        ৳${item.product.price} / ${item.product.unit}
                                    </div>
                                </div>

                            </div>

                            <button
                                onclick="deletePackageItem(${item.id})"
                                class="text-red-600 hover:text-red-800 text-sm">
                                🗑️
                            </button>

                        </div>
                    `;
                });

            } else {

                html = `
                    <p class="text-red-500 text-sm">
                        কোনো প্যাকেজ আইটেম যোগ করা হয়নি।
                    </p>
                `;
            }

            $('#areaList').html(html);
        },

        error: function() {

            $('#areaList').html(`
                <p class="text-red-500 text-sm">
                    ❌ প্যাকেজ আইটেম লোড করা যায়নি!
                </p>
            `);
        }
    });
}

/* 🔹 Add Area */
function AddPackageItems() {

    const packageId = $('#areapackageId').val();
    const productId = $('#newPackageProduct').val();
    const quantity = $('#quantity').val();

    if (!packageId) {
        alert('❌ Package পাওয়া যায়নি!');
        return;
    }

    if (!productId) {
        alert('❌ একটি প্রোডাক্ট সিলেক্ট করুন!');
        return;
    }

    $.ajax({
        url: '{{ route("admin.package.items.store") }}',
        method: 'POST',

        data: {
            _token: '{{ csrf_token() }}',
            package_id: packageId,
            product_id: productId,
            quantity: quantity
        },

        beforeSend: function () {
            // চাইলে এখানে button disable করতে পারেন
        },

        success: function (response) {

            // Select2 reset
            $('#newPackageProduct')
                .val('')
                .trigger('change');

            // Package items reload
            loadPackageItems(packageId);

            showToast(
                'success',
                'Success',
                response.message || '✅ নতুন প্যাকেজ আইটেম যোগ হয়েছে!'
            );
        },

        error: function (xhr) {

            if (xhr.status === 422 && xhr.responseJSON?.errors) {

                let errors = xhr.responseJSON.errors;
                let message = '';

                Object.values(errors).forEach(function (error) {
                    message += error[0] + '\n';
                });

                alert(message);

            } else {

                alert(
                    xhr.responseJSON?.message ||
                    '❌ প্যাকেজ আইটেম যোগ করা ব্যর্থ হয়েছে!'
                );
            }
        }
    });
}

/* 🔹 Delete Area */
function deleteArea(id) {
    if (!confirm('আপনি কি নিশ্চিত এই প্যাকেজ আইটেম ফেলতে চান?')) return;

    $.ajax({
        url: '{{ route("admin.bazar.areas.delete") }}',
        type: 'POST',
        data: {
            id
        },
        success: function(response) {
            loadPackageItems($('#areapackageId').val());
            showToast('success', 'Deleted', '✅ প্যাকেজ আইটেম সফলভাবে মুছে ফেলা হয়েছে!');
        },
        error: function() {
            alert('❌ প্যাকেজ আইটেম মুছে ফেলা ব্যর্থ হয়েছে!');
        }
    });
}
</script>



<script>
 
function openEditModal(package) {

    $('#editId').val(package.id);
    $('#editName').val(package.name);
    $('#editPrice').val(package.price);
    $('#editDiscount').val(package.discount);
    $('#editStatus').val(package.status);
    $('#editDescription').val(package.description);

    // Image preview
    if (package.image) {

        $('#editImagePreview')
            .attr('src', '{{ asset("uploads/packages") }}/' + package.image)
            .removeClass('hidden');

    } else {

        $('#editImagePreview').addClass('hidden');
    }

    $('#editModal').removeClass('hidden');
}

function closeEditModal() {
    $('#editModal').addClass('hidden');
}

$('#editForm').on('submit', function(e) {

    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    $.ajax({

        url: '{{ route("admin.package.update") }}',

        type: 'POST',

        data: formData,

        processData: false,
        contentType: false,

        beforeSend: function() {

            $('#editSubmitBtn')
                .prop('disabled', true)
                .html('⏳ আপডেট হচ্ছে...');
        },

        success: function(response) {

            showToast(
                'success',
                'Updated',
                response.message || '✅ প্যাকেজ সফলভাবে আপডেট হয়েছে!'
            );

            closeEditModal();

            setTimeout(() => {
                location.reload();
            }, 800);
        },

        error: function(xhr) {

            if (xhr.status === 422 && xhr.responseJSON?.errors) {

                let errors = xhr.responseJSON.errors;
                let message = '';

                Object.values(errors).forEach(function(error) {
                    message += error[0] + '\n';
                });

                alert(message);

            } else {

                alert(
                    xhr.responseJSON?.message ||
                    '❌ প্যাকেজ আপডেট ব্যর্থ হয়েছে!'
                );
            }
        },

        complete: function() {

            $('#editSubmitBtn')
                .prop('disabled', false)
                .html('💾 আপডেট করুন');
        }

    });

});

 

/* 🔹 Delete প্যাকেজ */
function deletPkg(id) {
    if (!confirm('আপনি কি নিশ্চিত এই প্যাকেজটি মুছে ফেলতে চান?')) return;

    $.ajax({
        url: '{{ url("admin/bazars") }}/' + id,
        type: 'DELETE',
        data: { _token: '{{ csrf_token() }}' },
        success: function(response) {
            alert(response.message);
            setTimeout(() => location.reload(), 1000);
        },
        error: function() {
            alert('❌ প্যাকেজ মুছে ফেলা ব্যর্থ হয়েছে!');
        }
    });
}
</script>


@endsection
