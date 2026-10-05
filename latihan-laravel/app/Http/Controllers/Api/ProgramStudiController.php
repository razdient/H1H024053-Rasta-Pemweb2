<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MahasiswaResource;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class ProgramStudiController extends Controller
{
    public function mahasiswa(Request $request, ProgramStudi $programStudi)
    {
        $mahasiswa = Mahasiswa::where('program_studi_id', $programStudi->id)
            ->paginate(10);

        return MahasiswaResource::collection($mahasiswa);
    }
}