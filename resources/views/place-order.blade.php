@extends('apps.front_master')
@section('content')

<section class="max-w-4xl mx-auto px-4 sm:px-6 py-8">
  <h2 class="text-2xl sm:text-3xl font-bold text-green-700 mb-6 text-center">🛒 অর্ডার পেজ</h2>

  @if(count($cartItems) > 0)
  <form action="{{ route('save.order') }}" method="POST" class="space-y-6">
    @csrf

    <!-- ✅ Cart Items -->
    <div class="bg-white rounded-2xl shadow p-2 md:p-6 mb-6">
      <h3 class="text-xl font-semibold text-gray-700 mb-4">আপনার ব্যাগের পণ্যসমূহ</h3>

      <div class="space-y-4">
        @foreach($cartItems as $cart)
 <div
  class="cart-item border border-gray-100 rounded-xl p-2 sm:p-4 shadow-sm hover:shadow-md transition-all duration-200 space-y-3 sm:space-y-0 sm:flex sm:items-center sm:justify-between"
  data-product_id="{{ $cart->product_id }}" data-id="{{ $cart->id }}"
>
  <!-- 🖼 Product Info (Top row) -->
  <div class="flex items-center gap-3 w-full sm:w-1/3">
    <img
      src="{{ $cart->product->image ? url('uploads/products/'.$cart->product->image) : '' }}"
      class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-xl border border-gray-200"
      alt="product"
    >
    <h4 class="font-semibold text-gray-800 text-sm sm:text-base leading-tight">
      {{ $cart->product->name }}
    </h4>
  </div>

  <!-- 🔢 Bottom Row (Qty + Price + Remove) -->
  <div class="flex justify-between items-center flex-wrap w-full sm:w-auto gap-3 sm:gap-6 mt-0 sm:mt-0">
    
    <!-- Quantity -->
    <div class="flex items-center">
      <button type="button"
        class="bg-green-500 text-white px-3 py-1 rounded-l-full"
        onclick="changeQty(this, 'decrease')">−</button>
      <input type="number"
        value="{{ $cart->quantity }}"
        min="1"
        class="w-14 text-center border border-gray-300 focus:ring-2 focus:ring-green-400 py-1  rounded">
      <button type="button"
        class="bg-green-500 text-white px-3 py-1 rounded-r-full"
        onclick="changeQty(this, 'increase')">+</button>
    </div>

    <!-- Price -->
    <div class="text-center">
      <p class="text-green-600 text-sm">
        ৳{{ bnNum($cart->price) }} × <span class="itemQty">{{ $cart->quantity }}</span>
      </p>
      <p class="font-semibold text-green-700 itemTotal">
        ৳{{ bnNum($cart->price * $cart->quantity) }}
      </p>
    </div>

    <!-- Remove -->
    <button type="button"
      class="text-red-500 hover:text-red-700 text-xl font-bold"
      onclick="removeItem(this)">❌</button>
  </div>
</div>

        @endforeach
      </div>

<!-- 🧩 Custom Product Section -->
<div class="bg-gray-50 rounded-2xl border p-4 mt-5" id="customProductsSection">

    <h3 class="text-sm sm:text-lg font-semibold text-gray-700 mb-3 flex justify-between">

        <span>➕ কাস্টম পণ্য যোগ করুন</span>

        <button type="button"
            id="addCustomProduct"
            class="bg-green-600 text-sm md:text-md sm:text-lg text-white px-3 py-1 rounded-lg hover:bg-green-700 transition">
            + নতুন পণ্য
        </button>

    </h3>

    <div id="customProductList" class="space-y-3 w-full"></div>

