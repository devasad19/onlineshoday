@extends('apps.dashboard_master')

@section('content')
<div class="flex min-h-screen bg-gray-50">

    

    <!-- 🟡 Main Content Area -->
    <div class="flex-1 min-w-0 flex flex-col">

        @include('backend.patrials.top_bar')

        <!-- Content Body -->
        <section class="bg-white p-2 md:p-6 rounded-2xl shadow m-2 md:m-6 w-full min-w-0 overflow-hidden">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-green-700">🛍️ পণ্য ব্যবস্থাপনা</h2>
                <a href="{{ route('admin.product.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition"
                        data-modal-target="addProductModal">
                    ➕ নতুন পণ্য যোগ করুন
            </a>
            </div>

            <div class="bg-white p-4 rounded-xl shadow mb-4">

    <div class="grid md:grid-cols-4 gap-3">

        <input
            type="text"
            id="search_name"
            placeholder="পণ্যের নাম"
            class="border rounded-lg px-4 py-2 w-full">

        <select id="search_category"
                class="border rounded-lg px-4 py-2">

            <option value="">সব বিভাগ</option>

            @foreach($categories as $category)

                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>

            @endforeach

        </select>

        <select id="search_bazar"
                class="border rounded-lg px-4 py-2">

            <option value="">সব বাজার</option>

            @foreach($bazars as $bazar)

                <option value="{{ $bazar->id }}">
                    {{ $bazar->name }}
                </option>

            @endforeach

        </select>

        <button
            id="resetFilter"
            class="bg-red-600 text-white rounded-lg">
            Reset
        </button>

    </div>

</div>

<div id="productTable">

@include('backend.admin-dashboard.products.partials.product_table')

</div>

  
        </section>

        <!-- 🔘 Add/Edit Modal Placeholder -->
<!-- 🧩 Add/Edit Product Modal -->
<div id="addProductModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 relative">
      <h2 class="text-xl font-bold text-green-700 mb-4">🛒 নতুন পণ্য যোগ করুন</h2>

      <form action="" method="POST">
          @csrf
          <div class="grid grid-cols-1 gap-4">
              <div>
                  <label class="text-gray-600 font-semibold">পণ্যের নাম</label>
                  <input type="text" name="name" class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400">
              </div>

              <div>
                  <label class="text-gray-600 font-semibold">মূল্য</label>
                  <input type="number" name="price" class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400">
              </div>

              <div>
                  <label class="text-gray-600 font-semibold">স্ট্যাটাস</label>
                  <select name="status" class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400">
                      <option value="active">সক্রিয়</option>
                      <option value="inactive">নিষ্ক্রিয়</option>
                  </select>
              </div>
          </div>

          <div class="flex justify-end mt-6 space-x-3">
              <button type="button" onclick="document.getElementById('addProductModal').classList.add('hidden')"
                      class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">বাতিল</button>
              <button type="submit"
                      class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">সংরক্ষণ</button>
          </div>
      </form>
  </div>
</div>


<!-- view product details  -->
<div id="productModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-xl w-full max-w-2xl">

        <div class="flex justify-between items-center border-b p-4">

            <h3 class="text-xl font-bold">
                Product Details
            </h3>

            <button onclick="closeProductModal()">
                ✖
            </button>

        </div>

        <div class="p-6">

            <div class="flex gap-6">

                <img
                    id="modal_image"
                    class="w-40 h-40 rounded-lg border object-cover">

                <div class="space-y-2">

                    <p><strong>নাম:</strong> <span id="modal_name"></span></p>

                    <p><strong>বাজার:</strong> <span id="modal_bazar"></span></p>

                    <p><strong>ক্যাটাগরি:</strong> <span id="modal_category"></span></p>

                    <p><strong>মূল্য:</strong> ৳<span id="modal_price"></span></p>

                    <p><strong>ইউনিট:</strong> <span id="modal_unit"></span></p>

                    <p><strong>স্ট্যাটাস:</strong> <span id="modal_status"></span></p>

                </div>

            </div>

            <div class="mt-5">

                <strong>বর্ণনা</strong>

                <p id="modal_description"
                   class="mt-2 text-gray-600"></p>

            </div>

        </div>

    </div>

</div>





    </div>
