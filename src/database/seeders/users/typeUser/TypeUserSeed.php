<?php

namespace Database\Seeders\Users\TypeUser;

use App\Models\User\TypeUser;
use Illuminate\Database\Seeder;

class TypeUserSeed extends Seeder
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

        $data = [
            ['name' => 'Superadmin'],
            ['name' => 'Administrador'],
            ['name' => 'Jefe de área'],
            ['name' => 'Usuario básico'],
        ];

        TypeUser::insert($data);
    }

    public function runDataFake()
    {
    }
}
