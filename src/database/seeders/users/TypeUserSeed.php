<?php

namespace Database\Seeders\Users;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

    public function runDataDefault(){
        DB::table('tbl_type_user')->insert([
            'name' => 'Superadmin',
        ]);
        DB::table('tbl_type_user')->insert([
            'name' => 'Comerciante',
        ]);
        DB::table('tbl_type_user')->insert([
            'name' => 'Cliente',
        ]);
    }

    public function runDataFake() {
    }
}
