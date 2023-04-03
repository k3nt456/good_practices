<?php

namespace App\Services\Users;

use App\Models\User\User;
use App\Traits\HasResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class UserClientService
{
    use HasResponse;
    public function getInfoAuth()
    {
        try {

            $user = User::find(Auth::user());
            return $this->successResponse('Lectura exitosa', $user);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function create($params)
    {
        try {
            DB::beginTransaction();

            #Validaciones
            $validate = $this->verifyDNIExists($params);
            if ($validate->original['code'] != 200) {
                return $validate;
            }

            $client = User::create([
                'dni'               =>  $params['dni'],
                'email'             =>  $params['email'],
                'password'          =>  bcrypt($params['password']),
                'encrypted_password' =>  Crypt::encryptString($params['password']),
                'idtype_user'       =>  3,
            ]);
            $client->fresh();
            DB::commit();
            return $this->successResponse('Cliente creado con éxito', $client);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    private function verifyDNIExists($params)
    {
        try {
            $users = User::where('dni', $params['dni'])
                ->active();

            #Verificación en caso se use la verificación en una persona logeada
            if (isset(Auth::user()->id)) {
                $users = $users->where('id', Auth::user()->id);
            }

            $users = $users->first();

            if (isset($users->id)) {
                return $this->errorResponse('El DNI ingresado ya esta registrado', 400);
            }
            return $this->successResponse('OK');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
