<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penyewaans', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel 'lapangans'
            $table->foreignId('lapangan_id')->constrained('lapangans')->onDelete('cascade');
            $table->date('tanggal_sewa'); // Tanggal penyewaan
            $table->time('waktu_mulai'); // Waktu mulai penyewaan
            $table->json('waktu_sewa_json')->nullable(); // Menyimpan array slot waktu yang dipilih (JSON)
            $table->integer('durasi_jam'); // Durasi total dalam jam
            $table->decimal('total_harga', 10, 2); // Total harga penyewaan
            $table->string('nama_pemesan'); // Nama lengkap pemesan
            $table->text('alamat_pemesan'); // Alamat pemesan
            $table->string('no_wa_pemesan'); // Nomor WhatsApp pemesan
            $table->string('bukti_transfer')->nullable(); // Path ke file bukti transfer (bisa kosong)
            // Status penyewaan: menunggu konfirmasi, sudah dikonfirmasi, atau ditolak
            $table->enum('status', ['menunggu', 'konfirmasi', 'ditolak'])->default('menunggu');
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyewaans');
    }
};
