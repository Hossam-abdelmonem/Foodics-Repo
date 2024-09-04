<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model

{

    protected $primaryKey = 'id';  // Using lowercase 'id' to follow Laravel conventions

    // Specify the table name
    protected $table = 'products';

    // Allow mass assignment for the listed attributes
    protected $fillable = [
        'name',
    ];

    // Define the many-to-many relationship with Ingredient
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_product', 'product_id', 'ingredient_id')
            ->using(IngredientProduct::class) ->withPivot('quantity','unit_id');

    }
}
