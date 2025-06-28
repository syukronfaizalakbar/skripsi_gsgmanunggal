<?php

namespace App\Http\Controllers;

use App\Models\Lapangan; // Pastikan ini di-use jika Anda menggunakan model Lapangan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon; // Pastikan ini di-use untuk manipulasi tanggal

class SewaController extends Controller
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
                'fasilitas' => 'Kursi: 400, Meja 150, Panggung',
                'harga_per_jam' => 150000,
            ],
            [
                'id' => 2,
                'nama' => 'Lapangan Bola Voli',
                'fasilitas' => 'Lampu, Air 2 Dus, Net',
                'harga_per_jam' => 50000,
            ],
            [
                'id' => 3,
                'nama' => 'Lapangan Sepak Bola',
                'fasilitas' => 'Air  2 Dus, Wasit, Gawang',
                'harga_per_jam' => 100000,
            ],
            [
                'id' => 4,
                'nama' => 'Lapangan Bola Tenis',
                'fasilitas' => 'Jaring, Botol Mineral 2, Lampu',
                'harga_per_jam' => 75000,
            ],
        ];

        // Ambil tanggal mulai dan tanggal akhir untuk ditampilkan di tabel
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        // Buat array tanggal untuk tabel
        $dates = [];
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dates[] = $date->toDateString();
        }

            $jadwalSewa = DB::table('penyewaans')
    ->whereIn('status', ['menunggu', 'konfirmasi', 'disewa'])
    ->get()
    ->filter(fn ($item) => $item->tanggal_sewa && $item->waktu_mulai)
    ->reduce(function ($carry, $item) {
        $lapanganId = $item->lapangan_id;
        $startTime = Carbon::parse($item->waktu_mulai);
        $durasi = $item->durasi_jam ?? 1;

        for ($i = 0; $i < $durasi; $i++) {
            $slotTime = $startTime->copy()->addHours($i)->format('H:i');
            $slotKey = $item->tanggal_sewa . ' ' . $slotTime;
            $carry[$lapanganId][$slotKey] = strtolower(trim($item->status));
        }

        return $carry;
    }, []);



        // Teruskan kedua variabel lapangans dan dates ke view
        return view('sewa', compact('lapangans', 'dates', 'jadwalSewa'));
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

        public function prosesSewa(Request $request)
        {
            $request->validate([
                'nama_pemesan' => 'required|string|max:100',
                'alamat_pemesan' => 'required|string|max:255',
                'no_wa_pemesan' => [
                    'required',
                    'regex:/^[0-9]{11,13}$/'
                ],
                'waktu_sewa' => 'required|json',
                'lapangan_id' => 'required|integer',
                'bukti_transfer' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            return back()->with('success', 'Permohonan sewa berhasil dikirim.');
        }

}
