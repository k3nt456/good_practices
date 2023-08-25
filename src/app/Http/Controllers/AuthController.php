<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Traits\HasResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use HasResponse;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'resendCredentials', 'validateToken']]);
    }

    public function login(LoginRequest $params)
    {
        try {
            #Mandar credenciales
            $credentials  = ['email' => $params['email'], 'password' => $params['password']];

            if (!Auth::attempt($credentials)) {

                return $this->errorResponse('DNI o contraseña incorrecta, por favor verifique sus datos.', 401);
            }

            $user = $params->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;

            $token->save();

            return $this->successResponse('Sesión iniciada con éxito.', $this->respondWithToken($tokenResult));
        } catch (\Throwable $th) {
            return $this->externalError('durante el inicio de sesión.', $th->getMessage());
        }
    }

    protected function respondWithToken($tokenResult)
    {
        try {
            return [
                'token_type'        => 'bearer',
                'access_token'      => $tokenResult->accessToken,
                'information_oauth_access_tokens' => $tokenResult->token,
                'expires_in'        => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
            ];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function logout()
    {
        try {
            Auth::logout();
            return $this->successResponse('Sesión terminada.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function refresh()
    {
        try {
            return response()->json([
                'status' => true,
                'user' => Auth::user(),
                'authorisation' => [
                    'token' => Auth::refresh(),
                    'type' => 'bearer',
                ]
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /* public function validateToken()
    {
        try {
            try {
                $user = JWTAuth::parseToken()->authenticate();
                if ($user) {
                    return 'true';
                }
                return 'false';
            } catch (JWTException $e) {
                return 'false';
            }
        } catch (\Throwable $th) {
        }
    } */
}
