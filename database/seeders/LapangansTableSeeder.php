<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // Tambahkan ini

class LapangansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menonaktifkan pemeriksaan foreign key sementara
        Schema::disableForeignKeyConstraints();

        // Hapus data yang ada untuk menghindari duplikasi saat seeding berulang
        DB::table('lapangans')->truncate();

        // Mengaktifkan kembali pemeriksaan foreign key
        Schema::enableForeignKeyConstraints();

        // Masukkan data lapangan
        DB::table('lapangans')->insert([
            [
                'id' => 1,
                'nama' => 'Aula Gedung',
                'fasilitas' => 'AC, Kursi: 300, Panggung',
                'harga_per_jam' => 2000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nama' => 'Lapangan Bola Voli',
                'fasilitas' => 'Lantai Vinyl, Net',
                'harga_per_jam' => 50000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nama' => 'Lapangan Sepak Bola',
                'fasilitas' => 'Rumput Sintetis, Air Gelas 2 Dus, Wasit, Lampu (Malam Hari)',
                'harga_per_jam' => 100000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'nama' => 'Lapangan Bola Tenis',
                'fasilitas' => 'Lantai Karet, Jaring',
                'harga_per_jam' => 75000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
