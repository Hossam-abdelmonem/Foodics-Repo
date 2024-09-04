<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class IngredientProduct extends Pivot
{
    // Specify the table name
    protected $table = 'ingredient_product';

    // Define mass-assignable attributes
    protected $fillable = [
        'ingredient_id',  // Use snake_case for consistency with column names
        'product_id',
        'quantity',
        'unit_id',
    ];

    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'id'; // Ensure this matches your database schema

    // Set this to false if the primary key is not auto-incrementing
    public $incrementing = true;

    // Define the data type of the primary key
    protected $keyType = 'int'; // Use 'string' if the primary key is a string

    // Define relationships
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id'); // Ensure column names are correct
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id', 'id'); // Ensure column names are correct
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id'); // Ensure column names are correct
    }
}
