<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\MahasiswaWebController;

Route::get('/data-mahasiswa', [MahasiswaWebController::class,
'index'])->name('mahasiswa.index');

Route::get('/data-mahasiswa/{nim}', [MahasiswaWebController::class,
'show'])->name('mahasiswa.show');

Route::get('/', function () {
    return view('namanim');
});

Route::get('/salam', function () {
return 'Selamat datang di Pemrograman Web II';
});

Route::get('/matakuliah/{kode}', [MatakuliahController::class, 'show']);

Route::get('/semester/{angka}', function (int $angka) {
return 'Semester ke ' . $angka;
})->whereNumber('angka');

Route::get('/cari-mahasiswa', [MahasiswaWebController::class, 'cari']);

Route::get('/matakuliah', [MatakuliahController::class, 'index']);

Route::get('/mahasiswa-data', [MahasiswaWebController::class,
'index'])->name('mahasiswa.data');

Route::get('/mahasiswa-data', [MahasiswaWebController::class, 'index'])
    ->name('mahasiswa.data');

Route::get('/mahasiswa/{id}', [MahasiswaWebController::class, 'show'])
    ->name('mahasiswa.detail');

Route::get('/mahasiswa-top-ipk', [MahasiswaWebController::class, 'topIpk'])
    ->name('mahasiswa.top-ipk');

Route::post('/auth/login', [AuthController::class,
'login'])->middleware('throttle:5,1');