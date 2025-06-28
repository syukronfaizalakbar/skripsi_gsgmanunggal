@extends('layouts.app') {{-- Pastikan ini sesuai dengan nama layout utama kamu --}}

@section('title', 'Login Admin')

@section('content')
    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-center">Login Admin</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block font-semibold">Nama Pengguna</label>
                <input type="text" id="name" name="name" class="w-full border px-3 py-2 rounded" required autofocus value="{{ old('name') }}">
            </div>

            <div class="mb-4">
                <label for="password" class="block font-semibold">Password</label>
                <input type="password" id="password" name="password" class="w-full border px-3 py-2 rounded" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 font-bold">Login</button>
        </form>
    </div>
@endsection
