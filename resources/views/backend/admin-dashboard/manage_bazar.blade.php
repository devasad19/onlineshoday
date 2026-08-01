@extends('apps.dashboard_master')

@section('content')
<div class="flex min-h-screen bg-gray-50">

    

    <!-- 🟡 Main Content Area -->
    <div class="flex-1 min-w-0 flex flex-col">
        @include('backend.patrials.top_bar')

        <!-- Content -->
        <section class="p-6 bg-gray-50 rounded-2xl shadow">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-green-700">🛒 বাজার তালিকা</h2>
                <button onclick="openAddModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow">
                    ➕ নতুন বাজার যোগ করুন
                </button>
            </div>

            <!-- Table -->
<div class="w-full overflow-x-auto">
    <table class="min-w-[900px] border-collapse whitespace-nowrap">
                    <thead class="bg-green-50 border-b border-gray-200">
                        <tr>
                            <th class="py-3 px-4 text-gray-700 font-semibold">#</th>
                            <th class="py-3 px-4 text-gray-700 font-semibold">বাজারের নাম</th>
                            <th class="py-3 px-4 text-gray-700 font-semibold">এলাকাসমুহ</th>
                            <th class="py-3 px-4 text-gray-700 font-semibold">স্ট্যাটাস</th>
                            <th class="py-3 px-4 text-gray-700 font-semibold text-right">অপশন</th>
                        </tr>
                    </thead>
                    <tbody id="bazarTable">
                        @foreach($bazars as $index => $bazar)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-4">{{ $index + 1 }}</td>
                            <td class="py-3 px-4">{{ $bazar->name }}</td>
                            <td class="py-3 px-4">
                                    @forelse($bazar->areas as $area)
                                    <span class="bg-blue-100 text-green-800 px-3 py-1 rounded-full text-sm">{{ $area->name }}</span>
                                    @empty
                                    <div class="col-span-4 text-yellow-500 text-xs text-gray-500 py-1">
                                        🚫 পাওয়া যায়নি।
                                    </div>
                                    @endforelse
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded text-xs font-semibold 
                                    {{ $bazar->status == 'Active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                    {{ $bazar->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <button onclick="openEditModal('{{ $bazar->id }}', '{{ $bazar->name }}', '{{ $bazar->status }}')" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">✏️ Edit</button>
                                <button onclick="deleteBazar({{ $bazar->id }})" class="text-red-600 hover:text-red-800 font-semibold text-sm ml-3">🗑️ Delete</button>
                                <button onclick="openAreaModal('{{ $bazar->id }}', '{{ $bazar->name }}')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow text-sm ml-3">➕ নতুন এলাকা</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<!-- 🟢 বাজার Add/Edit Modal -->
<div id="bazarModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-6 relative">
        <h3 id="modalTitle" class="text-xl font-bold text-green-700 mb-4">বাজার সম্পাদনা করুন</h3>
        <form id="bazarForm">
            <input type="hidden" id="bazarId" name="id">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">বাজারের নাম</label>
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
      <h3 id="areaModalTitle" class="text-xl font-bold text-green-700 mb-4">📍 বাজারের এলাকা সমূহ</h3>
      <input type="hidden" id="areaBazarId">

      <!-- Area List -->
      <div id="areaList" class="mb-4 max-h-60 overflow-y-auto border rounded-lg p-3 bg-gray-50">
          <p class="text-gray-500 text-sm">লোড হচ্ছে...</p>
      </div>

      <!-- Add Area -->
      <div class="flex gap-3">
          <input type="text" id="newAreaName" placeholder="নতুন এলাকা নাম লিখুন..." class="flex-1 border rounded-lg px-3 py-2 focus:ring focus:ring-green-200">
          <button onclick="addArea()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">➕ যোগ করুন</button>
      </div>

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
            ➕ নতুন বাজার যোগ করুন
        </h3>

        <form id="addForm">

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">
                    বাজারের নাম
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
    <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-6 relative">
        <h3 class="text-xl font-bold text-green-700 mb-4">✏️ বাজার আপডেট করুন</h3>

        <form id="editForm">
            <input type="hidden" id="editId">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">বাজারের নাম</label>
                <input type="text" id="editName" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-green-200" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">স্ট্যাটাস</label>
                <select id="editStatus" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-green-200">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">বাতিল</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold">সংরক্ষণ</button>
            </div>
        </form>

        <button onclick="closeEditModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">✖</button>
    </div>
</div>






@endsection

@section('scripts')




<script>


function openAddModal() {
    $('#addForm')[0].reset();
    $('#addModal').removeClass('hidden');
}

function closeAddModal() {
    $('#addModal').addClass('hidden');
}

/* 🔹 Add বাজার */
$('#addForm').on('submit', function(e) {

    e.preventDefault();

    $.ajax({

        url: '{{ route("admin.bazars.store") }}',
        type: 'POST',

        data: {
            name: $('#addName').val(),
            status: $('#addStatus').val()
        },

        success: function(response) {

            showToast('success', 'Success', response.message);

            closeAddModal();

            setTimeout(function() {
                location.reload();
            }, 1000);

        },

        error: function(xhr) {

            showToast(
                'error',
                'Error',
                xhr.responseJSON?.message ?? '❌ বাজার যোগ করা যায়নি!'
            );

        }

    });

});


/* 🔹 Area Modal Functions */
function openAreaModal(bazarId, name) {
    $('#areaBazarId').val(bazarId);
    $('#areaModalTitle').text('📍 ' + name + ' বাজারের এলাকা সমূহ');
    $('#areaModal').removeClass('hidden');
    loadAreas(bazarId);
}

function closeAreaModal() {
    $('#areaModal').addClass('hidden');
}

/* 🔹 Load Areas */
function loadAreas(bazarId) {
    $.ajax({
        url: '{{ route("admin.bazar.areas") }}',
        type: 'POST',
        data: {
            bazar_id: bazarId,
        },
        success: function(response) {
            let html = '';
            if (response.areas.length > 0) {
                response.areas.forEach((area, index) => {
                    html += `
                        <div class="flex justify-between items-center bg-white p-2 md:p-6 rounded-lg mb-2 border">
                            <span>${index + 1}. ${area.name}</span>
                            <button onclick="deleteArea(${area.id})" class="text-red-600 hover:text-red-800 text-sm">🗑️</button>
                        </div>`;
                });
            } else {
                html = '<p class="text-red-500 text-sm">কোন এলাকা যোগ করা হয়নি।</p>';
            }
            $('#areaList').html(html);
        },
        error: function() {
            $('#areaList').html('<p class="text-red-500 text-sm">❌ এলাকা লোড করা যায়নি!</p>');
        }
    });
}

/* 🔹 Add Area */
function addArea() {
    const bazarId = $('#areaBazarId').val();
    const name = $('#newAreaName').val().trim();
    if (name === '') {
        alert('এলাকার নাম লিখুন!');
        return;
    }

    $.ajax({
        url: '{{ route("admin.bazar.areas.store") }}',
        method: 'POST',
        data: {
            bazar_id: bazarId,
            name: name,
        },
        success: function(response) {
            $('#newAreaName').val('');
            loadAreas(bazarId);
            showToast('success', 'Success', response.message || '✅ নতুন এলাকা যোগ হয়েছে!');
        },
        error: function() {
            alert('❌ এলাকা যোগ করা ব্যর্থ হয়েছে!');
        }
    });
}

/* 🔹 Delete Area */
function deleteArea(id) {
    if (!confirm('আপনি কি নিশ্চিত এই এলাকা মুছে ফেলতে চান?')) return;

    $.ajax({
        url: '{{ route("admin.bazar.areas.delete") }}',
        type: 'POST',
        data: {
            id
        },
        success: function(response) {
            loadAreas($('#areaBazarId').val());
            showToast('success', 'Deleted', '✅ এলাকা সফলভাবে মুছে ফেলা হয়েছে!');
        },
        error: function() {
            alert('❌ এলাকা মুছে ফেলা ব্যর্থ হয়েছে!');
        }
    });
}
</script>



<script>
function openEditModal(id, name, status) {
    $('#editId').val(id);
    $('#editName').val(name);
    $('#editStatus').val(status);
    $('#editModal').removeClass('hidden');
}

function closeEditModal() {
    $('#editModal').addClass('hidden');
}

/* 🔹 Update বাজার */
$('#editForm').on('submit', function(e) {
    e.preventDefault();

    const id = $('#editId').val();
    const data = {
        name: $('#editName').val(),
        status: $('#editStatus').val(),
        id: id
    };

    $.ajax({
        url: '{{ route("admin.bazars.update") }}',
        type: 'POST',
        data: data,
        success: function(response) {
            showToast('success', 'Updated', response.message);
            closeEditModal();
            setTimeout(() => location.reload(), 1000);
        },
        error: function(xhr) {
            alert('❌ বাজার আপডেট ব্যর্থ হয়েছে!');
        }
    });
});

/* 🔹 Delete বাজার */
function deleteBazar(id) {
    if (!confirm('আপনি কি নিশ্চিত এই বাজারটি মুছে ফেলতে চান?')) return;

    $.ajax({
        url: '{{ url("admin/bazars") }}/' + id,
        type: 'DELETE',
        data: { _token: '{{ csrf_token() }}' },
        success: function(response) {
            alert(response.message);
            setTimeout(() => location.reload(), 1000);
        },
        error: function() {
            alert('❌ বাজার মুছে ফেলা ব্যর্থ হয়েছে!');
        }
    });
}
</script>


@endsection
