<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penyewaan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Penyewaan</h2>
    <table>
        <thead>
            <tr>
                <th>Lapangan</th>
                <th>Nama Pemesan</th>
                <th>Tanggal Sewa</th>
                <th>Durasi</th>
                <th>Total Harga</th>
                <th>Status</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($penyewaans as $p)
                <tr>
                    <td>{{ $p->lapangan->nama ?? '-' }}</td>
                    <td>{{ $p->nama_pemesan }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_sewa)->format('d-m-Y') }}</td>
                    <td>{{ $p->durasi_jam ?? '-' }}</td>
                    <td>Rp {{ number_format($p->total_harga ?? 0, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($p->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
