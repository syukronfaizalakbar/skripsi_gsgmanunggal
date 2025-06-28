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
        Schema::create('lapangans', function (Blueprint $table) {
            $table->id(); // Kolom ID (primary key, auto-increment)
            $table->string('nama'); // Nama lapangan
            $table->text('fasilitas')->nullable(); // Kolom fasilitas, bisa kosong
            $table->integer('harga_per_jam'); // Harga sewa per jam
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapangans');
    }
};
