@extends('layouts.app') {{-- Asumsi Anda memiliki layout utama --}}

@section('title', 'Dashboard Admin')

@section('content')
    <style>
        .dashboard-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .dashboard-title {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .welcome-message {
            font-size: 1.2em;
            color: #666;
            margin-bottom: 30px;
        }
        .dashboard-links {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .dashboard-link-item {
            background-color: #007bff;
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1.1em;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .dashboard-link-item:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }
        .logout-form {
            margin-top: 40px;
        }
        .btn-logout {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }
        .btn-logout:hover {
            background-color: #c82333;
        }
    </style>

    <div class="dashboard-container">
        <h2 class="dashboard-title">Dashboard Admin</h2>
            @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
         @endif
        <div class="dashboard-links">
            {{-- Link untuk Konfirmasi Penyewaan (sebelumnya Kelola Penyewaan) --}}
            <a href="{{ route('admin.konfirmasi-penyewaan.index') }}" class="dashboard-link-item">Kelola Penyewaan</a>
            {{-- Link baru untuk Tambah Admin --}}
            <a href="{{ route('admin.tambah-admin.form') }}" class="dashboard-link-item">Tambah Admin</a>
            <a href="{{ route('admin.hapus-admin.form') }}" class="dashboard-link-item">Hapus Admin</a>
        </div>

        <form action="{{ route('admin.logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
@endsection
