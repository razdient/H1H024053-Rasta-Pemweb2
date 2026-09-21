<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Database\Seeder;

class MahasiswaMatakuliahSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswa = Mahasiswa::all();
        $matakuliah = Matakuliah::all();

        foreach ($mahasiswa as $mhs) {
            $jumlah = rand(3, 5);

            $pilihan = $matakuliah
                ->random($jumlah)
                ->pluck('id');

            foreach ($pilihan as $matakuliahId) {
                $mhs->matakuliah()->attach($matakuliahId, [
                    'nilai' => fake()->randomElement([
                        'A',
                        'AB',
                        'B',
                        'BC',
                        'C',
                    ]),
                ]);
            }
        }
    }
}