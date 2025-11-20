<?php

namespace Database\Seeders;

use App\Models\Type;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Ejecuta la siembra de la tabla categories.
     */
    public function run(): void
    {

        // Obtenemos los tipos desde la base de datos
        $tipoFiccion = Type::where('name', 'ficcion')->first();
        $tipoNoFiccion = Type::where('name', 'no ficcion')->first();

        // Validación sencilla por si los tipos no existen
        if (!$tipoFiccion || !$tipoNoFiccion) {
            $this->command->error('Primero ejecuta el TypeSeeder antes de CategorySeeder.');
            return;
        }

        // Categorías de ficción
        $categoriasFiccion = [
            'Ciencia ficcion',
            'Fantasia',
            'Terror',
            'Romance',
            'Misterio y suspense',
            'Novela negra',
            'Thriller',
            'Distopia',
            'Western',
        ];

        // Categorías de no ficción
        $categoriasNoFiccion = [
            'Historia',
            'Divulgacion cientifica',
            'Autoayuda y superacion personal',
            'Politica',
            'Ciencias sociales',
            'Memorias',
            'Filosofia',
            'Religion',
        ];

        // Creamos las categorías de ficción
        foreach ($categoriasFiccion as $nombreCategoria) {
            Category::create([
                'type_id'       => $tipoFiccion->id,
                'name'          => $nombreCategoria,
                'descripccion'  => "Libros del género {$nombreCategoria}.",
            ]);
        }

        // Creamos las categorías de no ficción
        foreach ($categoriasNoFiccion as $nombreCategoria) {
            Category::create([
                'type_id'       => $tipoNoFiccion->id,
                'name'          => $nombreCategoria,
                'descripccion'  => "Libros del género {$nombreCategoria}.",
            ]);
        }
    }
}
