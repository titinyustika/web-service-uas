<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
                //set validasi
                $validator = Validator::make($request->all(), [
                    'email'     => 'required',
                    'password'  => 'required'
                ]);

                //jika validasi fails
                if ($validator->fails()) {
                    return response()->json($validator->errors(), 422);
                }

                //ambil credentials dari request
                $credentials = $request->only('email', 'password');

                //jika gagal
                if(!$token = auth()->guard('api')->attempt($credentials)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Email atau Password Anda salah'
                    ], 401);
                }

                //jika success
                return response()->json([
                    'success' => true,
                    'user'    => auth()->guard('api')->user(),
                    'token'   => $token
                ], 200);
            }

    }
