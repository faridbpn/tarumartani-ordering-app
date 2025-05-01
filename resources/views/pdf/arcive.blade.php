<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Arsip</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <h2>Data Arsip</h2>
    <p style="text-align: center; font-size: 10px;">Diunduh pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Customer</th>
                <th>Nomor Meja</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Alasan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $arsip)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $arsip->user->name ?? 'Unknown' }}</td>
                <td>{{ $arsip->table_number ?? 'N/A' }}</td>
                <td>Rp {{ number_format($arsip->total_amount, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($arsip->archived_at)->format('d-m-Y H:i') }}</td>
                <td>{{ ucfirst($arsip->archive_status) }}</td>
                <td>{{ $arsip->archive_reason ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <style>
        .page-number::after {
            content: "Halaman " counter(page);
        }
    </style>
    <div style="position: absolute; bottom: 10px; right: 10px; font-size: 10px;" class="page-number"></div>
</body>
</html>