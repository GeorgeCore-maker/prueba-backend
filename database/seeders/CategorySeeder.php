<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;  // Asegúrate de tener la importación correcta de Category

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::insert([
            [
                'name' => 'Frutas',
                'description' => 'Categoría que incluye frutas frescas y saludables.',
            ],
            [
                'name' => 'Verduras',
                'description' => 'Incluye todo tipo de verduras frescas y orgánicas.',
            ],
            [
                'name' => 'Carnes',
                'description' => 'Categoría con diferentes tipos de carnes, como pollo, res y cerdo.',
            ],
            [
                'name' => 'Lácteos',
                'description' => 'Incluye productos como leche, queso, yogur y otros derivados lácteos.',
            ],
            [
                'name' => 'Cereales',
                'description' => 'Categoría que contiene diferentes tipos de cereales para desayuno.',
            ],
            [
                'name' => 'Panes y Bollos',
                'description' => 'Categoría con todo tipo de panes, bollos y pasteles frescos.',
            ],
            [
                'name' => 'Bebidas',
                'description' => 'Incluye bebidas refrescantes, jugos, sodas y agua.',
            ],
            [
                'name' => 'Snacks',
                'description' => 'Incluye aperitivos y snacks como papas fritas, galletas y frutos secos.',
            ],
            [
                'name' => 'Pastas',
                'description' => 'Categoría con diferentes tipos de pastas como espaguetis, fideos y ravioles.',
            ],
            [
                'name' => 'Condimentos',
                'description' => 'Incluye especias, salsas, aceites y otros condimentos para mejorar los sabores.',
            ],
        ]);
    }
}

