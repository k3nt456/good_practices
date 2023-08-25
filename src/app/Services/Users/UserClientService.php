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
            return $this->successResponse('Lectura exitosa.', $user);
        } catch (\Throwable $th) {
            return $this->externalError('durante la lectura de información del logueado.', $th->getMessage());
        }
    }
    public function create($params)
    {
        try {
            DB::beginTransaction();

            # Validaciones
            $validate = $this->verifyDNIandEmailExists($params);
            if ($validate->original['code'] != 200) return $validate;

            $client = User::create([
                'dni'               =>  $params['dni'],
                'email'             =>  $params['email'],
                'password'          =>  bcrypt($params['password']),
                'encrypted_password' =>  Crypt::encryptString($params['password']),
                'idtype_user'       =>  3,
            ]);
            $client->fresh();
            DB::commit();
            return $this->successResponse('Cliente creado con éxito.', $client);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->externalError('durante la creación de un cliente.', $th->getMessage());
        }
    }

    private function verifyDNIandEmailExists($params)
    {
        try {
            $users = User::where('dni', $params['dni'])
                ->orWhere('email', $params['email'])
                ->active()->first();

            if (isset($users->id)) {
                if ($users->dni == $params['dni']) {
                    return $this->errorResponse('El DNI ingresado ya esta registrado', 400);
                } elseif ($users->email == $params['email']) {
                    return $this->errorResponse('El correo ingresado ya esta registrado', 400);
                }
            }
            return $this->successResponse('OK');
        } catch (\Throwable $th) {
            return $this->externalError('durante verificación de información.', $th->getMessage());
        }
    }
}
