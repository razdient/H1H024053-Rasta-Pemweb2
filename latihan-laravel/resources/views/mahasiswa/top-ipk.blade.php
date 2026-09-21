@extends('layouts.app')

@section('judul', '10 Mahasiswa IPK Tertinggi')

@section('konten')

<h1 class="h3 mb-4">
    10 Mahasiswa dengan IPK Tertinggi
</h1>

<div class="card">
    <div class="card-body">

        <p>
            Program Studi: <strong>Teknik Komputer</strong>
        </p>

        <table class="table table-striped">

            <thead>
                <tr>
                    <th>Peringkat</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Angkatan</th>
                    <th>IPK</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($mahasiswa as $index => $mhs)

                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $mhs->nim }}</td>
                        <td>{{ $mhs->nama }}</td>
                        <td>{{ $mhs->angkatan }}</td>
                        <td>{{ $mhs->ipk }}</td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center">
                            Data mahasiswa tidak ditemukan.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>
</div>

@endsection