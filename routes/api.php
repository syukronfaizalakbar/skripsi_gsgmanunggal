<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JadwalController; // Pastikan namespace ini benar

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/lapangan/{id}', [LapanganController::class, 'getDetail'])->name('api.lapangan.detail');
Route::get('/jadwal/{lapanganId}/{tanggal}', [JadwalController::class, 'getJadwal']);