</div>
 

      <input type="hidden" id="baseTotal" value="{{ $total }}">
      <input type="hidden" id="customTotal" name="customTotal" value="0">

      <div class="flex justify-between mt-6 text-sm sm:text-lg font-bold text-green-700">
        <span>মোট</span>
        <span id="cartTotal">৳{{ $total }} 
          <span class="text-sm text-gray-600">+ ডেলিভারি চার্জ</span>
        </span>
      </div>
      <p class="text-sm text-red-500 mt-2 text-right">
        ডেলিভারি চার্জঃ আপনার বাড়ি থেকে বাজারের দূরত্ব, ভেন বা অটোরিকশার ভাড়ার সমান।
      </p>
    </div>

    <!-- 🚚 Delivery Info -->
    <div class="bg-white rounded-2xl shadow p-4 sm:p-6">
      <h3 class="text-sm sm:text-lg font-semibold text-gray-700 mb-4">ডেলিভারি তথ্য</h3>

      <div class="space-y-3">
        <div>
          <label class="text-sm text-gray-600 mb-1 block">আপনার নাম</label>
          <input type="text" name="name" value="{{ $user->name }}"
              class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none" readonly>
        </div>

        <div>
          <label class="text-sm text-gray-600 mb-1 block">পিতার নাম</label>
          <input type="text" name="father_name" value="{{ $user->father_name }}"
              class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none" readonly>
        </div>

        <div class="flex items-center gap-2">
          <input type="checkbox" id="newAddress" class="form-checkbox h-5 w-5 text-green-600">
          <label for="newAddress" class="text-sm text-gray-700">নতুন ঠিকানা যোগ করুন</label>
        </div>

        <div>
          <label class="text-sm text-gray-600 mb-1 block">ঠিকানা</label>
          <input type="text" name="address" id="addressInput" value="{{ $user->address }}"
              class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none" readonly>
        </div>

        <div>
          <label class="text-sm text-gray-600 mb-1 block">মোবাইল নম্বর</label>
          <input type="tel" name="phone" id="phoneInput" value="{{ $user->phone }}"
              class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-green-400 outline-none" readonly>
        </div>
      </div>

      <button type="submit"
          class="bg-green-600 text-white w-full py-3 rounded-lg text-sm sm:text-lg hover:bg-green-700 mt-5 transition font-semibold">
        ✅ অর্ডার কনফার্ম করুন
      </button>
    </div>
  </form>
  @else
  <p class="text-center text-sm sm:text-lg text-gray-500">আপনার কার্ট খালি।</p>
  @endif
</section>





<!-- Quantity Updated Notification -->
<div id="qtyNotification" 
     class="fixed bottom-5 right-5 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg opacity-0 transition-opacity duration-300 z-50">
  ✅ Quantity updated
</div>



@endsection

@section('scripts')
<script>


function showQtyNotification() {
    const notif = document.getElementById('qtyNotification');
    if (!notif) return;

    notif.classList.remove('opacity-0');
    notif.classList.add('opacity-100');

    // ২ সেকেন্ড পরে আবার fade out হবে
    setTimeout(() => {
        notif.classList.remove('opacity-100');
        notif.classList.add('opacity-0');
    }, 2000);
}

 // ======================
// 🛒 Main Cart Functions
// ======================

// 🔹 Quantity Change
function changeQty(btn, type) {
    const item = btn.closest('.cart-item');
    if (!item) return;

    const input = item.querySelector('input');
    let qty = parseInt(input.value);
    qty = type === 'increase' ? qty + 1 : Math.max(1, qty - 1);
    input.value = qty;

    const itemQty = item.querySelector('.itemQty');
    if (itemQty) itemQty.textContent = qty;

    const id = item.dataset.id;

    $.ajax({
        url: "{{ route('cart.update') }}",
        method: 'POST',
        data: { id, quantity: qty },
        success: function (data) {
            if (data.success) {
                item.querySelector('.itemTotal').innerText = `৳${data.itemTotal}`;
                document.getElementById('baseTotal').value = data.cartTotal; // update hidden baseTotal
                updateGrandTotal();
                showToast('success', 'Updated', '✅ পরিমাণ আপডেট হয়েছে');
            } else {
                showToast('error', 'Failed', 'আপডেট ব্যর্থ হয়েছে ❌');
            }
        },
        error: function () {
            showToast('error', 'Server Error', 'সার্ভারে সমস্যা হয়েছে!');
        },
    });
}

