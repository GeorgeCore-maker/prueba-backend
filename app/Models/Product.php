<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    protected $fillable =  [ 'name', 'description', 'quantity', 'category_id' ];

    public $timestamps = false;

    // Relación inversa con categorías
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
