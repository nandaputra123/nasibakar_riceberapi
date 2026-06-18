<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_code }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            background-color: #ffffff;
            color: #333333;
            padding: 10px;
            font-size: 12px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #991b1b;
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            background-color: #991b1b;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 12px;
        }
        .info-section {
            background-color: #f9fafb;
            padding: 15px 20px;
            display: table;
            width: 100%;
        }
        .info-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .info-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            text-align: right;
        }
        .label {
            font-weight: bold;
            color: #991b1b;
            font-size: 11px;
            margin-bottom: 3px;
        }
        .value {
            color: #4b5563;
            font-size: 11px;
            margin-bottom: 10px;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-yellow { background-color: #fef3c7; color: #92400e; }
        .badge-blue { background-color: #dbeafe; color: #1e40af; }
        .badge-purple { background-color: #e9d5ff; color: #6b21a8; }
        .badge-green { background-color: #d1fae5; color: #065f46; }
        .badge-red { background-color: #fee2e2; color: #991b1b; }
        .section {
            padding: 15px 20px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #991b1b;
            border-bottom: 2px solid #991b1b;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th {
            background-color: #991b1b;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .total-section {
            background-color: #f9fafb;
            padding: 15px 20px;
            display: table;
            width: 100%;
        }
        .total-row {
            display: table;
            width: 100%;
        }
        .total-label {
            display: table-cell;
            text-align: right;
            padding-right: 30px;
            font-weight: bold;
            font-size: 14px;
        }
        .total-value {
            display: table-cell;
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            color: #991b1b;
        }
        .footer {
            padding: 15px 20px;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .whitespace-nowrap {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>RICE BERAPI</h1>
            <p>Invoice Pesanan</p>
        </div>

        <!-- Invoice Info -->
        <div class="info-section">
            <div class="info-left">
                <div class="label">Kode Pesanan:</div>
                <div class="value">{{ $order->order_code }}</div>
                
                <div class="label">Tanggal Pesanan:</div>
                <div class="value">{{ $order->created_at->format('d F Y, H:i') }}</div>
                
                <div class="label">Status Pesanan:</div>
                <div class="value">
                    @php
                        $statusLabels = [
                            'pending' => 'Menunggu',
                            'processing' => 'Diproses',
                            'ready' => 'Siap',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                        ];
                        $statusColors = [
                            'pending' => 'badge-yellow',
                            'processing' => 'badge-blue',
                            'ready' => 'badge-purple',
                            'completed' => 'badge-green',
                            'cancelled' => 'badge-red',
                        ];
                    @endphp
                    <span class="badge {{ $statusColors[$order->status] ?? 'badge-yellow' }}">
                        {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                    </span>
                </div>
            </div>

            <div class="info-right">
                <div class="label">Nama Pelanggan:</div>
                <div class="value">{{ $order->user->name }}</div>
                
                <div class="label">Email:</div>
                <div class="value">{{ $order->user->email }}</div>
                
                <div class="label">Telepon:</div>
                <div class="value">{{ $order->phone }}</div>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="section">
            <div class="section-title">Alamat Pengiriman</div>
            <p class="value">{{ $order->shipping_address }}</p>
        </div>

        <!-- Order Items -->
        <div class="section">
            <div class="section-title">Detail Pesanan</div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 10%;" class="text-center">No</th>
                        <th style="width: 40%;">Produk</th>
                        <th style="width: 15%;" class="text-center">Qty</th>
                        <th style="width: 17%;" class="text-right">Harga</th>
                        <th style="width: 18%;" class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->product_name }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right whitespace-nowrap">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="text-right whitespace-nowrap">Rp {{ number_format($item->subtotal(), 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <div class="total-section">
            <div class="total-row">
                <div class="total-label">TOTAL:</div>
                <div class="total-value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="section">
            <div class="section-title">Informasi Pembayaran</div>
            <p class="value"><strong>Metode Pembayaran:</strong> {{ $order->payment->method == 'cash' ? 'Cash (COD)' : 'Transfer Bank' }}</p>
            <p class="value">
                <strong>Status Pembayaran:</strong> 
                <span class="badge {{ $order->payment->status == 'confirmed' ? 'badge-green' : 'badge-yellow' }}">
                    {{ $order->payment->status == 'confirmed' ? 'Terkonfirmasi' : 'Pending' }}
                </span>
            </p>
            @if($order->payment->confirmed_at)
            <p class="value"><strong>Dikonfirmasi pada:</strong> {{ $order->payment->confirmed_at->format('d F Y, H:i') }}</p>
            @endif
            <p class="value"><strong>Jumlah:</strong> Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</p>
        </div>

        @if($order->note)
        <!-- Notes -->
        <div class="section">
            <div class="section-title">Catatan</div>
            <p class="value">{{ $order->note }}</p>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p style="margin-bottom: 5px;">Terima kasih telah berbelanja di Rice Berapi!</p>
            <p>Invoice ini digenerate otomatis pada {{ now()->format('d F Y, H:i') }}</p>
        </div>
    </div>
</body>
</html>
