<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Transaksi Penjualan</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 40px;
      color: #333;
    }

    h2 {
      text-align: center;
    }

    .header {
      text-align: center;
      margin-bottom: 20px;
    }

    .info {
      margin-bottom: 20px;
    }

    .info table {
      width: 100%;
    }

    .info td {
      padding: 4px 8px;
    }

    table.report {
      width: 100%;
      border-collapse: collapse;
    }

    table.report th, table.report td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: center;
    }

    table.report th {
      background-color: #f2f2f2;
    }

    .total-row {
      font-weight: bold;
    }

    .footer {
      margin-top: 40px;
      text-align: right;
    }
  </style>
</head>
<body>
  <div class="header">
    <!-- <div class="shop-name">{{ $setting->name }}</div>
    <div class="shop-address">{{ $setting->address }}</div>
    <div class="shop-contact">
        No. Telp {{ $setting->phone }}
    </div> -->
    <h2>Laporan Transaksi {{ $type == 'out' ? 'Penjualan' : 'Pembelian' }}</h2>
    <p>Periode: {{ \Carbon\Carbon::parse($start_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($end_date)->translatedFormat('d F Y') }}</p>

  </div>

  <div class="info">
    <table>
      <tr>
        <td><strong>Nama Toko:</strong></td>
        <td>{{ $setting->name }}</td>
      </tr>
      <tr>
        <td><strong>Alamat:</strong></td>
        <td>{{ $setting->address }}</td>
      </tr>
    </table>
  </div>

  <table class="report">
    <thead>
      <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>No. Transaksi</th>
        <th>Nama Pelanggan</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp
        @foreach ($transactions as $i => $t)
            @php $total += $t->total; @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $t->date->format('d-m-Y') }}</td>
                <td>{{ $t->transaction_number }}</td>
                <td>{{ $type == 'out' ? $t->customer->name : $t->supplier->name }}</td>
                <td>Rp{{ number_format($t->total, 0, ',', '.') }}</td>
            </tr>
        @endforeach

      
      <!-- Tambahkan baris transaksi lain di sini -->
      <tr class="total-row">
        <td colspan="4">Total Penjualan</td>
         <td>Rp{{ number_format($total, 0, ',', '.') }}</td>
      </tr>
    </tbody>
  </table>

    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>

</body>
</html>