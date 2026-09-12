<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    private $matakuliah = [
        [
            'kode' => 'TI101',
            'nama' => 'Pemrograman Dasar',
            'SKS' => 3
        ],
        [
            'kode' => 'TI102',
            'nama' => 'Basis Data',
            'SKS' => 3
        ],
        [
            'kode' => 'TI103',
            'nama' => 'Jaringan Komputer',
            'SKS' => 3
        ],
        [
            'kode' => 'TI104',
            'nama' => 'Pemrograman Web',
            'SKS' => 3
        ],
        [
            'kode' => 'TI105',
            'nama' => 'Sistem Operasi',
            'SKS' => 2
        ]
    ];

    public function index(Request $request)
    {
        $keyword = $request->query('search');

        $matakuliah = $this->matakuliah;

        if ($keyword) {
            $matakuliah = array_filter($matakuliah, function ($matkul) use ($keyword) {
                return stripos($matkul['kode'], $keyword) !== false
                    || stripos($matkul['nama'], $keyword) !== false;
            });
        }

        return view('matakuliah.index', compact('matakuliah', 'keyword'));
    }

    public function show($kode)
    {
        foreach ($this->matakuliah as $matkul) {
            if ($matkul['kode'] === $kode) {
                return view('matakuliah.show', compact('matkul'));
            }
        }

        abort(404);
    }
}