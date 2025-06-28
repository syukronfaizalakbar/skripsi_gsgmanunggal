@extends('layouts.app')

@section('title', 'Panduan Penyewaan')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        background: linear-gradient(to right, #d9f99d, #fef3c7); /* gradasi hijau muda ke kuning pastel */
        margin: 0;
    }

    .container {
        padding: 20px;
        min-height: 100vh;
    }

    .card {
        background-color: #ffffffee;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        padding: 25px;
    }

    .card h2 {
        font-size: 20px;
        font-weight: bold;
        color: #0d47a1;
        margin-bottom: 15px;
        text-align: center;
    }

    ol.list-group-numbered {
        list-style: none;
        counter-reset: item;
        padding-left: 0;
    }

    ol.list-group-numbered > li {
        counter-increment: item;
        background-color: #ffe0b2; /* oranye muda */
        margin-bottom: 10px;
        padding: 10px 15px;
        border-radius: 8px;
        font-size: 14px;
        line-height: 1.5;
        position: relative;
        padding-left: 35px;
    }

    ol.list-group-numbered > li::before {
        content: counter(item) ".";
        position: absolute;
        left: 10px;
        top: 10px;
        font-weight: bold;
        color: #8e24aa; /* ungu tua */
    }

    .highlight-hijau {
        color: #1b5e20;
        font-weight: bold;
    }

    .highlight-kuning {
        color: #f9a825;
        font-weight: bold;
    }

    .highlight-coklat {
        color: #4e342e;
        font-weight: bold;
    }
</style>

<div class="container">
    <div class="card">
        <h2>Langkah-Langkah Penyewaan</h2>
        <ol class="list-group-numbered">
            <li>Buka halaman <strong>Sewa Lapangan</strong> pada menu navigasi.</li>
            <li>
                    Kotak berwarna 
                    <span style="background-color: #e6ffe6; color: black; padding: 2px 6px; border-radius: 4px; font-weight: bold;">HIJAU MUDA</span> (Tersedia), 
                    berwarna 
                    <span style="background-color: #ffff00; color: black; padding: 2px 6px; border-radius: 4px; font-weight: bold;">KUNING</span> (Menunggu konfirmasi), 
                    berwarna 
                    <span style="background-color: #8B4513; color: white; padding: 2px 6px; border-radius: 4px; font-weight: bold;">COKLAT</span> (Disewa).
            </li>
            <li>Pilih jenis lapangan, tanggal, dan jam yang diinginkan dan pastikan kotak yang akan dipilih berwarna  <span style="background-color: #e6ffe6; color: black; padding: 2px 6px; border-radius: 4px; font-weight: bold;">HIJAU MUDA</span></li>
            <li>Isi formulir penyewaan (nama, alamat, dan nomor WhatsApp) dengan sesuai.</li>
            <li>Lakukan pembayaran melalui QRIS atau transfer pada rekening yang tersedia dan pastikan jumlahnya benar.</li>
            <li>Upload bukti pembayaran pada form.</li>
            <li>Admin akan memverifikasi pembayaran dan menyetujui jadwal penyewaan.</li>
            <li>Jadwal yang sudah disewa akan ditandai pada sistem dengan warna <span class="highlight-coklat">COKLAT</span>.</li>
        </ol>
    </div>

    <div class="card">
        <h2>Tata Tertib Penyewaan</h2>
        <ol class="list-group-numbered">
            <li>Penyewa wajib mengisi data diri dengan lengkap dan benar saat melakukan pemesanan.</li>
            <li>Pembayaran dilakukan melalui QRIS atau transfer pada rekening yang tersedia, dan bukti pembayaran harus diunggah pada form.</li>
            <li>Konfirmasi pembayaran akan dilakukan pada jam operasional (08.00-16.00) lebih dari itu akan dilakukan besok hari.</li>
            <li>Dilarang merusak fasilitas yang tersedia. Jika terjadi kerusakan, maka biaya perbaikan sepenuhnya dibebankan kepada penyewa.</li>
            <li>Dilarang menggunakan area gedung/lapangan untuk kegiatan yang melanggar hukum atau norma sosial.</li>
            <li>Pihak pengelola berhak membatalkan pemesanan jika ditemukan pelanggaran tata tertib.</li>
            <li>Dengan melakukan penyewaan, penyewa dianggap telah menyetujui seluruh tata tertib yang berlaku.</li>
        </ol>
    </div>
</div>
@endsection
