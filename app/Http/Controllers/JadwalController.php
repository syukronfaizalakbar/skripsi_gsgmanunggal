<?php

namespace App\Http\Controllers;

use App\Models\Penyewaan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Mengambil data jadwal penyewaan untuk lapangan dan tanggal tertentu.
     *
     * @param  int  $lapangan_id
     * @param  string  $tanggal (format: YYYY-MM-DD)
     * @return \Illuminate\Http\JsonResponse
     */
    public function getJadwal(int $lapangan_id, string $tanggal): JsonResponse
    {
        $penyewaans = Penyewaan::where('lapangan_id', $lapangan_id)
            ->where('tanggal_sewa', $tanggal)
            ->get();

        $jadwalTerisi = [];
        foreach ($penyewaans as $penyewaan) {
            $waktuMulai = \Carbon\Carbon::parse($penyewaan->waktu_mulai)->hour;
            $durasi = (int) $penyewaan->durasi_jam;

            for ($i = 0; $i < $durasi; $i++) {
                $jam = (string) ($waktuMulai + $i);
                $jadwalTerisi[$jam] = true;
            }
        }

        return response()->json($jadwalTerisi);
    }
}