<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <title>Karis Jaya Shop Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .receipt-container {
            width: 100%;
            max-width: 80mm;
            /* margin: 0 auto; */
            /* padding: 10px; */
        }

        .header, .footer {
            text-align: center;
        }
        .shop-name {
            font-size: 18px;
            font-weight: bold;
        }
        .shop-address, .shop-contact {
            font-size: 10px;
        }
        .receipt-number {
            margin: 10px 0;
            font-weight: bold;
        }
        .items-table {
            width: 100%;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
        }
        .items-table th, .items-table td {
            padding: 5px 0;
        }
        .items-table th {
            text-align: left;
        }
        .items-table td {
            text-align: right;
        }
        .items-table .item-name {
            text-align: left;
        }
        .totals {
            margin: 10px 0;
        }
        .totals p {
            display: flex;
            justify-content: space-between;
        }
        .total-label {
            font-weight: bold;
        }
        .suggestions {
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="header">
            <div class="shop-name">TB. JAYA BERKAH</div>
            <div class="shop-address">Jl. Dr. Ir. H. Soekarno No.19, Medokan Semampir, Surabaya</div>
            <div class="shop-contact">
                No. Telp 0812345678<br>
                16413520230802084636
            </div>
        </div>
        
        <div class="transaction-info">
            <p>{{ $transaction->created_at->format('Y-m-d H:i:s') }} <br>{{ $transaction->user->name }} <br>{{ $transaction->customer->name }}</p>
            <p class="receipt-number">No: {{ $transaction->transaction_number }}</p>
        </div>

        <table class="items-table" style="width:100%;">
            <thead>
                <tr>
                    <th class="item-name">Item</th>
                    <!-- <th>Qty</th>
                    <th>Price</th> -->
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->transaction_details as $detail)
                    <tr>
                        <td class="item-name">{{ $detail->product->name }}</td>
                        
                        <td></td>
                    </tr>
                    <tr>
                        <td class="item-name">
                            {{ $detail->qty }}x | Rp {{ number_format($detail->price, 0, ',', '.') }} | Rp. <span>{{ number_format($detail->discount, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            Rp. {{ number_format($detail->price * $detail->qty - $detail->discount, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table class="items-table" style="width:100%;">
            
            <tbody>
                <tr>
                    <td class="item-name">Sub Total</td>
                    <td>Rp {{ number_format($transaction->sub_total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class=" item-name">Discount</td>
                    <td class="">Rp {{ number_format($transaction->discount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="total-label item-name">Total</td>
                    <td class="total-label">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="item-name">Bayar</td>
                    <td>Rp {{ number_format($transaction->cash_paid, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="item-name">Kembali</td>
                    <td>Rp {{ number_format($transaction->change, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Terimakasih Telah Berbelanja</p>
            <!-- <p class="suggestions">
                Link Kritik dan Saran:<br>
                <a href="{{ $transaction->feedback_link }}">{{ $transaction->feedback_link }}</a>
            </p> -->
        </div>
    </div>
</body>
</html>
