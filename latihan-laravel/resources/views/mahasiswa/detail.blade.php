@extends('layouts.app')

@section('judul', 'Detail Mahasiswa')

@section('konten')

<h1 class="h3 mb-4">Detail Mahasiswa</h1>

<div class="card mb-4">
    <div class="card-body">

        <table class="table table-borderless mb-0">
            <tr>
                <th width="150">NIM</th>
                <td>{{ $mahasiswa->nim }}</td>
            </tr>

            <tr>
                <th>Nama</th>
                <td>{{ $mahasiswa->nama }}</td>
            </tr>

            <tr>
                <th>Email</th>
                <td>{{ $mahasiswa->email }}</td>
            </tr>

            <tr>
                <th>Program Studi</th>
                <td>{{ $mahasiswa->programStudi->nama }}</td>
            </tr>

            <tr>
                <th>Angkatan</th>
                <td>{{ $mahasiswa->angkatan }}</td>
            </tr>

            <tr>
                <th>IPK</th>
                <td>{{ $mahasiswa->ipk }}</td>
            </tr>
        </table>

    </div>
</div>

<h2 class="h5 mb-3">Daftar Matakuliah</h2>

<table class="table table-striped">

    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Matakuliah</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>Nilai</th>
        </tr>
    </thead>

    <tbody>

        @forelse ($mahasiswa->matakuliah as $index => $matakuliah)

            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $matakuliah->kode }}</td>
                <td>{{ $matakuliah->nama }}</td>
                <td>{{ $matakuliah->sks }}</td>
                <td>{{ $matakuliah->semester }}</td>
                <td>{{ $matakuliah->pivot->nilai }}</td>
            </tr>

        @empty

            <tr>
                <td colspan="6" class="text-center">
                    Belum mengambil matakuliah.
                </td>
            </tr>

        @endforelse

    </tbody>

</table>

<a href="{{ route('mahasiswa.data') }}" class="btn btn-secondary">
    Kembali
</a>

@endsection