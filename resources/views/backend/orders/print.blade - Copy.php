
<!DOCTYPE html>
<html lang="bn">

<head>

    <meta charset="UTF-8">

    <title>Invoice #{{ $order->id }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">


    <style>

        * {
            box-sizing: border-box;
        }


        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            color: #111827;
        }
        
@media print {

    @page {
        size: A4 portrait;
        margin: 8mm;
    }

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0 !important;
        padding: 0 !important;
        background: #fff !important;
        font-size: 10px !important;
    }

    .print-button {
        display: none !important;
    }

    .invoice {
        width: 100% !important;
        max-width: none !important;
        margin: 0 !important;
        padding: 8px !important;

        /* ২টি invoice এক A4-তে */
        height: 138mm;

        page-break-inside: avoid;
        break-inside: avoid;
    }

    .header {
        padding-bottom: 5px !important;
        margin-bottom: 8px !important;
        border-bottom-width: 1px !important;
    }

    .company {
        font-size: 17px !important;
    }

    .invoice-title {
        font-size: 15px !important;
    }

    .customer {
        line-height: 1.35 !important;
        margin-bottom: 8px !important;
        font-size: 10px !important;
    }

    table {
        margin-top: 5px !important;
        font-size: 9px !important;
    }

    th,
    td {
        padding: 4px 5px !important;
        line-height: 1.2 !important;
    }

    th {
        font-size: 9px !important;
    }

    .summary {
        margin-top: 8px !important;
        max-width: 330px !important;
        font-size: 9px !important;
    }

    .summary-row {
        padding: 3px 0 !important;
        gap: 10px !important;
    }

    .delivery-total {
        margin-top: 3px !important;
        padding-top: 4px !important;
    }

    .summary-total {
        margin-top: 4px !important;
        padding-top: 5px !important;
        font-size: 13px !important;
    }

    .footer {
        margin-top: 8px !important;
        padding-top: 5px !important;
        font-size: 8px !important;
    }

    /* প্রতিটি invoice-এর পর জায়গা */
    .invoice + .invoice {
        margin-top: 4mm !important;
        border-top: 1px dashed #999;
        padding-top: 6px !important;
    }
}

        .invoice {
            width: 100%;
            max-width: 800px;
            margin: auto;
            background: #ffffff;
            padding: 25px;
        }


        /* PRINT BUTTON */

        .print-button {
            text-align: center;
            margin-bottom: 20px;
        }


        .print-button button {
            background: #111827;
            color: #ffffff;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
        }


        /* HEADER */

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;

            border-bottom: 2px solid #111827;

            padding-bottom: 12px;

            margin-bottom: 20px;
        }


        .company {
            font-size: 24px;
            font-weight: bold;
        }


        .invoice-title {
            font-size: 20px;
            font-weight: bold;
        }


        /* CUSTOMER */

        .customer {
            line-height: 1.8;
            margin-bottom: 20px;
        }


        /* PRODUCT TABLE */

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }


        th,
        td {
            border: 1px solid #d1d5db;
            padding: 8px;
        }


        th {
            background: #f3f4f6;
            text-align: left;
        }


        td:first-child {
            width: 45px;
            text-align: center;
        }


        td:nth-child(3),
        td:nth-child(4),
        td:nth-child(5) {
            text-align: right;
        }


        /* SUMMARY */

        .summary {
            margin-top: 20px;
            width: 100%;
            max-width: 500px;
            margin-left: auto;
        }


        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 7px 0;

            gap: 20px;
        }


        .summary-row span:first-child {
            text-align: left;
        }


        .summary-row span:last-child {
            text-align: right;
            white-space: nowrap;
        }


        .delivery-row {
            color: #374151;
        }


        .delivery-total {
            border-top: 1px solid #d1d5db;

            margin-top: 5px;

            padding-top: 9px;

            font-weight: bold;
        }


        .summary-total {
            display: flex;
            justify-content: space-between;

            border-top: 2px solid #111827;

            margin-top: 8px;

            padding-top: 12px;

            font-size: 20px;

            font-weight: bold;
        }


        /* FOOTER */

        .footer {
            text-align: center;

            margin-top: 25px;

            padding-top: 12px;

            border-top: 1px solid #d1d5db;

            font-size: 13px;

            color: #6b7280;
        }


        /* PRINT */

        @media print {

            body {
                background: #ffffff;
                padding: 0;
            }


            .print-button {
                display: none;
            }


            .invoice {
                max-width: none;
                padding: 10px;
            }

        }

    </style>

</head>


<body>


{{-- =========================================================
     PRINT BUTTON
========================================================= --}}

<div class="print-button">
    <button type="button" id="printInvoiceBtn">
        🖨 Print Invoice
    </button>
</div>



<div class="invoice">


    {{-- =========================================================
         HEADER
    ========================================================= --}}

    <div class="header">

        <div class="company">

            অনলাইন সদায়

        </div>


        <div class="invoice-title">

            INVOICE #{{ $order->id }}

        </div>

    </div>



    {{-- =========================================================
         CUSTOMER INFORMATION
    ========================================================= --}}

    <div class="customer">

        <strong>Customer:</strong>

        {{ $order->user->name ?? 'N/A' }}

        <br>


        <strong>Phone:</strong>

        {{ $order->user->phone ?? '-' }}

        <br>


        <strong>Address:</strong>

        {{ $order->delivery_address ?? '-' }}

        <br>


        <strong>Order Date:</strong>

        {{ $order->created_at?->format('d-m-Y h:i A') }}

    </div>



    {{-- =========================================================
         INITIAL TOTAL VARIABLES
    ========================================================= --}}

    @php

        $productTotal = 0;

        $customTotal = 0;

        $itemNumber = 0;


        /*
        |--------------------------------------------------------------------------
        | KG / LITER TOTAL QUANTITY
        |--------------------------------------------------------------------------
        */

        $kgLiterQuantity = 0;


        /*
        |--------------------------------------------------------------------------
        | PIECE / DOZEN / PACKET QUANTITY
        |--------------------------------------------------------------------------
        */

        $pieceQuantity = 0;

        $dozenQuantity = 0;

        $packetQuantity = 0;

    @endphp



    {{-- =========================================================
         PRODUCT TABLE
    ========================================================= --}}

    <table>

        <thead>

            <tr>

                <th>#</th>

                <th>Product</th>

                <th>Qty</th>

                <th>Price</th>

                <th>Total</th>

            </tr>

        </thead>


        <tbody>


            {{-- =================================================
                 NORMAL PRODUCTS
            ================================================= --}}

            @foreach($order->items as $item)

                @php

                    $itemNumber++;


                    $qty = (float) $item->quantity;

                    $price = (float) $item->price;


                    $lineTotal = $qty * $price;


                    $productTotal += $lineTotal;


                    /*
                    |--------------------------------------------------------------------------
                    | PRODUCT UNIT
                    |--------------------------------------------------------------------------
                    */

                    $unit = strtolower(
                        trim($item->product->unit ?? '')
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | KG / LITER
                    |--------------------------------------------------------------------------
                    */

                    if (
                        in_array($unit, [
                            'kg',
                            'kgs',
                            'kilogram',
                            'kilograms',
                            'liter',
                            'litre',
                            'ltr',
                            'liters',
                            'litres',
                            'কেজি',
                            'লিটার'
                        ])
                    ) {

                        $kgLiterQuantity += $qty;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | PIECE
                    |--------------------------------------------------------------------------
                    */

                    elseif (
                        in_array($unit, [
                            'piece',
                            'pc',
                            'pcs',
                            'পিস'
                        ])
                    ) {

                        $pieceQuantity += $qty;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | DOZEN
                    |--------------------------------------------------------------------------
                    */

                    elseif (
                        in_array($unit, [
                            'dozen',
                            'dz',
                            'ডজন'
                        ])
                    ) {

                        $dozenQuantity += $qty;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | PACKET
                    |--------------------------------------------------------------------------
                    */

                    elseif (
                        in_array($unit, [
                            'packet',
                            'pack',
                            'pkt',
                            'প্যাকেট'
                        ])
                    ) {

                        $packetQuantity += $qty;

                    }

                @endphp


                <tr>

                    <td>

                        {{ $itemNumber }}

                    </td>


                    <td>

                        {{ $item->product->name ?? 'Product' }}

                    </td>


                    <td>

                        {{ rtrim(rtrim(number_format($qty, 2), '0'), '.') }}

                        {{ $item->product->unit ?? '' }}

                    </td>


                    <td>

                        ৳{{ number_format($price, 2) }}

                    </td>


                    <td>

                        ৳{{ number_format($lineTotal, 2) }}

                    </td>

                </tr>

            @endforeach



            {{-- =================================================
                 CUSTOM PRODUCTS
            ================================================= --}}

            @foreach($order->custom_products as $item)

                @php

                    $itemNumber++;


                    $qty = (float) $item->quantity;

                    $price = (float) $item->price;


                    /*
                    |--------------------------------------------------------------------------
                    | CUSTOM PRODUCT TOTAL
                    |--------------------------------------------------------------------------
                    */

                    $lineTotal = $item->unit === 'টাকা'

                        ? $price

                        : $qty * $price;


                    $customTotal += $lineTotal;


                    /*
                    |--------------------------------------------------------------------------
                    | CUSTOM PRODUCT UNIT
                    |--------------------------------------------------------------------------
                    */

                    $unit = strtolower(
                        trim($item->unit ?? '')
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | KG / LITER
                    |--------------------------------------------------------------------------
                    */

                    if (
                        in_array($unit, [
                            'kg',
                            'kgs',
                            'kilogram',
                            'kilograms',
                            'liter',
                            'litre',
                            'ltr',
                            'liters',
                            'litres',
                            'কেজি',
                            'লিটার'
                        ])
                    ) {

                        $kgLiterQuantity += $qty;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | PIECE
                    |--------------------------------------------------------------------------
                    */

                    elseif (
                        in_array($unit, [
                            'piece',
                            'pc',
                            'pcs',
                            'পিস'
                        ])
                    ) {

                        $pieceQuantity += $qty;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | DOZEN
                    |--------------------------------------------------------------------------
                    */

                    elseif (
                        in_array($unit, [
                            'dozen',
                            'dz',
                            'ডজন'
                        ])
                    ) {

                        $dozenQuantity += $qty;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | PACKET
                    |--------------------------------------------------------------------------
                    */

                    elseif (
                        in_array($unit, [
                            'packet',
                            'pack',
                            'pkt',
                            'প্যাকেট'
                        ])
                    ) {

                        $packetQuantity += $qty;

                    }

                @endphp


                <tr>

                    <td>

                        {{ $itemNumber }}

                    </td>


                    <td>

                        {{ $item->name ?? 'Custom Product' }}

                    </td>


                    <td>

                        @if($item->unit === 'টাকা')

                            -

                        @else

                            {{ rtrim(rtrim(number_format($qty, 2), '0'), '.') }}

                            {{ $item->unit }}

                        @endif

                    </td>


                    <td>

                        ৳{{ number_format($price, 2) }}

                    </td>


                    <td>

                        ৳{{ number_format($lineTotal, 2) }}

                    </td>

                </tr>

            @endforeach


        </tbody>

    </table>



    {{-- =========================================================
         DELIVERY CHARGE
    ========================================================= --}}
@php

    /*
    |--------------------------------------------------------------------------
    | PRODUCT GRAND TOTAL
    |--------------------------------------------------------------------------
    */

    $productGrandTotal =
        $productTotal +
        $customTotal;


    /*
    |--------------------------------------------------------------------------
    | SAVED DELIVERY CHARGE
    |--------------------------------------------------------------------------
    |
    | Admin/Rider থেকে delivery charge already save করা থাকলে
    | সেটাই invoice-এ ব্যবহার হবে।
    |
    */

    $savedDeliveryCharge = (float) ($order->delivery_charge ?? 0);


    /*
    |--------------------------------------------------------------------------
    | CALCULATED DELIVERY CHARGE
    |--------------------------------------------------------------------------
    */

    $kgLiterCharge = 0;

    if ($kgLiterQuantity > 0) {
        $kgLiterCharge = 10;
    }


    $pieceCharge = 0;

    if (
        $pieceQuantity > 0 ||
        $dozenQuantity > 0 ||
        $packetQuantity > 0
    ) {
        $pieceCharge = 20;
    }


    $calculatedDeliveryCharge =
        $kgLiterCharge +
        $pieceCharge;


    /*
    |--------------------------------------------------------------------------
    | FINAL DELIVERY CHARGE
    |--------------------------------------------------------------------------
    |
    | Saved charge থাকলে saved charge।
    | না থাকলে calculated charge।
    |
    */

    if ($savedDeliveryCharge > 0) {

        $totalDeliveryCharge =
            $savedDeliveryCharge;

    } else {

        $totalDeliveryCharge =
            $calculatedDeliveryCharge;

    }


    /*
    |--------------------------------------------------------------------------
    | FINAL GRAND TOTAL
    |--------------------------------------------------------------------------
    */

    $grandTotal =
        $productGrandTotal +
        $totalDeliveryCharge;

@endphp


    {{-- =========================================================
         SUMMARY
    ========================================================= --}}

    <div class="summary">


        {{-- PRODUCT TOTAL --}}

        <div class="summary-row">

            <span>

                <strong>
                    পণ্যের মোট মূল্য
                </strong>

            </span>


            <span>

                ৳{{ number_format($productGrandTotal, 2) }}

            </span>

        </div>



        {{-- =====================================================
             KG / LITER DELIVERY
        ===================================================== --}}

        <div class="summary-row delivery-row">

            <span>

                মোট
                {{ rtrim(rtrim(number_format($kgLiterQuantity, 2), '0'), '.') }}
                কেজি/লিটার

            </span>


            <span>

                ৳{{ number_format($kgLiterCharge, 2) }}

            </span>

        </div>



        {{-- =====================================================
             PIECE / DOZEN / PACKET DELIVERY
        ===================================================== --}}

        <div class="summary-row delivery-row">

            <span>

                পিস:
                {{ rtrim(rtrim(number_format($pieceQuantity, 2), '0'), '.') }}

                |

                ডজন:
                {{ rtrim(rtrim(number_format($dozenQuantity, 2), '0'), '.') }}

                |

                প্যাকেট:
                {{ rtrim(rtrim(number_format($packetQuantity, 2), '0'), '.') }}

            </span>


            <span>

                ৳{{ number_format($pieceCharge, 2) }}

            </span>

        </div>



        {{-- =====================================================
             TOTAL DELIVERY CHARGE
        ===================================================== --}}

        <div class="summary-row delivery-total">

            <span>

                মোট ডেলিভারি চার্জ

            </span>


            <span>

                ৳{{ number_format($totalDeliveryCharge, 2) }}

            </span>

        </div>



        {{-- =====================================================
             GRAND TOTAL
        ===================================================== --}}

<div class="summary-total">
    <span>
        সর্বমোট
    </span>

    <span>
        ৳{{ number_format($grandTotal, 2) }}
    </span>
</div>


    </div>



    {{-- =========================================================
         FOOTER
    ========================================================= --}}

    <div class="footer">

        ধন্যবাদ — অনলাইন সদায় থেকে কেনাকাটা করার জন্য।

    </div>


</div>

<script>
document.getElementById('printInvoiceBtn').addEventListener('click', function (e) {
    e.preventDefault();
    e.stopPropagation();

    window.print();

    return false;
});
</script>


</body>

</html>

