<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    // Specify the table name if different from the default 'ingredients'
    // Set the table name if necessary
    protected $table = 'ingredients';

    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'id'; // Ensure this matches your database schema

    // Define mass-assignable attributes
    protected $fillable = [
        'Name', // Ensure this matches your database schema
    ];

    // Define the many-to-many relationship with Product
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->using(IngredientProduct::class)->withPivot('quantity','unit_id');

    }

}
