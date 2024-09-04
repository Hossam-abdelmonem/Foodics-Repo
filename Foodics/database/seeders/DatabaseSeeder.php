<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;
use App\Models\Ingredient;
use App\Models\IngredientBalance;
use App\Models\Product;
use App\Models\IngredientProduct;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create a unit for measurement
        $unit = Unit::create([
            'name' => 'grams',
            'converting_factor' => 1,
            'is_main_unit' => 1,
            'cost_price' => 4,
            'sale_price' => 5,
        ]);
        // Create a product
        $product = Product::create(['name' => 'burger']);

        // Create an ingredient
        $ingredient = Ingredient::create([
            'Name' => 'beef',
        ]);

        // Create ingredient balance with initial stock
        IngredientBalance::create([
            'ingredient_id' => $ingredient->id,
            'amount' => 20000,
            'initial_stock_balance' => 20000,
            'unit_id' => $unit->id,
        ]);


        // Link product to ingredient
        IngredientProduct::create([
            'product_id' => $product->id,
            'ingredient_id' => $ingredient->id,
            'quantity' => 150,
            'unit_id' => $unit->id,
        ]);
//-----------------------------------------------------------------------
        $ingredient = Ingredient::create([
            'Name' => 'cheese',
        ]);

        // Create ingredient balance with initial stock
        IngredientBalance::create([
            'ingredient_id' => $ingredient->id,
            'amount' => 5000,
            'initial_stock_balance' => 5000,
            'unit_id' => $unit->id,
        ]);


        // Link product to ingredient
        IngredientProduct::create([
            'product_id' => $product->id,
            'ingredient_id' => $ingredient->id,
            'quantity' => 30,
            'unit_id' => $unit->id,
        ]);
        //-----------------------------------------------------------
        //-----------------------------------------------------------------------
        $ingredient = Ingredient::create([
            'Name' => 'onion',
        ]);

        // Create ingredient balance with initial stock
        IngredientBalance::create([
            'ingredient_id' => $ingredient->id,
            'amount' => 1000,
            'initial_stock_balance' => 1000,
            'unit_id' => $unit->id,
        ]);


        // Link product to ingredient
        IngredientProduct::create([
            'product_id' => $product->id,
            'ingredient_id' => $ingredient->id,
            'quantity' => 20,
            'unit_id' => $unit->id,
        ]);
    }
}
