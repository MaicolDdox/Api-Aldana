<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Ejecuta la siembra de la tabla books.
     */
    public function run(): void
    {

        // Creamos 50 libros de ejemplo usando el factory
        Book::factory(50)->create();
    }
}
