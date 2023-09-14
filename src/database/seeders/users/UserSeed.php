<?php

namespace Database\Seeders\Users;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class UserSeed extends Seeder
{
    #Elegir entre entorno de desarrollo o producción
    public function run()
    {
        $this->runDataDefault();
        if (env('APP_ENV') === 'local') {
            $this->runDataFake();
        }
    }

    public function runDataDefault()
    {
    }

    public function runDataFake()
    {
        $data = [
            [
                'id'                    => Str::uuid(),
                'dni'                   => "71530135",
                'email'                 => "kentolortigue@gmail.com",
                'password'              => bcrypt('demo'),
                'encrypted_password'    => Crypt::encryptString('demo'),
                'idtype_user'           => 1,
                'email_confirmation'    => 1
            ],
        ];

        User::insert($data);
    }
}
