<?php

namespace Database\Seeders\Food;

use App\Models\Food\Food;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FoodSeed extends Seeder
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
            [
                'id'                    => Str::uuid(),
                'name'                  => 'Arroz blanco cocido',
                'idtype_food'           => 2,
                'amount'                => '100',
                'kcal'                  => '129',
                'protein'               => '2.5',
                'fat'                   => '0.23',
                'hydrates'              => '29.23',
                'iduser_added'          => 1,
                'iduser_accepts'        => 1,
            ],
        ];

        Food::insert($data);
    }

    public function runDataFake()
    {
    }
}
