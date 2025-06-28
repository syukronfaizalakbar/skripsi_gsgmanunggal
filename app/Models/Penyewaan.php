<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    protected $fillable = [
        'nama_pemesan',
        'alamat_pemesan',
        'no_wa_pemesan',
        'tanggal_sewa',
        'waktu_mulai',
        'durasi_jam',
        'total_harga',
        'lapangan_id',
        'bukti_transfer',
        'status',
        'waktu_sewa_json',
    ];

    protected $casts = [
        'waktu_sewa_json' => 'array',
    ];

    // Jika ada relasi ke model Lapangan, misalnya:
    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }
}
