<?php

namespace Database\Seeders;
#Importate adicionar el nombre de la carpeta que contiene a la clase en el namespace para que la clase pueda ser encontrada

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Llamado de clases para la data inicial o ficticia de la base de datos
     */
    public function run()
    {
        $this->seedUserRelatedData();
        $this->seedExerciseRelatedData();
        $this->seedFoodRelatedData();
    }

    # Usuarios
    private function seedUserRelatedData()
    {
        $this->call([
            \Database\Seeders\users\UserSeed::class,
            \Database\Seeders\users\typeUser\TypeUserSeed::class,
        ]);
    }

    # Ejercicios
    private function seedExerciseRelatedData()
    {
        $this->call([
            \Database\Seeders\excercises\typeExercises\TypeExcercisesSeed::class,
            \Database\Seeders\excercises\ExcercisesSeed::class,
        ]);
    }

    # Alimentos
    private function seedFoodRelatedData()
    {
        $this->call([
            \Database\Seeders\food\typeFood\TypeFoodSeed::class,
            \Database\Seeders\food\FoodSeed::class,
        ]);
    }

}
