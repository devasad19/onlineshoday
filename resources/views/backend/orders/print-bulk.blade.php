<!DOCTYPE html>
<html lang="bn">

<head>

    <meta charset="UTF-8">

    <title>Bulk Order Print</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #e5e7eb;
            color: #111827;
        }

        /* =========================
           PRINT BUTTON
        ========================= */

        .print-button {
            text-align: center;
            margin-bottom: 20px;
        }

        .print-button button {
            background: #dc2626;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 15px;
        }

        /* =========================
           A4 SHEET
        ========================= */

        .a4-sheet {
            width: 100%;
            max-width: 800px;
            margin: 0 auto 20px;
            background: white;
        }

        /* =========================
           INVOICE
        ========================= */

        .invoice {
            width: 100%;
            background: white;
            padding: 20px;

            page-break-inside: avoid;
            break-inside: avoid;
        }

        /* দ্বিতীয় invoice */

        .invoice + .invoice {
            border-top: 1px dashed #9ca3af;
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;

            border-bottom: 1px solid #111827;

            padding-bottom: 7px;
            margin-bottom: 10px;
        }

        .company {
            font-size: 19px;
            font-weight: bold;
        }

        .invoice-title {
            font-size: 15px;
            font-weight: bold;
        }

        /* =========================
           CUSTOMER
        ========================= */

        .customer {
            margin-bottom: 8px;
            line-height: 1.35;
            font-size: 10px;
        }

        .customer strong {
            font-weight: bold;
        }

        /* =========================
           TABLE
        ========================= */

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;

            font-size: 9px;
        }

        th,
        td {
            border: 1px solid #d1d5db;

            padding: 4px 5px;

            text-align: left;

            line-height: 1.2;
        }

        th {
            background: #f3f4f6;
            font-weight: bold;
        }

        td:first-child {
            width: 30px;
            text-align: center;
        }

        td:nth-child(3),
        td:nth-child(4),
        td:nth-child(5) {
            text-align: right;
            white-space: nowrap;
        }

        /* =========================
           SUMMARY
        ========================= */

        .summary {
            width: 100%;
            max-width: 330px;

            margin-left: auto;
            margin-top: 7px;

            font-size: 9px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 2.5px 0;

            gap: 10px;
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

            margin-top: 2px;
            padding-top: 4px;

            font-weight: bold;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;

            border-top: 1.5px solid #111827;

            margin-top: 4px;
            padding-top: 5px;

            font-size: 13px;
            font-weight: bold;
        }

        /* =========================
           FOOTER
        ========================= */

        .footer {
            text-align: center;

            margin-top: 6px;
            padding-top: 4px;

            border-top: 1px solid #d1d5db;

            font-size: 8px;
            color: #6b7280;
        }


        /* ==================================================
           PRINT
        ================================================== */

        @media print {

            @page {
                size: A4 portrait;
                margin: 7mm;
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

            .a4-sheet {
                width: 100% !important;

                max-width: none !important;

                margin: 0 !important;

                background: #fff !important;

                /*
                 * প্রতি A4-তে ২টি invoice
                 */
                height: 283mm;

                page-break-after: always;

                break-after: page;

                display: flex;

                flex-direction: column;
            }

            .a4-sheet:last-child {
                page-break-after: auto;
                break-after: auto;
            }

            .invoice {
                width: 100% !important;

                /*
                 * ২টা invoice সমানভাবে ভাগ
                 */
                height: 141mm;

                padding: 7px !important;

                page-break-inside: avoid;
                break-inside: avoid;
            }

            .invoice + .invoice {
                border-top: 1px dashed #777 !important;

                padding-top: 7px !important;
            }

            .header {
                padding-bottom: 4px !important;
                margin-bottom: 6px !important;

                border-bottom: 1px solid #111827 !important;
            }

            .company {
                font-size: 17px !important;
            }

            .invoice-title {
                font-size: 13px !important;
            }

            .customer {
                margin-bottom: 6px !important;

                line-height: 1.25 !important;

                font-size: 9px !important;
            }

            table {
                margin-top: 4px !important;

                font-size: 8px !important;
            }

            th,
            td {
                padding: 3px 4px !important;

                line-height: 1.1 !important;
            }

            th {
                font-size: 8px !important;
            }

            .summary {
                margin-top: 5px !important;

                max-width: 300px !important;

                font-size: 8px !important;
            }

            .summary-row {
                padding: 2px 0 !important;

                gap: 8px !important;
            }

            .delivery-total {
                margin-top: 2px !important;

                padding-top: 3px !important;
            }

            .summary-total {
                margin-top: 3px !important;

                padding-top: 4px !important;

                font-size: 11px !important;
            }

            .footer {
                margin-top: 5px !important;

                padding-top: 3px !important;

                font-size: 7px !important;
            }

        }

    </style>

</head>

<body>


<!-- =========================
     PRINT BUTTON
========================= -->

<div class="print-button">

    <button type="button" onclick="window.print(); return false;">

        🖨 Print All Invoices

    </button>

</div>


<!--
=========================================================
2টি করে Invoice একটি A4 Page-এ
=========================================================
-->

@foreach($orders->chunk(2) as $orderChunk)

    <div class="a4-sheet">


        @foreach($orderChunk as $order)


            @php

                /*
                |--------------------------------------------------------------------------
                | Totals
                |--------------------------------------------------------------------------
                */

                $productTotal = 0;

                $customTotal = 0;

                $itemNumber = 0;


                /*
                |--------------------------------------------------------------------------
                | Quantity counters
                |--------------------------------------------------------------------------
                */

                $kgLiterQuantity = 0;

                $pieceQuantity = 0;

                $dozenQuantity = 0;

                $packetQuantity = 0;


            @endphp


            <div class="invoice">


                <!-- =========================
                     HEADER
                ========================= -->

                <div class="header">

                    <div class="company">
                        অনলাইন সদায়
                    </div>

                    <div class="invoice-title">
                        INVOICE #{{ $order->id }}
                    </div>

                </div>


                <!-- =========================
                     CUSTOMER
                ========================= -->

                <div class="customer">

                    <strong>Customer:</strong>
                    {{ $order->user->name ?? 'N/A' }}

                    &nbsp; | &nbsp;

                    <strong>Phone:</strong>
                    {{ $order->user->phone ?? '-' }}

                    <br>

                    <strong>Address:</strong>
                    {{ $order->delivery_address ?? '-' }}

                    <br>

                    <strong>Order Date:</strong>
                    {{ $order->created_at?->format('d-m-Y h:i A') }}

                </div>


                <!-- =========================
                     PRODUCT TABLE
                ========================= -->

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


                    <!-- =========================
                         NORMAL PRODUCTS
                    ========================= -->

                    @foreach($order->items as $item)

                        @php

                            $itemNumber++;

                            $qty = (float) $item->quantity;

                            $price = (float) $item->price;

                            $lineTotal = $qty * $price;

                            $productTotal += $lineTotal;


                            /*
                            |--------------------------------------------------------------------------
                            | Unit
                            |--------------------------------------------------------------------------
                            */

                            $unit = strtolower(
                                trim(
                                    (string) ($item->product->unit ?? '')
                                )
                            );


                            /*
                            |--------------------------------------------------------------------------
                            | KG / Liter
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
                            | Piece
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
                            | Dozen
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
                            | Packet
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


                    <!-- =========================
                         CUSTOM PRODUCTS
                    ========================= -->

                    @foreach($order->custom_products as $item)

                        @php

                            $itemNumber++;

                            $qty = (float) $item->quantity;

                            $price = (float) $item->price;


                            $lineTotal = $item->unit === 'টাকা'
                                ? $price
                                : $qty * $price;


                            $customTotal += $lineTotal;


                            /*
                            |--------------------------------------------------------------------------
                            | Custom Product Unit
                            |--------------------------------------------------------------------------
                            */

                            $unit = strtolower(
                                trim(
                                    (string) ($item->unit ?? '')
                                )
                            );


                            /*
                            |--------------------------------------------------------------------------
                            | KG / Liter
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
                            | Piece
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
                            | Dozen
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
                            | Packet
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


                <!-- =========================
                     SUMMARY CALCULATION
                ========================= -->

                @php

                    $productGrandTotal =
                        $productTotal + $customTotal;


                    /*
                    |--------------------------------------------------------------------------
                    | Existing saved delivery charge
                    |--------------------------------------------------------------------------
                    */

                    $totalDeliveryCharge =
                        (float) ($order->delivery_charge ?? 0);


                @endphp


                <!-- =========================
                     SUMMARY
                ========================= -->

                <div class="summary">


                    <!-- Product Total -->

                    <div class="summary-row">

                        <span>
                            পণ্যের মোট মূল্য
                        </span>

                        <span>
                            ৳{{ number_format($productGrandTotal, 2) }}
                        </span>

                    </div>


                    <!-- KG / Liter -->

                    @if($kgLiterQuantity > 0)

                        <div class="summary-row delivery-row">

                            <span>

                                মোট
                                {{ rtrim(rtrim(number_format($kgLiterQuantity, 2), '0'), '.') }}
                                কেজি/লিটার

                            </span>

                            <span>
                                —
                                ৳{{ number_format(0, 2) }}
                            </span>

                        </div>

                    @endif


                    <!-- Piece / Dozen / Packet -->

                    @if(
                        $pieceQuantity > 0 ||
                        $dozenQuantity > 0 ||
                        $packetQuantity > 0
                    )

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
                                —
                                ৳{{ number_format(0, 2) }}
                            </span>

                        </div>

                    @endif


                    <!-- Total Delivery -->

                    <div class="summary-row delivery-total">

                        <span>
                            মোট ডেলিভারি চার্জ
                        </span>

                        <span>
                            ৳{{ number_format($totalDeliveryCharge, 2) }}
                        </span>

                    </div>


                    <!-- Grand Total -->

                    <div class="summary-total">

                        <span>
                            সর্বমোট
                        </span>

                        <span>
                            ৳{{ number_format($order->total_amount, 2) }}
                        </span>

                    </div>


                </div>


                <!-- =========================
                     FOOTER
                ========================= -->

                <div class="footer">

                    ধন্যবাদ। অনলাইন সদায়-এর সাথে কেনাকাটার জন্য।

                </div>


            </div>


        @endforeach


    </div>

@endforeach


</body>

</html>