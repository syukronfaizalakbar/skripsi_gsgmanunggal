<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\View\View; // Pastikan ini di-use
use Carbon\Carbon; // Pastikan ini di-use untuk manipulasi tanggal
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    /**
     * Menampilkan halaman pemilihan lapangan dan slot waktu.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Menggunakan data lapangan hardcoded seperti yang Anda berikan
        $lapangans = [
            [
                'id' => 1,
                'nama' => 'Aula Gedung',
                'fasilitas' => 'AC, Kursi: 300, Panggung',
                'harga_per_jam' => 150000,
            ],
            [
                'id' => 2,
                'nama' => 'Lapangan Bola Voli',
                'fasilitas' => 'Lantai Vinyl, Net',
                'harga_per_jam' => 50000,
            ],
            [
                'id' => 3,
                'nama' => 'Lapangan Sepak Bola',
                'fasilitas' => 'Air Gelas 2 Dus, Wasit, Lampu',
                'harga_per_jam' => 100000,
            ],
            [
                'id' => 4,
                'nama' => 'Lapangan Bola Tenis',
                'fasilitas' => 'Lantai Karet, Jaring',
                'harga_per_jam' => 75000,
            ],
        ];

        // Ambil tanggal mulai dan tanggal akhir untuk ditampilkan di tabel
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->addDays(10)->endOfDay(); // Menampilkan 10 hari ke depan

        // Buat array tanggal untuk tabel
        $dates = [];
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dates[] = $date->toDateString();
        }

        // Teruskan kedua variabel lapangans dan dates ke view
        return view('sewa', compact('lapangans', 'dates'));
    }

    /**
     * Menampilkan form penyewaan.
     * (Ini adalah method yang dipanggil oleh rute /form-sewa sekarang)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function showFormSewa(Request $request): View
    {
        return view('form_sewa');
    }
}
