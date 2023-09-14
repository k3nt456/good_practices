<?php

namespace Database\Seeders\Excercises;

use App\Models\Excercises\Excercises;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ExcercisesSeed extends Seeder
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
                'name'                  => "Press plano en banca",
                'idmuscles_exercise'    => 3,
                'iddivision_execution'  => 1,
                'idspecificity'         => 4,
                'img_excercise'         => 'https://i.blogs.es/85d668/bench-press-1/1366_2000.webp',
                'vid_excercise'         => 'https://www.youtube.com/shorts/2kQXNz2C9xY',
                'iduser_added'          => 1,
                'iduser_accepts'        => 1
            ],
        ];

        Excercises::insert($data);
    }

    public function runDataFake()
    {
    }
}
