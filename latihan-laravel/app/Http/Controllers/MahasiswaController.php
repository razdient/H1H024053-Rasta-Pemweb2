<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
class MahasiswaController extends Controller
{
public function index()
{
$daftarMahasiswa = [
['nim' => 'H1A123001', 'nama' => 'Andi Prasetyo', 'angkatan' =>
2023],
['nim' => 'H1A123002', 'nama' => 'Bunga Lestari', 'angkatan' =>
2023],
['nim' => 'H1A123003', 'nama' => 'Citra Ramadhani', 'angkatan' =>
2024],
];
return view('mahasiswa.index', ['daftarMahasiswa' =>
$daftarMahasiswa]);
}

public function show($id)
{
    $mahasiswa = Mahasiswa::with([
        'programStudi',
        'matakuliah'
    ])->findOrFail($id);

    return view('mahasiswa.detail', [
        'mahasiswa' => $mahasiswa
    ]);
}

public function cari(Request $request)
{
$kataKunci = $request->query('q', '');
return response()->json([
'kata_kunci' => $kataKunci,
'metode' => $request->method(),
'path' => $request->path(),
]);
}
public function topIpk()
{
    $mahasiswa = Mahasiswa::with('programStudi')
        ->whereHas('programStudi', function ($query) {
            $query->where('nama', 'Teknik Komputer');
        })
        ->orderByDesc('ipk')
        ->take(10)
        ->get();

    return view('mahasiswa.top-ipk', [
        'mahasiswa' => $mahasiswa
    ]);
}
}
