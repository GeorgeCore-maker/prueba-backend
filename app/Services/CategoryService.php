<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getAllCategories()
    {
        return Category::withCount('products as total_products')->get();
    }

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getCategoryById($id)
    {
        return $this->category->find($id);
    }

    public function getCategoryByName($name)
    {
        return Category::where('name', 'like', '%' . $name . '%')->withCount('products as total_products')->get();
    }
}