</div>
@endsection

@section('scripts')
<script>
    function openEditModal(id) {
        document.getElementById('addProductModal').classList.remove('hidden');
        // এখানে আপনি AJAX দিয়ে প্রোডাক্ট ডাটা লোড করতে পারেন
    }

    function confirmDelete(id) {
        if (confirm('আপনি কি নিশ্চিতভাবে এই পণ্যটি মুছে ফেলতে চান?')) {
            // এখানে delete request পাঠান
        }
    }

    function viewProduct(id) {
        // প্রোডাক্ট বিস্তারিত দেখানোর জন্য modal খুলবেন
    }
</script>


<script>


 
function viewProduct(id){

    let url = "{{ route('admin.products.view', ':id') }}";
    url = url.replace(':id', id);

    $.get(url, function(res){
        $("#modal_image").attr("src",res.image);
        $("#modal_name").text(res.name);
        $("#modal_bazar").text(res.bazar);
        $("#modal_category").text(res.category);
        $("#modal_price").text(res.price);
        $("#modal_unit").text(res.unit);
        $("#modal_status").text(res.status);
        $("#modal_description").text(res.description ?? '');

        $("#productModal")
            .removeClass("hidden")
            .addClass("flex");

    });

}
 

 

function closeProductModal(){

    $("#productModal")
        .removeClass("flex")
        .addClass("hidden");

}


function loadProducts(page = 1){

    $.ajax({

        url: "{{ route('admin.manage_products') }}?page="+page,

        type:"GET",

        data:{
            name:$('#search_name').val(),
            category:$('#search_category').val(),
            bazar:$('#search_bazar').val(),
        },

        success:function(response){

            $('#productTable').html(response);

        }

    });

}



// typing search
$('#search_name').on('keyup',function(){

    loadProducts();

});

// category change
$('#search_category').change(function(){

    loadProducts();

});

// bazar change
$('#search_bazar').change(function(){

    loadProducts();

});


// pagination
$(document).on('click','.pagination a',function(e){

    e.preventDefault();

    let page=$(this).attr('href').split('page=')[1];

    loadProducts(page);

});


// reset
$('#resetFilter').click(function(){

    $('#search_name').val('');

    $('#search_category').val('');

    $('#search_bazar').val('');

    loadProducts();

});

</script>

<script>

$(document).on('blur','.price-input',function(){

    let input=$(this);

    let id=input.data('id');

    let price=input.val();

    let status=$("#price-status-"+id);

    status
        .removeClass()
        .addClass("text-blue-600 text-xs")
        .text("Saving...");

    $.ajax({

        url:"{{ route('admin.product.updatePrice') }}",

        method:"POST",

        data:{
            _token:"{{ csrf_token() }}",
            id:id,
            price:price
        },

        success:function(res){
            // Price text update
            $("#price-text-" + id).text("৳" + parseFloat(price).toFixed(2));
            
            status
                .removeClass()
                .addClass("text-green-600 text-xs")
                .text("✔ Saved");

            // Highlight row
            $("#product-row-"+id)
                .removeClass("bg-white")
                .addClass("bg-yellow-50");

            // Show Updated badge
            $("#updated-badge-"+id)
                .removeClass("text-gray-400")
                .addClass("text-green-600 font-semibold")
                .text("Updated");

            setTimeout(function(){
                status.text('');
            },1500);

        },

        error:function(){

            status
                .removeClass()
                .addClass("text-red-600 text-xs")
                .text("✖ Failed");

        }

    });

});


$("#editProductForm").submit(function(e){

    e.preventDefault();

    let formData=new FormData(this);

    $.ajax({

        url:$(this).attr("action"),

        type:"POST",

        data:formData,

        processData:false,

        contentType:false,

        beforeSend:function(){

            $("#saveBtn")
                .prop("disabled",true)
                .text("Updating...");

        },

        success:function(res){

            Swal.fire({

                icon:'success',

                title:'Success',

                text:res.message,

                timer:1500,

                showConfirmButton:false

            }).then(()=>{

                window.location=
                "{{ route('admin.manage_products') }}";

            });

        },

        error:function(xhr){

            $("#saveBtn")
                .prop("disabled",false)
                .text("Update Product");
        }

    });

});
</script>




@endsection
