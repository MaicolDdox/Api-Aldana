<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Ejecuta la siembra de la tabla types.
     */
    public function run(): void
    {

        // Arreglo de tipos de libros
        $tiposDeLibros = [
            [
                'name' => 'ficcion',
                'descripccion' => 'Libros que narran historias imaginarias o inventadas.',
            ],
            [
                'name' => 'no ficcion',
                'descripccion' => 'Libros basados en hechos reales, conocimientos o experiencias.',
            ],
        ];

        // Creamos cada tipo en la base de datos
        foreach ($tiposDeLibros as $tipo) {
            Type::create($tipo);
        }
    }
}
