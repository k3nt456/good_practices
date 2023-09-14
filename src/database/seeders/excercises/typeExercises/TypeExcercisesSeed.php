<?php

namespace Database\Seeders\Excercises\TypeExercises;

use App\Models\Excercises\TypeExcercises\DivisionExecutionMuscle;
use App\Models\Excercises\TypeExcercises\Muscles;
use Illuminate\Database\Seeder;

class TypeExcercisesSeed extends Seeder
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

        $dataMuscles = [
            ['name' => 'Espalda'],
            ['name' => 'Piernas'],
            ['name' => 'Pecho'],
            ['name' => 'Hombros'],
            ['name' => 'Brazos']
        ];

        $dataDEM = [
            ['name' => 'Push'],
            ['name' => 'Pull'],
            ['name' => 'Enfoque específico'],
            ['name' => 'Enfoque general'],
        ];

        Muscles::insert($dataMuscles);
        DivisionExecutionMuscle::insert($dataDEM);
    }

    public function runDataFake()
    {
    }
}
