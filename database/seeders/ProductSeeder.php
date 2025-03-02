<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Definir los productos por categoría
        $productsCategory = [
            'Frutas' => [
                ['name' => 'Manzana', 'description' => 'Fruta roja y jugosa, rica en vitamina C'],
                ['name' => 'Banana', 'description' => 'Fruta amarilla, rica en potasio'],
                ['name' => 'Naranja', 'description' => 'Fruta cítrica rica en vitamina C'],
            ],
            'Verduras' => [
                ['name' => 'Lechuga', 'description' => 'Hojas verdes para ensaladas'],
                ['name' => 'Zanahoria', 'description' => 'Raíz naranja, rica en vitamina A'],
                ['name' => 'Tomate', 'description' => 'Fruta roja utilizada en ensaladas y salsas'],
            ],
            'Carnes' => [
                ['name' => 'Pollo', 'description' => 'Carne blanca de ave, rica en proteínas'],
                ['name' => 'Carne de Res', 'description' => 'Carne roja, rica en hierro'],
                ['name' => 'Cerdo', 'description' => 'Carne de cerdo, utilizada en diversos platos'],
            ],
            'Lácteos' => [
                ['name' => 'Leche', 'description' => 'Bebida láctea rica en calcio'],
                ['name' => 'Yogur', 'description' => 'Producto lácteo fermentado, ideal para digestión'],
                ['name' => 'Queso', 'description' => 'Producto lácteo sólido, excelente para sándwiches'],
            ],
            'Cereales' => [
                ['name' => 'Avena', 'description' => 'Cereal integral ideal para desayuno'],
                ['name' => 'Cornflakes', 'description' => 'Cereal de maíz para desayuno'],
                ['name' => 'Muesli', 'description' => 'Mezcla de cereales y frutos secos'],
            ],
            'Panes y Bollos' => [
                ['name' => 'Pan de Trigo', 'description' => 'Pan hecho con harina de trigo'],
                ['name' => 'Bollos de Manteca', 'description' => 'Bollos suaves y esponjosos con manteca'],
                ['name' => 'Pan Integral', 'description' => 'Pan hecho con harina integral, más saludable'],
            ],
            'Bebidas' => [
                ['name' => 'Jugo de Naranja', 'description' => 'Bebida refrescante hecha con naranjas frescas'],
                ['name' => 'Agua Mineral', 'description' => 'Agua purificada con minerales'],
                ['name' => 'Cerveza', 'description' => 'Bebida alcohólica elaborada a base de cebada'],
            ],
            'Snacks' => [
                ['name' => 'Papitas Fritas', 'description' => 'Aperitivo crujiente y salado'],
                ['name' => 'Galletas', 'description' => 'Dulces horneados, ideales para merendar'],
                ['name' => 'Frutos Secos', 'description' => 'Nueces, almendras y otros frutos secos'],
            ],
            'Pastas' => [
                ['name' => 'Espaguetis', 'description' => 'Pasta larga y delgada, ideal para salsas'],
                ['name' => 'Fideos', 'description' => 'Pasta corta que se usa en sopas o platos principales'],
                ['name' => 'Ravioles', 'description' => 'Pasta rellena con carne o vegetales'],
            ],
            'Condimentos' => [
                ['name' => 'Sal', 'description' => 'Condimento básico para dar sabor a los alimentos'],
                ['name' => 'Pimienta', 'description' => 'Condimento picante para sazonar'],
                ['name' => 'Aceite de Oliva', 'description' => 'Aceite saludable, ideal para aderezos y cocinar'],
            ],

        ];

        // Insertar los productos en la base de datos
        foreach ($productsCategory as $categoryname => $products) {
            $category = Category::where('name', $categoryname)->first(); // Buscar la categoría por name

            foreach ($products as $product) {
                // Insertar producto relacionado con la categoría
                Product::create([
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'category_id' => $category->id, // Asociar con la categoría
                    'quantity' => rand(3, 15), // Cantidad aleatoria entre 3 y 5
                ]);
            }
        }
    }
}
