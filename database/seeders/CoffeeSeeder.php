<?php

namespace Database\Seeders;

use App\Models\Coffee;
use Illuminate\Database\Seeder;

class CoffeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coffees = [
            [
                'name' => 'Espresso Intenso',
                'brand' => 'Illy',
                'description' => 'Tueste oscuro con notas de cacao y avellana.',
                'price' => 8.50,
                'stock' => 120,
                'image_url' => 'https://example.com/images/espresso-intenso.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'House Blend',
                'brand' => 'Starbucks',
                'description' => 'Mezcla equilibrada de granos latinoamericanos.',
                'price' => 6.99,
                'stock' => 80,
                'image_url' => 'https://example.com/images/house-blend.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Colombia Supremo',
                'brand' => 'Juan Valdez',
                'description' => 'Café colombiano con acidez media y notas cítricas.',
                'price' => 7.25,
                'stock' => 100,
                'image_url' => 'https://example.com/images/colombia-supremo.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Ethiopia Yirgacheffe',
                'brand' => 'Blue Bottle',
                'description' => 'Notas florales y frutales con cuerpo ligero.',
                'price' => 11.90,
                'stock' => 60,
                'image_url' => 'https://example.com/images/ethiopia-yirgacheffe.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Brasil Santos',
                'brand' => 'Lavazza',
                'description' => 'Cuerpo medio, dulce y con notas de chocolate.',
                'price' => 5.99,
                'stock' => 150,
                'image_url' => 'https://example.com/images/brasil-santos.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Decaf Moka',
                'brand' => 'Illy',
                'description' => 'Descafeinado suave para preparar moka o espresso.',
                'price' => 6.50,
                'stock' => 70,
                'image_url' => 'https://example.com/images/decaf-moka.jpg',
                'is_active' => true,
            ],
        ];

        foreach ($coffees as $coffee) {
            Coffee::updateOrCreate(
                ['name' => $coffee['name'], 'brand' => $coffee['brand']],
                $coffee
            );
        }
    }
}
