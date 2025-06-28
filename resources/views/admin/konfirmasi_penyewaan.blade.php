@extends('layouts.admin') {{-- Pastikan ini mengarah ke layout admin Anda yang benar --}}

@section('title', 'Konfirmasi Penyewaan')

@section('content')
    <style>
        .container-table {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 2em;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            text-align: left;
            font-size: 0.9em;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #555;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .btn-action {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            font-size: 0.85em;
            transition: background-color 0.3s ease;
            margin-right: 5px;
            margin-bottom: 5px;
        }
        .btn-konfirmasi {
            background-color: #ffc107;
            color: #212529;
        }
        .btn-konfirmasi:hover {
            background-color: #e0a800;
        }
        .btn-tolak {
            background-color: #dc3545;
        }
        .btn-tolak:hover {
            background-color: #c82333;
        }
        .btn-link {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }
        .btn-link:hover {
            text-decoration: underline;
        }
        .no-records {
            text-align: center;
            padding: 20px;
            color: #777;
        }
        form {
            display: inline-block;
            margin: 0;
        }
    </style>

    <div class="container-table">
        <h1>Konfirmasi Penyewaan</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
            <div class="mb-3 d-flex justify-content-between flex-wrap align-items-center" style="gap: 10px;"> 
                {{-- Filter Rentang Tanggal --}}
    <form method="GET" action="{{ route('admin.konfirmasi') }}" class="d-flex align-items-center flex-wrap" style="gap: 10px;">
    <label for="tanggal_awal" style="margin-bottom: 0;">Cari Tanggal:</label>
    <input type="date" name="tanggal_awal" id="tanggal_awal" value="{{ request('tanggal_awal') }}">
    <span>-</span>
    <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
    <button type="submit" class="btn-action btn-konfirmasi">Tampilkan</button>
    <a href="{{ route('admin.konfirmasi') }}" class="btn-action btn-tolak">Reset</a>
    </form>

{{-- Tombol Cetak PDF --}}
<a href="{{ route('admin.konfirmasi.cetak', ['tanggal_awal' => request('tanggal_awal'), 'tanggal_akhir' => request('tanggal_akhir')]) }}"
   class="btn-action btn-konfirmasi" target="_blank" style="white-space: nowrap;">
    Cetak PDF
</a>



        <table>
            <thead>
                <tr>
                    <th>Lapangan</th>
                    <th>Nama Pemesan</th>
                    <th>Tanggal Permohonan</th> {{-- Kolom baru --}}
                    <th>Tanggal Sewa</th>
                    <th>Durasi (Jam)</th>
                    <th>Total Harga</th>
                    <th>Bukti Transfer</th>
                    <th>Status</th> 
                </tr>
            </thead>
            <tbody>
                {{-- Menampilkan penyewaan dengan status "menunggu" terlebih dahulu --}}
                @foreach ($penyewaans->where('status', 'menunggu') as $penyewaan)
                    <tr>
                        <td>{{ $penyewaan->lapangan->nama ?? 'N/A' }}</td>
                        <td>{{ $penyewaan->nama_pemesan }}</td>
                        <td>{{ \Carbon\Carbon::parse($penyewaan->created_at)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($penyewaan->tanggal_sewa)->format('d-m-Y') }}</td>
                        <td>{{ $penyewaan->durasi_jam ?? 'N/A' }}</td>
                        <td><strong>Rp {{ number_format($penyewaan->total_harga ?? 0, 0, ',', '.') }}</strong></td>
                        <td>
                            @if ($penyewaan->bukti_transfer)
                                <a href="{{ asset('storage/' . $penyewaan->bukti_transfer) }}" target="_blank" class="btn-link">Lihat Bukti</a>
                            @else
                                Belum ada
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.konfirmasi-penyewaan', $penyewaan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-action btn-konfirmasi">Konfirmasi</button>
                            </form>
                            <form action="{{ route('admin.tolak-penyewaan', $penyewaan->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-tolak">Tolak</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                {{-- Menampilkan penyewaan lainnya (status selain "menunggu") --}}
                @php
                    $penyewaanLain = $penyewaans->filter(function($p) {
                        return $p->status !== 'menunggu';
                    });
                @endphp

                @foreach ($penyewaanLain as $penyewaan)
                    <tr>
                        <td>{{ $penyewaan->lapangan->nama ?? 'N/A' }}</td>
                        <td>{{ $penyewaan->nama_pemesan }}</td>
                        <td>{{ \Carbon\Carbon::parse($penyewaan->created_at)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($penyewaan->tanggal_sewa)->format('d-m-Y') }}</td>
                        <td>{{ $penyewaan->durasi_jam ?? 'N/A' }}</td>
                        <td><strong>Rp {{ number_format($penyewaan->total_harga ?? 0, 0, ',', '.') }}</strong></td>
                        <td>
                            @if ($penyewaan->bukti_transfer)
                                <a href="{{ asset('storage/' . $penyewaan->bukti_transfer) }}" target="_blank" class="btn-link">Lihat Bukti</a>
                            @else
                                Belum ada
                            @endif
                        </td>
                        <td>
                            {{-- Tidak perlu tombol konfirmasi/tolak untuk status selain "menunggu", bisa kosong atau info --}}
                            <em>{{ ucfirst($penyewaan->status) }}</em>
                        </td>
                    </tr>
                @endforeach

                {{-- Jika kosong semua --}}
                @if ($penyewaans->count() === 0)
                    <tr><td colspan="8" class="no-records">Tidak ada data penyewaan.</td></tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
