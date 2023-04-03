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
        $this->call([
            \Database\Seeders\users\TypeUserSeed::class,
            // UserSeed::class,
        ]);
    }
}
