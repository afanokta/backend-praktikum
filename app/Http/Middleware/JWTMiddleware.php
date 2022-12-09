<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\Mahasiswa;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

class JwtMiddleware
{
  function handle($request, Closure $next, $guard = null)
  {
    $token = $request->header('token') ?? $request->query('token');
    // $token = $request->get('token');
    if (!$token) {
      //Unauthorized response if token not there
      return response()->json([
        'error' => 'Token not provded.',
        'message'=> 'token tidak dapat ditemukan, login untuk melanjutkan'
      ], 401);
    }
    try {
      $credentials =
        JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
    } catch (ExpiredException $e) {
      return response()->json([
        'error' => 'Provided token is expired.',
        'message'=> 'token tidak berlaku, login untuk melanjutkan'
      ], 400);
    } catch (Exception $e) {
      return response()->json([
        'error' => 'An error while decoding token.',
        'message'=> 'error decoding token'
      ], 400);
    }
    $mhs = Mahasiswa::where('nim' ,$credentials->sub)->first();
    // dd($user);
    $request->mhs = $mhs;
    return $next($request);
  }
}
