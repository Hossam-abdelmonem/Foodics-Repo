<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class IngredientBalance extends Model
{
    // Set the table name if necessary
    protected $table = 'ingredient_balances'; // Adjust if your table name differs

    // Set the primary key column name
    protected $primaryKey = 'id'; // Use 'id' if your column is named 'id'

    // Set whether the primary key is auto-incrementing
    public $incrementing = true; // Set to false if the primary key is not auto-incrementing

    // Set the data type of the primary key
    protected $keyType = 'int'; // Use 'string' if the primary key is a string

    // Define fillable attributes
    protected $fillable = [
        'ingredient_id',
        'amount',
        'initial_stock_balance',
        'unit_id',
    ];

    // Define relationships
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
}