// 🔹 Remove Item
function removeItem(btn) {
    const item = btn.closest('.cart-item');
    if (!item) return;

    console.log(item);
    
    const id = item.dataset.product_id;
    const routeUrl = `{{ route('cart.remove', ':id') }}`.replace(':id', id);

    swalConfirm('আপনি কি এই পণ্যটি কার্ট থেকে মুছে ফেলতে চান?', function () {
        $.ajax({
            url: routeUrl,
            method: 'POST',
            success: function (data) {
                if (data.success) {
                    item.remove();
                    document.getElementById('baseTotal').value = data.cartTotal;
                    updateGrandTotal();
                    showToast('success', 'Removed', 'পণ্যটি মুছে ফেলা হয়েছে 🗑️');
                } else {
                    showToast('error', 'Failed', 'রিমুভ করা যায়নি!');
                }
            },
            error: function () {
                showToast('error', 'Server Error', 'সার্ভারে সমস্যা হয়েছে!');
            },
        });
    });
}

// 🔹 New Address Toggle
const newAddressCheckbox = document.getElementById('newAddress');
const addressInput = document.getElementById('addressInput');
const phoneInput = document.getElementById('phoneInput');

if (newAddressCheckbox) {
    newAddressCheckbox.addEventListener('change', function () {
        const editable = this.checked;
        [addressInput, phoneInput].forEach((input) => {
            if (editable) {
                input.removeAttribute('readonly');
                input.focus();
            } else {
                input.setAttribute('readonly', true);
            }
        });
    });
}
 
 
// ==========================================================
// 🧩 CUSTOM PRODUCT SYSTEM
// ==========================================================


// ==========================================================
// 🔢 বাংলা সংখ্যা → English Number
// ==========================================================

function convertBanglaNumber(value) {

    if (value === null || value === undefined) {
        return '';
    }

    const banglaDigits = '০১২৩৪৫৬৭৮৯';
    const englishDigits = '0123456789';

    return String(value)
        .replace(/[০-৯]/g, function (char) {

            const index = banglaDigits.indexOf(char);

            return index !== -1
                ? englishDigits[index]
                : char;

        })
        .replace(/٫/g, '.')
        .replace(/,/g, '');
}


// ==========================================================
// 🔢 Get Number Safely
// ==========================================================

function getNumber(value) {

    value = convertBanglaNumber(value);

    value = String(value)
        .trim()
        .replace(/,/g, '');

    if (value === '') {
        return 0;
    }

    const number = parseFloat(value);

    return Number.isFinite(number)
        ? number
        : 0;
}


// ==========================================================
// ➕ Add Custom Product
// ==========================================================

document
    .getElementById('addCustomProduct')
    .addEventListener('click', function () {

        const id = Date.now();

        const productHtml = `

            <div
                class="custom-product border p-4 rounded-2xl bg-gray-50 shadow-sm
                       flex flex-col md:flex-row md:items-center md:gap-3 gap-3"
                data-id="${id}"
            >

                <!-- ==========================================
                     Product Name
                =========================================== -->

                <input
                    type="text"
                    name="custom_products[${id}][name]"
                    class="cp-name border border-green-300 p-2 rounded-lg w-full
                           focus:ring-2 focus:ring-green-400 outline-none"
                    placeholder="পণ্যের নাম"
                    required
                >


                <div class="flex flex-col sm:flex-row w-full gap-3">


                    <!-- ======================================
                         Unit
                    ======================================= -->

                    <div class="w-full sm:w-1/3">

                        <label class="block text-xs text-gray-500 mb-1">
                            একক
                        </label>

                        <select
                            name="custom_products[${id}][unit]"
                            class="cp-unit border border-green-300 p-2 rounded-lg
                                   w-full focus:ring-2 focus:ring-green-400 outline-none"
                            required
                        >

                            <option value="কেজি">কেজি</option>
                            <option value="লিটার">লিটার</option>
                            <option value="পিস">পিস</option>
                            <option value="ডজন">ডজন</option>
                            <option value="টাকা">টাকা</option>

                        </select>

                    </div>


                    <!-- ======================================
                         Quantity
                    ======================================= -->

                    <div class="cp-qty-wrapper w-full sm:w-1/2">

                        <label class="cp-value-label block text-xs text-gray-500 mb-1">
                            পরিমাণ
                        </label>

                        <input
                            type="text"
                            name="custom_products[${id}][qty]"
                            class="cp-qty bangla-number border border-green-300
                                   p-2 rounded-lg w-full
                                   focus:ring-2 focus:ring-green-400 outline-none"
                            placeholder="পরিমাণ"
                            inputmode="decimal"
                            autocomplete="off"
                        >

                    </div>


                    <!-- ======================================
                         Price
                    ======================================= -->

                    <div class="cp-price-wrapper w-full sm:w-1/2 hidden">

                        <label class="cp-price-label block text-xs text-gray-500 mb-1">
                            মূল্য (৳)
                        </label>

                        <input
                            type="text"
                            name="custom_products[${id}][price]"
                            class="cp-price bangla-number border border-green-300
                                   p-2 rounded-lg w-full
                                   focus:ring-2 focus:ring-green-400 outline-none"
                            placeholder="টাকার পরিমাণ"
                            inputmode="decimal"
                            autocomplete="off"
                        >

                    </div>

                </div>


                <!-- ==========================================
                     Remove
                =========================================== -->

                <button
                    type="button"
                    class="text-red-500 hover:text-red-700 font-bold
                           text-2xl self-end md:self-center removeCustom"
                >
                    ×
                </button>

            </div>

        `;


        document
            .getElementById('customProductList')
            .insertAdjacentHTML(
                'beforeend',
                productHtml
            );


        const row = document.querySelector(
            `.custom-product[data-id="${id}"]`
        );


        const unitSelect =
            row.querySelector('.cp-unit');


        // ==============================================
        // Unit Change
        // ==============================================

        unitSelect.addEventListener(
            'change',
            function () {

                updateCustomProductField(row);

                updateCustomTotal();

            }
        );


        // Initial state
        updateCustomProductField(row);

        updateCustomTotal();

    });


