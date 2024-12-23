<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
            font-size: 16px; /* Increased font size */
        }
        .header {
            margin-bottom: 20px;
            background-color: #f0f0f0; /* Subtle background color */
            border: 1px solid #ddd; /* Added border */
            padding: 15px; /* Added padding */
            margin-bottom: 30px; /* Added margin */
        }
        .content {
            border-collapse: collapse;
            width: 100%; /* Table takes full width */
            margin: 20px auto; /* Added margin */
            border: 1px solid #ddd; /* Added border */
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px; /* Added padding */
            text-align: left;
            font-family: monospace; /* Monospace font for table data */
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rizky Abadi Net</h1>
        <p>Ngrangkah, Sepawon, Kec. Plosoklaten, Kabupaten Kediri, Jawa Timur 64175 | Whatsapp: 6281252616127</p>
        <hr>
    </div>

    <table class="content">
        <tr>
            <th>No Tagihan</th>
            <td>{{ $tagihan->id }}</td>
        </tr>
        <tr>
            <th>Nama Pelanggan</th>
            <td>{{ $pelanggan->user->name }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ $tanggal }}</td>
        </tr>
        <tr>
            <th>Paket</th>
            <td>{{ $paket->nama_paket }}</td>
        </tr>
        <tr>
            <th>Total</th>
            <td>Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>Lunas</td>
        </tr>
        <tr>
            <th>Diterima Oleh</th>
            <td>{{ optional(optional($pembayaran)->admin)->name ?? 'Admin' }}</td>
        </tr>
    </table>

    <p style="margin-top: 20px;">Terimakasih telah melakukan pembayaran.</p>
</body>
</html>
