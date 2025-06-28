@extends('layouts.app')

@section('title', 'Hapus Admin')

@section('content')
<style>
    .container-hapus-admin {
        max-width: 800px;
        margin: 50px auto;
        padding: 30px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .judul-hapus {
        text-align: center;
        font-size: 2em;
        font-weight: bold;
        color: #333;
        margin-bottom: 25px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        padding: 14px;
        text-align: center;
        border-bottom: 1px solid #eee;
    }

    th {
        background-color: #007bff;
        color: white;
        font-weight: 600;
    }

    tr:hover {
        background-color: #f2f2f2;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        font-size: 0.9em;
        transition: background-color 0.3s ease;
    }

    .btn-delete:hover {
        background-color: #c82333;
    }
</style>

<div class="container-hapus-admin">
    <h2 class="judul-hapus">Hapus Admin</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Nama Admin</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
    @foreach ($admins as $admin)
        <tr>
            <td>{{ $admin->name }}</td>
            <td>
                <form action="{{ route('admin.hapus-admin', $admin->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus admin ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">Hapus</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>

    </table>
</div>
@endsection
