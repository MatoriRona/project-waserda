<!DOCTYPE html>
<html>
<head>
    <title>Cetak Nota Transaksi</title>
    <style>
        /* Gaya CSS untuk struk transaksi */
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .nota-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .nota-header h1 {
            font-size: 24px;
            margin: 5px 0;
        }

        .alamat {
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        table, th, td {
            /* border: 1px solid #000; */
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        .total-table {
            width: 50%;
        }

        .total-table td {
            padding: 5px;
            text-align: right;
        }

        .total-table td:first-child {
            text-align: left;
        }
    </style>
</head>
<body onload="window.print()">

    <div class="container">
        <div class="nota-header">
            <h1>Koperasi Syariah Masjid Raya Lubuk Jantan</h1>
            <p class="alamat">Jalan masjid, jorong cempaka, Lubuak Jantan, Kec. Lintau Buo Utara, Kabupaten Tanah Datar, Sumatera Barat 27292</p>
        </div>

        <div class="total">
            <p>Tanggal : {{ Carbon\Carbon::parse($transaksi->created_at)->format('Y-m-d H:i:s') }}</p>
            <p>Kasir : {{ $transaksi->kasir }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="text-align: center;">Item</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: center;">Harga</th>
                    <th style="text-align: center;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi_detail as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td style="text-align: right;">{{ $item->qty }}</td>
                        <td style="text-align: right;">{{ number_format($item->harga_jual) }}</td>
                        <td style="text-align: right;">{{ number_format($item->qty * $item->harga_jual) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="total-table" style="width: 100%">
            <tr>
                <td><b>Total Belanja</b></td>
                <td style="text-align: right;"><b>Rp. {{ number_format($transaksi->total) }}</b></td>
            </tr>
            <tr>
                <td><b>Tunai</b></td>
                <td style="text-align: right;"><b>Rp. {{ number_format($transaksi->cash) }}</b></td>
            </tr>
            <tr>
                <td><b>Kembalian</b></td>
                <td style="text-align: right;"><b>Rp. {{ number_format($transaksi->kembalian) }}</b></td>
            </tr>
        </table>

        <div class="total" style="text-align: center;">
            <br>
            <p><b>Terimakasih</b></p>
        </div>
    </div>
</body>
</html>
