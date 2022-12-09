<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;

class AuthController extends Controller
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

    protected function jwt(Mahasiswa $mhs)
    {
        $payload = [
            'iss' => 'lumen-jwt', //issuer of the token
            'sub' => $mhs->nim, //subject of the token
            'iat' => time(), //time when JWT was issued.
            'exp' => time() + 600 //time when JWT will expire
        ];
        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    public function login(Request $request)
    {
        $nim = $request->nim;
        $password = $request->password;
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if (!$mahasiswa) {
            return response()->json([
                'status' => 'Error',
                'message' => 'mahasiswa not exist',
            ], 404);
        }
        if (!Hash::check($password, $mahasiswa->password)) {
            return response()->json([
                'status' => 'Error',
                'message' => 'wrong password',
                // 'mahasiswa' => $mahasiswa,
            ], 400);
        }

        // $mahasiswa->token = $this->jwt($mahasiswa); //
        // $mahasiswa->save();
        return response()->json(
            [
                'status' => 'Success',
                'message' => 'successfully login',
                'mahasiswa' => $mahasiswa,
                'token'=> $this->jwt($mahasiswa)
            ],
            200
        );
    }

    public function register(Request $request)
    {

        $nim = $request->nim;
        $nama = $request->nama;
        $angkatan = $request->angkatan;
        $prodi = $request->prodi;
        $password = Hash::make($request->password);

        $mhs = Mahasiswa::create([
            'nim' => $nim,
            'nama' => $nama,
            'angkatan' => $angkatan,
            'prodi' => $prodi,
            'password' => $password,
        ]);

        return response()->json([
            'message' => 'data mahasiswa berhasil ditambahkan',
            // 'message' => 'data mahasiswa berhasil ditambahkan',
        ], 200);
    }
}