// ==========================================================
// 🔄 Quantity / Price Field Show Hide
// ==========================================================

function updateCustomProductField(row) {

    const unit =
        row.querySelector('.cp-unit').value;


    const qtyInput =
        row.querySelector('.cp-qty');

    const priceInput =
        row.querySelector('.cp-price');


    const qtyWrapper =
        row.querySelector('.cp-qty-wrapper');

    const priceWrapper =
        row.querySelector('.cp-price-wrapper');


    const valueLabel =
        row.querySelector('.cp-value-label');



    // ======================================================
    // টাকা
    // ======================================================

    if (unit === 'টাকা') {

        qtyWrapper.classList.add('hidden');

        priceWrapper.classList.remove('hidden');


        priceInput.required = true;

        qtyInput.required = false;


        priceInput.placeholder =
            'টাকার পরিমাণ';


        // Quantity clear
        qtyInput.value = '';

    }


    // ======================================================
    // Other Units
    // ======================================================

    else {

        qtyWrapper.classList.remove('hidden');

        priceWrapper.classList.add('hidden');


        qtyInput.required = true;

        priceInput.required = false;


        valueLabel.textContent =
            'পরিমাণ';


        qtyInput.placeholder =
            `পরিমাণ (${unit})`;


        // Price clear
        priceInput.value = '';

    }

}


// ==========================================================
// 🧮 Custom Product Total
// ==========================================================

function calculateCustomTotal() {

    let total = 0;


    document
        .querySelectorAll('.custom-product')
        .forEach(function (row) {

            const unit =
                row.querySelector('.cp-unit')?.value;


            const qty =
                getNumber(
                    row.querySelector('.cp-qty')?.value
                );


            const price =
                getNumber(
                    row.querySelector('.cp-price')?.value
                );


            /*
            |--------------------------------------------------------------------------
            | টাকা
            |--------------------------------------------------------------------------
            | টাকা select করলে price-টাই টাকা
            |--------------------------------------------------------------------------
            */

            if (unit === 'টাকা') {

                total += price;

            }


            /*
            |--------------------------------------------------------------------------
            | কেজি / লিটার / পিস / ডজন
            |--------------------------------------------------------------------------
            |
            | এখানে শুধু quantity নেওয়া হচ্ছে।
            | কারণ এই unit-গুলোর জন্য price field নেই।
            |
            |--------------------------------------------------------------------------
            */

            else {

                // এখানে টাকা যোগ হবে না।
                // শুধু quantity হিসেবে থাকবে।

            }

        });


    return total;

}


// ==========================================================
// 💰 Update Custom Total Display
// ==========================================================

