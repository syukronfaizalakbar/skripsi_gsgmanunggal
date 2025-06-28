<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Penyewaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    /**
     * Menampilkan form login admin.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Menangani proses login admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt(['name' => $request->name, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard'); // Arahkan ke dashboard utama
        }

        return back()->withErrors([
            'name' => 'Username atau Password salah.',
        ])->onlyInput('name');
    }

    /**
     * Menangani proses logout admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    /**
     * Menampilkan dashboard admin utama.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // >>>>>> PERUBAHAN DI SINI <<<<<<
        // Karena dashboard.blade.php ada di resources/views/admin/dashboard.blade.php
        return view('admin.dashboard');
    }

    /**
     * Menampilkan daftar penyewaan yang menunggu konfirmasi.
     * Ini adalah halaman yang diakses dari link "Konfirmasi Penyewaan" di dashboard.
     *
     * @return \Illuminate\View\View
     */
            public function showKonfirmasiPenyewaan(Request $request)
    {
    $query = Penyewaan::with('lapangan');

    if ($request->tanggal_awal && $request->tanggal_akhir) {
        $query->whereBetween('tanggal_sewa', [$request->tanggal_awal, $request->tanggal_akhir]);
    }

    $penyewaans = $query
        ->orderByRaw("FIELD(status, 'menunggu', 'disewa', 'ditolak')")
        ->orderBy('tanggal_sewa', 'asc')
        ->get();

    return view('admin.konfirmasi_penyewaan', compact('penyewaans'));
    }

    public function konfirmasiPenyewaan($id)
    {
        $penyewaan = Penyewaan::find($id);

        if (!$penyewaan) {
            return redirect()->back()->with('error', 'Pemesanan tidak ditemukan.');
        }

        // Pastikan status masih 'menunggu' sebelum dikonfirmasi
        if ($penyewaan->status !== 'menunggu') { // DIKEMBALIKAN KE 'status'
            return redirect()->back()->with('error', 'Penyewaan sudah dikonfirmasi atau ditolak sebelumnya.');
        }

        $penyewaan->status = 'disewa'; // Menggunakan 'disewa'
        $penyewaan->save();

        return redirect()->back()->with('success', 'Penyewaan berhasil dikonfirmasi.');
    }

    /**
     * Menolak penyewaan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function tolakPenyewaan($id)
    {
        $penyewaan = Penyewaan::find($id);

        if (!$penyewaan) {
            return redirect()->back()->with('error', 'Pemesanan tidak ditemukan.');
        }

        // Pastikan status masih 'menunggu' sebelum ditolak
        if ($penyewaan->status !== 'menunggu') { // DIKEMBALIKAN KE 'status'
            return redirect()->back()->with('error', 'Penyewaan sudah dikonfirmasi atau ditolak sebelumnya.');
        }

        if ($penyewaan->bukti_transfer && Storage::disk('public')->exists($penyewaan->bukti_transfer)) {
            Storage::disk('public')->delete($penyewaan->bukti_transfer);
        }

        $penyewaan->status = 'ditolak'; // Menggunakan 'ditolak'
        $penyewaan->save();

        return redirect()->back()->with('success', 'Penyewaan berhasil ditolak.');
    }
    public function showAddAdminForm()
    {
    return view('admin.tambah_admin');
    }
    public function storeAdmin(Request $request)
    {
    $request->validate([
        'name' => 'required|string|unique:admins,name',
        'password' => 'required|string|min:6|confirmed',
    ]);

    Admin::create([
        'name' => $request->name,
        'password' => bcrypt($request->password),
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'Admin baru berhasil ditambahkan.');
    }

    public function showHapusAdminForm()
    {
        $admins = Admin::where('name', '!=', 'superadmin')->get(); // jangan tampilkan superadmin
        return view('admin.hapus_admin', compact('admins'));
    }
      public function destroyAdmin($id)
    {
    $admin = Admin::find($id);

    if (!$admin) {
        return redirect()->back()->with('error', 'Admin tidak ditemukan.');
    }

    $admin->delete();

    return redirect()->route('admin.dashboard')->with('success', 'Admin berhasil dihapus.');
    }
        public function cetakPenyewaanPDF(Request $request)
    {
    $query = Penyewaan::with('lapangan')
        ->orderByRaw("FIELD(status, 'menunggu', 'disewa', 'ditolak'), tanggal_sewa ASC");

    if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
        $query->whereBetween('tanggal_sewa', [$request->tanggal_awal, $request->tanggal_akhir]);

        $awal = Carbon::parse($request->tanggal_awal)->format('Ymd');
        $akhir = Carbon::parse($request->tanggal_akhir)->format('Ymd');
        $fileName = "Laporan-Penyewaan_{$awal}_sd_{$akhir}";
    }

    $penyewaans = $query->get();

    $pdf = Pdf::loadView('admin.penyewaan_pdf', compact('penyewaans'))
              ->setPaper('a4', 'landscape'); // opsional: bisa ubah orientasi
              
    return $pdf->download("{$fileName}.pdf"); // atau ->stream() untuk tampil langsung
    }


}
  