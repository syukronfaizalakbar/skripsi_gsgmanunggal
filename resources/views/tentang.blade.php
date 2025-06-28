@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')

<style>
    body {
        background: linear-gradient(to right, #fdfbfb, #ebedee);
        font-family: 'Segoe UI', sans-serif;
    }

    .about-section {
        padding: 20px 10px;
        background-color: #fffefc;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }

    .about-title {
        font-size: 28px;
        font-weight: 700;
        text-align: center;
        margin-top: 30px;
        margin-bottom: 30px;
        color: #2c3e50;
        text-shadow: 1px 1px 1px #ffffff;
    }

    .about-images .col {
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: transform 0.3s ease;
    }

    .about-images .col:hover {
        transform: translateY(-4px);
    }

    .about-images img {
        width: 100%;
        height: 230px;
        object-fit: cover;
        border-radius: 14px;
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
        border: 3px solid #fff;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .about-images img:hover {
        transform: scale(1.04);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    .about-images h5 {
        margin-top: 10px;
        font-size: 16px;
        font-weight: 600;
        color: #3b3b3b;
    }

    hr {
        border: 0;
        height: 2px;
        width: 60%;
        background: linear-gradient(to right, #0d6efd, #20c997, transparent);
        margin: 40px auto;
        border-radius: 2px;
    }

    .contact-section {
        font-size: 15px;
        text-align: center;
        margin-top: 25px;
        background-color: #f1f9ff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
    }

    .contact-section h4 {
        font-size: 20px;
        margin-bottom: 10px;
        color: #0d6efd;
        font-weight: 700;
    }

    .contact-section a {
        color: #0d6efd;
        font-weight: 500;
        text-decoration: none;
    }

    .contact-section a:hover {
        text-decoration: underline;
    }
</style>


<div class="container about-section">
    <h2 class="about-title">Tentang Gedung Serba Guna Manunggal</h2>

    <div class="row row-cols-1 row-cols-md-4 g-4 about-images">
        <div class="col text-center">
            <img src="{{ asset('images/aula1.jpg') }}" alt="Aula Gedung">
            <h5>Aula Gedung</h5>
        </div>
        <div class="col text-center">
            <img src="{{ asset('images/bola2.jpg') }}" alt="Lapangan Sepakbola">
            <h5>Lapangan Sepakbola</h5>
        </div>
        <div class="col text-center">
            <img src="{{ asset('images/tenis1.jpg') }}" alt="Lapangan Tenis">
            <h5>Lapangan Tenis</h5>
        </div>
        <div class="col text-center">
            <img src="{{ asset('images/voli1.jpg') }}" alt="Lapangan Voli">
            <h5>Lapangan Voli</h5>
        </div>
    </div>

    <hr>

    <div class="contact-section">
        <h4>Kontak Kami</h4>
        <p>
            📞 WhatsApp: <a href="https://wa.me/6281234567890" target="_blank">0812-3456-7890</a><br>
            📍 Alamat: Jl. Solo-Purwodadi km 11.5, Cinet, Bulurejo, Gondangrejo, Karanganyar<br>
        </p>
        <div><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.819737875289!2d110.80887257431763!3d-7.485147373810472!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a1102d8d98057%3A0x7191d39a19075fd3!2sGEDUNG%20SERBA%20GUNA%20MANUNGGAL!5e0!3m2!1sid!2sid!4v1751083903620!5m2!1sid!2sid" 
            width="600" 
            height="450" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
</div>
        </div>

@endsection
