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
        // Ini akan membuat tabel 'admins'.
        // Jika Anda baru saja menjalankan migrate:refresh, tabel ini seharusnya sudah terhapus.
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Username untuk admin
            $table->string('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
