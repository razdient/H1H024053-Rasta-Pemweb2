@extends('layouts.app')

@section('judul', 'Daftar Mata Kuliah')

@section('konten')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Daftar Mata Kuliah</h1>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        <form method="GET" action="{{ url('/matakuliah') }}" class="mb-4">
            <div class="input-group">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari kode atau nama mata kuliah..."
                    value="{{ $keyword }}"
                >
                <button type="submit" class="btn btn-primary">
                    Cari    
                </button>   
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($matakuliah as $matkul)
                        <tr>
                            <td>{{ $matkul['kode'] }}</td>

                            <td>{{ $matkul['nama'] }}</td>

                            <td>
                                <x-badge-sks :sks="$matkul['SKS']" />
                            </td>

                            <td>
                                <a
                                    href="{{ url('/matakuliah/' . $matkul['kode']) }}"
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Mata kuliah tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection