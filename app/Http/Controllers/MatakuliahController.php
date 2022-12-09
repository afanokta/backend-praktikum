<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matakuliah;

class MatakuliahController extends Controller
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

    public function getAllMatakuliah(Request $request)
    {
        try {
            $matakuliah = Matakuliah::all();
            return response()->json([
                'matakuliah' => $matakuliah
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'error' => true,
                'message' => 'kesalahan server',
            ], 500);
        }
    }
    //
}
