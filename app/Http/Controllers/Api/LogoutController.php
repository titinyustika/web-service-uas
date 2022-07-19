<?php

namespace App\Http\Controllers\Api;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
                //hapus token
                $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

                if($removeToken) {
                    //return response JSON
                    return response()->json([
                        'success' => true,
                        'message' => 'Logout Berhasil!',
                    ]);
                }

    }
}
