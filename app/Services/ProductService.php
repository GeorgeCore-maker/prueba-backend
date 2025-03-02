<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAllProducts()
    {
        return Product::all();
    }

    public function getProductByName($name)
    {
        $consulta = Product::where('name', 'like', '%' . $name . '%')->get();

        return $consulta;

    }

    public function getProductQuantity($name)
    {
        $product = Product::where('name', 'like', '%' . $name . '%')->first();
        return $product ? $product->quantity : 0;
    }
}
