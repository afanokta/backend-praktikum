<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Prodi;
use App\Models\Mahasiswa_matakuliah;


class MahasiswaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getAllMahasiswa(Request $request)
    {
        $mahasiswa = Mahasiswa::with('prodi', 'mahasiswa_matakuliah')->get();
        return response()->json([
            'mahasiswa' => $mahasiswa
        ], 200);
    }

    public function getMahasiswaByNim(Request $request, $nim)
    {
        // $mahasiswa = Mahasiswa::all();
        $mahasiswa = Mahasiswa::where('nim', $nim)->with('prodi', 'mahasiswa_matakuliah')->get()->first();
        if ($mahasiswa == null) {
            $mahasiswa = Mahasiswa::where('nim', $request->mhs->nim)->with('prodi')->get()->first();
        }
        return response()->json([
            'mahasiswa' => $mahasiswa,
        ], 200);
    }

    public function profile(Request $request)
    {
        try {
            $mahasiswa = Mahasiswa::where('nim', $request->mhs->nim)->with('prodi', 'mahasiswa_matakuliah')->get()->first();
            if($mahasiswa == null){
                $mahasiswa = Mahasiswa::where('nim', $request->mhs->nim)->with('prodi')->get()->first();
            }
            return response()->json([
                'mahasiswa' => $mahasiswa,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'kesalahan server',
            ], 500);
        }
    }

    public function addMK(Request $request, $nim, $mkId)
    {
        try {
            $mahasiswa = Mahasiswa_matakuliah::create([
                'mhsNim' => $nim,
                'mkId' => $mkId,
            ]);
            return response()->json([
                'mahasiswa' => $mahasiswa,
                'message' => "Matakuliah berhasil ditambahkan",
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'kesalahan server',
                'message' => 'Matakuliah Sudah Dipilih',
            ], 200);
        }
    }


    public function deleteMK(Request $request, $nim, $mkId)
    {
        try {
            Mahasiswa_matakuliah::where('mhsNim', $nim)
                ->where('mkId', $mkId)
                ->delete();
            return response()->json([
                // 'mahasiswa' => $mahasiswa,
                'status' => 'success',
                'message' => "Matakuliah berhasil dihapus",
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'kesalahan server',
            ], 500);
        }
    }
}
