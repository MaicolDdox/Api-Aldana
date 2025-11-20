<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * El modelo asociado al factory.
     *
     * @var class-string<\App\Models\Book>
     */
    protected $model = Book::class;

    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Obtenemos una categoría existente al azar.
        // Es importante que primero se hayan ejecutado los seeders de tipos y categorías.
        $categoriaId = Category::inRandomOrder()->value('id');

        // Si por alguna razón no hay categorías, dejamos null (o podrías lanzar una excepción)
        return [
            'category_id'        => $categoriaId,
            'titulo'             => $this->faker->sentence(3),
            'foto'               => null,
            'descripccion_larga' => $this->faker->paragraph(4),
            'autor'              => $this->faker->name(),
            'editorial'          => $this->faker->company(),
            'year'               => (string) $this->faker->numberBetween(1950, 2024),
            'numero_paginas'     => (string) $this->faker->numberBetween(80, 800),
            'stock'              => $this->faker->numberBetween(0, 100),
            'precio'             => $this->faker->numberBetween(20000, 150000),
            'estado'             => 'disponible',
        ];
    }

    /**
     * Ajustamos el estado según el stock.
     */
    public function configure()
    {
        return $this->afterMaking(function (Book $libro) {
            
        })->afterCreating(function (Book $libro) {
            // Si el stock es 0, el libro está agotado
            if ($libro->stock <= 0) {
                $libro->estado = 'agotado';
                $libro->save();
            }
        });
    }
}
