<?php

namespace Database\Seeders;

use App\Models\Matakuliah;
use Illuminate\Database\Seeder;

class MatakuliahSeeder extends Seeder
{
    public function run(): void
    {
        $daftar = [
            [
                'kode' => 'TK101',
                'nama' => 'Pemrograman Web II',
                'sks' => 3,
                'semester' => 3,
            ],
            [
                'kode' => 'TK102',
                'nama' => 'Internet of Things',
                'sks' => 3,
                'semester' => 3,
            ],
            [
                'kode' => 'TK103',
                'nama' => 'Basis Data',
                'sks' => 3,
                'semester' => 3,
            ],
            [
                'kode' => 'TK104',
                'nama' => 'Jaringan Komputer',
                'sks' => 3,
                'semester' => 4,
            ],
            [
                'kode' => 'TK105',
                'nama' => 'Sistem Operasi',
                'sks' => 3,
                'semester' => 4,
            ],
            [
                'kode' => 'TK106',
                'nama' => 'Keamanan Komputer',
                'sks' => 3,
                'semester' => 5,
            ],
            [
                'kode' => 'TK107',
                'nama' => 'Pemrograman Mobile',
                'sks' => 3,
                'semester' => 5,
            ],
            [
                'kode' => 'TK108',
                'nama' => 'Kecerdasan Buatan',
                'sks' => 3,
                'semester' => 5,
            ],
        ];

        foreach ($daftar as $item) {
            Matakuliah::create($item);
        }
    }
}