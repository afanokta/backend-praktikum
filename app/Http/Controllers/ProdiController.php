<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;

class ProdiController extends Controller
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

    public function getAllProdi(Request $request)
    {
        $prodi = Prodi::all();
        return response()->json([
            'prodi' => $prodi
        ], 200);
    }
    //
}