function updateCustomTotal() {

    const total =
        calculateCustomTotal();


    /*
    |--------------------------------------------------------------------------
    | customTotal element
    |--------------------------------------------------------------------------
    */

    const totalElement =
        document.getElementById('customTotal');


    if (totalElement) {

        const formatted =
            total.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });


        /*
        | যদি input হয়
        */

        if (
            totalElement.tagName === 'INPUT' ||
            totalElement.tagName === 'TEXTAREA'
        ) {

            totalElement.value = formatted;

        }


        /*
        | যদি div / span / p হয়
        */

        else {

            totalElement.textContent =
                formatted;

        }

    }


    // Grand Total update
    updateGrandTotal();

}


// ==========================================================
// 🧮 Get Base Total
// ==========================================================

function getBaseTotal() {

    const baseElement =
        document.getElementById('baseTotal');


    if (!baseElement) {
        return 0;
    }


    /*
    |--------------------------------------------------------------------------
    | Input হলে value
    |--------------------------------------------------------------------------
    */

    if (
        baseElement.tagName === 'INPUT' ||
        baseElement.tagName === 'TEXTAREA'
    ) {

        return getNumber(
            baseElement.value
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Div / Span হলে textContent
    |--------------------------------------------------------------------------
    */

    return getNumber(
        baseElement.textContent
    );

}


// ==========================================================
// 🧮 Grand Total
// ==========================================================

function updateGrandTotal() {

    /*
    |--------------------------------------------------------------------------
    | Base Order Total
    |--------------------------------------------------------------------------
    */

    const base =
        getBaseTotal();


    /*
    |--------------------------------------------------------------------------
    | Custom Product Total
    |--------------------------------------------------------------------------
    */

    const custom =
        calculateCustomTotal();


    /*
    |--------------------------------------------------------------------------
    | Grand Total
    |--------------------------------------------------------------------------
    */

    const grand =
        base + custom;


    /*
    |--------------------------------------------------------------------------
    | Display
    |--------------------------------------------------------------------------
    */

    const cartTotal =
        document.getElementById('cartTotal');


    if (cartTotal) {

        cartTotal.textContent =
            `৳${grand.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })}`;

    }


    /*
    |--------------------------------------------------------------------------
    | Optional hidden/input field
    |--------------------------------------------------------------------------
    */

    const grandTotalInput =
        document.getElementById('grandTotal');


    if (grandTotalInput) {

        grandTotalInput.value =
            grand.toFixed(2);

    }


    return grand;

}


// ==========================================================
// ✍️ Input Change
// ==========================================================

document.addEventListener(
    'input',
    function (e) {

        if (
            e.target.classList.contains('cp-qty') ||
            e.target.classList.contains('cp-price')
        ) {

            updateCustomTotal();

        }

    }
);


// ==========================================================
// 🗑 Remove Custom Product
// ==========================================================

document.addEventListener(
    'click',
    function (e) {

        const removeButton =
            e.target.closest('.removeCustom');


        if (!removeButton) {
            return;
        }


        const row =
            removeButton.closest('.custom-product');


        if (row) {

            row.remove();

            updateCustomTotal();

        }

    }
);


// ==========================================================
// 🔢 Convert Bangla Numbers Before Submit
// ==========================================================

const customProductForm =
    document
        .getElementById('customProductsSection')
        ?.closest('form');


if (customProductForm) {

    customProductForm.addEventListener(
        'submit',
        function () {

            document
                .querySelectorAll('.bangla-number')
                .forEach(function (input) {

                    input.value =
                        convertBanglaNumber(
                            input.value
                        );

                });


            /*
            |--------------------------------------------------------------------------
            | Grand Total English number হিসেবে রাখুন
            |--------------------------------------------------------------------------
            */

            const grandTotal =
                updateGrandTotal();


            const grandTotalInput =
                document.getElementById('grandTotal');


            if (grandTotalInput) {

                grandTotalInput.value =
                    grandTotal.toFixed(2);

            }

        }
    );

}


// ==========================================================
// 🚀 Initial Calculation
// ==========================================================

document.addEventListener(
    'DOMContentLoaded',
    function () {

        updateCustomTotal();

    }
);
 


</script>
@endsection
