@extends('layouts.app')

@section('title', 'Penyewaan Berhasil')

@section('content')
    <div class="container" style="margin-top: 50px;">
        <div class="jumbotron" style="background-color: #e9ecef; border-radius: 10px; padding: 30px;">
            <h1 class="display-4" style="color: #28a745; font-weight: bold;">Berhasil!</h1>
            <p class="lead" style="margin-top: 20px; font-size: 1.2em;">
                Permohonan penyewaan Anda telah berhasil dikirim.
                Silakan tunggu konfirmasi dari Admin.
            </p>
            <hr class="my-4">
            <a class="btn btn-primary btn-lg" href="{{ route('sewa') }}" role="button" style="margin-top: 20px;">Kembali ke Daftar Sewa</a>
        </div>
    </div>
@endsection