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

        .invoice {
            width: 100%;
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid #111827;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .company {
            font-size: 24px;
            font-weight: bold;
        }

        .invoice-title {
            font-size: 22px;
            font-weight: bold;
        }

        .customer {
            margin-bottom: 20px;
            line-height: 1.7;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f3f4f6;
        }

        .total {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
        }

        .print-button {
            text-align: center;
            margin-bottom: 20px;
        }

        .print-button button {
            background: #dc2626;
            color: white;
            border: 0;
            padding: 10px 25px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        @media print {

            body {
                background: white;
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

<div class="print-button">

    <button onclick="window.print()">
        🖨 Print Invoice
    </button>

</div>


<div class="invoice">

    <div class="header">

        <div class="company">
            অনলাইন সদায়
        </div>

        <div class="invoice-title">
            INVOICE #{{ $order->id }}
        </div>

    </div>


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

        @php
            $grandTotal = 0;
        @endphp


        @foreach($order->items as $key => $item)

            @php
                $qty = (float) $item->quantity;
                $price = (float) $item->price;
                $lineTotal = $qty * $price;

                $grandTotal += $lineTotal;
            @endphp

            <tr>

                <td>{{ $key + 1 }}</td>

                <td>
                    {{ $item->product->name ?? 'Product' }}
                </td>

                <td>
                    {{ $qty }}
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


        @foreach($order->custom_products as $key => $item)

            @php
                $qty = (float) $item->quantity;
                $price = (float) $item->price;

                $lineTotal = $item->unit === 'টাকা'
                    ? $price
                    : $qty * $price;

                $grandTotal += $lineTotal;
            @endphp

            <tr>

                <td>
                    {{ $order->items->count() + $key + 1 }}
                </td>

                <td>
                    {{ $item->name ?? 'Custom Product' }}
                </td>

                <td>
                    {{ $item->unit === 'টাকা' ? '-' : $qty . ' ' . $item->unit }}
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


    <div class="total">

        Order Total:
        ৳{{ number_format($order->total_amount, 2) }}

    </div>

</div>

</body>
</html>