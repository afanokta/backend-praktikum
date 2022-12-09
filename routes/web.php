<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/key', function () use ($router) {
    return Str::random(32);
});

// ===================== AUTH ROUTE ====================
$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('login', ['uses' => 'AuthController@login']); // [POST] auth/login --> menjalankan fungsi login di authController
    $router->post('register', ['uses' => 'AuthController@register']); // [POST] auth/register --> menjalankan fungsi register di authcontroller
});
// ===================== AUTH ROUTE ====================

// ===================== MAHASISWA ROUTE ====================
$router->group(['prefix' => 'mahasiswa'], function () use ($router) {
    $router->get('/', ['uses' => 'MahasiswaController@getAllMahasiswa']);
    $router->group(
        ['middleware' => 'jwt'],
        function () use ($router) {
            $router->get('/profile', ['uses' => 'MahasiswaController@profile']); // [GET] /mahasiswa/profile
            $router->get('/{nim}', ['uses' => 'MahasiswaController@getMahasiswaByNim']);
            $router->post('/{nim}/matakuliah/{mkId}', ['uses' => 'MahasiswaController@addMK']);
            $router->put('/{nim}/matakuliah/{mkId}', ['uses' => 'MahasiswaController@deleteMK']);
        }
    );
});
// ===================== MAHASISWA ROUTE ====================


// ===================== PRODI ROUTE ====================
$router->get('/prodi', ['uses' => 'ProdiController@getAllProdi']);
// ===================== PRODI ROUTE ====================


// ===================== MATAKULIAH ROUTE ====================
$router->get('/matakuliah', ['uses' => 'MatakuliahController@getAllMatakuliah']);
// ===================== MATAKULIAH ROUTE ====================
