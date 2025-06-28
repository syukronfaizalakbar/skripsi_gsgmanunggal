@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to right, #a1ffce, #faffd1); /* gradasi hijau muda - kuning muda */
        margin: 0;
        padding: 0;
    }

    .hero {
        height: calc(100vh - 56px); /* Tinggi layar dikurangi tinggi navbar */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 20px;
    }

    .hero h1 {
        font-size: 30px;
        font-weight: 700;
        color: #1b4f3e;
        margin-bottom: 25px;
    }

    .hero p {
        background-color: rgba(255, 255, 255, 0.85);
        padding: 25px;
        max-width: 800px;
        border-radius: 12px;
        font-size: 16px;
        line-height: 1.7;
        color: #2c3e50;
    }

    .btn-sewa {
        margin-top: 25px;
        background-color: #28a745;
        color: white;
        padding: 12px 30px;
        font-size: 16px;
        font-weight: bold;
        border: none;
        border-radius: 6px;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .btn-sewa:hover {
        background-color: #218838;
    }
</style>

<div class="hero">
    <h1>Selamat Datang di Website Gedung Serba Guna Manunggal</h1>
    <p>
        Gedung Serba Guna Manunggal adalah fasilitas publik yang dirancang untuk mendukung berbagai kegiatan masyarakat. Gedung ini menjadi pilihan utama anda untuk acara-acara penting seperti pertemuan warga, konser, pelatihan, kegiatan olahraga, pernikahan, dll.
        <br><br>
        Kami menyediakan beberapa jenis lapangan dan ruangan serbaguna, mulai dari aula gedung, lapangan sepak bola, lapangan voli, hingga lapangan tenis.
        <br><br>
        Jadikan Gedung Serba Guna Manunggal sebagai tempat pilihan terbaik untuk menunjang kegiatan Anda, baik individu, kelompok, maupun institusi.
    </p>
    <a href="/sewa" class="btn-sewa">Sewa Sekarang</a>
</div>
@endsection
