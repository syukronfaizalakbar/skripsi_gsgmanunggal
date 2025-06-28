<?php

namespace App\Http\Controllers;

use App\Models\Penyewaan;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PenyewaanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'alamat_pemesan' => 'required|string|max:255',
            'no_wa_pemesan' => 'required|digits_between:11,13|regex:/^[0-9]+$/',
            'waktu_sewa' => 'required|json',
            'lapangan_id' => 'required|exists:lapangans,id',
            'bukti_transfer' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $buktiTransferPath = null;
        if ($request->hasFile('bukti_transfer')) {
            $buktiTransferPath = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
        }

        $waktuSewaArray = json_decode($request->waktu_sewa, true);

        if (empty($waktuSewaArray)) {
            Log::error("waktu_sewa_array kosong saat membuat penyewaan.");
            return back()->with('error', 'Pilihan waktu sewa tidak ditemukan. Silakan coba lagi.')->withInput();
        }

        try {
            $firstDateTime = Carbon::parse($waktuSewaArray[0]);
            $tanggalSewa = $firstDateTime->toDateString();
            $waktuMulai = $firstDateTime->toTimeString();
        } catch (\Exception $e) {
            Log::error("Error parsing date/time: " . $e->getMessage());
            return back()->with('error', 'Format tanggal atau waktu tidak valid. Silakan coba lagi.')->withInput();
        }

        $durasiJam = count($waktuSewaArray);

        $lapangan = Lapangan::find($request->lapangan_id);

        if (!$lapangan) {
            Log::error("Lapangan dengan ID {$request->lapangan_id} tidak ditemukan.");
            return back()->with('error', 'Lapangan yang dipilih tidak valid. Silakan coba lagi.')->withInput();
        }

        $totalHarga = $durasiJam * ($lapangan->harga_per_jam ?? 0);

        $penyewaan = Penyewaan::create([
            'nama_pemesan' => $request->nama_pemesan,
            'alamat_pemesan' => $request->alamat_pemesan,
            'no_wa_pemesan' => $request->no_wa_pemesan,
            'tanggal_sewa' => $tanggalSewa,
            'waktu_mulai' => $waktuMulai,
            'durasi_jam' => $durasiJam,
            'total_harga' => $totalHarga,
            'lapangan_id' => $request->lapangan_id,
            'bukti_transfer' => $buktiTransferPath,
            'status' => 'menunggu',
            'waktu_sewa_json' => $waktuSewaArray,
        ]);

        return redirect()->route('sewa.berhasil', $penyewaan->id)->with('success', 'Permohonan sewa berhasil dikirim!');
    }
    public function showFormSewa(Request $request)
    {
    // Kalau kamu mau, bisa kirim data lama (old) atau dari query params di sini
    return view('form_sewa'); // Ganti 'form_sewa' dengan nama blade view form sewa kamu
    }

    public function success(Penyewaan $penyewaan)
    {
        return view('sewa_berhasil', compact('penyewaan'));
    }
}
