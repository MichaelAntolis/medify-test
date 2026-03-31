<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori - {{ $kategori->nama }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header p {
            font-size: 11px;
            color: #666;
            margin-top: 3px;
        }

        .info-section {
            margin-bottom: 20px;
        }

        .info-section h2 {
            font-size: 13px;
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 5px 8px;
            border-left: 4px solid #333;
            margin-bottom: 8px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 8px;
            vertical-align: top;
        }

        .info-table td:first-child {
            width: 120px;
            font-weight: bold;
        }

        .info-table td:nth-child(2) {
            width: 10px;
        }

        .items-section h2 {
            font-size: 13px;
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 5px 8px;
            border-left: 4px solid #333;
            margin-bottom: 8px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table th {
            background-color: #333;
            color: #fff;
            padding: 6px 8px;
            text-align: left;
            font-size: 11px;
        }

        .items-table td {
            padding: 5px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }

        .items-table tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        .no-data {
            text-align: center;
            color: #999;
            font-style: italic;
            padding: 15px;
            border: 1px dashed #ccc;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            border-top: 1px solid #ccc;
            padding-top: 6px;
            font-size: 10px;
            color: #888;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Detail Kategori Item</h1>
        <p>Sistem Informasi Medify</p>
    </div>

    <div class="info-section">
        <h2>Informasi Kategori</h2>
        <table class="info-table">
            <tr>
                <td>Nama Kategori</td>
                <td>:</td>
                <td>{{ $kategori->nama }}</td>
            </tr>
            <tr>
                <td>Kode Kategori</td>
                <td>:</td>
                <td>{{ $kategori->kode }}</td>
            </tr>
            <tr>
                <td>Jumlah Item</td>
                <td>:</td>
                <td>{{ $kategori->masterItems->count() }} item</td>
            </tr>
        </table>
    </div>

    <div class="items-section">
        <h2>Daftar Items dalam Kategori Ini</h2>

        @if($kategori->masterItems->count() > 0)
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 15%">Kode</th>
                    <th style="width: 30%">Nama Item</th>
                    <th style="width: 15%">Jenis</th>
                    <th style="width: 20%">Harga Beli</th>
                    <th style="width: 15%">Supplier</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kategori->masterItems as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td>{{ $item->supplier }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="no-data">
            Tidak ada item yang terdaftar dalam kategori ini.
        </div>
        @endif
    </div>

    <div class="footer">
        Dicetak pada: {{ $tanggalCetak }} &nbsp;|&nbsp; Kategori: {{ $kategori->kode }} - {{ $kategori->nama }}
    </div>

</body>

</html>