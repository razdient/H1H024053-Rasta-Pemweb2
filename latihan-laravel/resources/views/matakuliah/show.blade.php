@extends('layouts.app')

@section('judul', 'Detail Mata Kuliah')

@section('konten')

<div class="mb-4">
    <h1 class="h3">Detail Mata Kuliah</h1>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        <div class="mb-3">
            <label class="fw-bold">Kode</label>
            <p class="mb-0">{{ $matkul['kode'] }}</p>
        </div>

        <div class="mb-3">
            <label class="fw-bold">Nama Mata Kuliah</label>
            <p class="mb-0">{{ $matkul['nama'] }}</p>
        </div>

        <div class="mb-3">
            <label class="fw-bold">SKS</label>
            <p class="mb-0">
                <x-badge-sks :sks="$matkul['SKS']" />
            </p>
        </div>

        <a href="{{ url('/matakuliah') }}" class="btn btn-secondary">
            ← Kembali
        </a>

    </div>
</div>

@endsection