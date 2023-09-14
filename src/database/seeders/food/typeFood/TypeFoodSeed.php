<?php

namespace Database\Seeders\Food\TypeFood;

use App\Models\Food\TypeFood\TypeFood;
use Illuminate\Database\Seeder;

class TypeFoodSeed extends Seeder
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
            ['name' => 'Origen animal'],
            ['name' => 'Origen vegetal']
        ];

        TypeFood::insert($data);
    }

    public function runDataFake()
    {
    }
}
