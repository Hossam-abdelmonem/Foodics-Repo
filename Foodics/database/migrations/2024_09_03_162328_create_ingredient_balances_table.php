<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredient_balances', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('ingredient_id')->constrained('ingredients'); // Foreign key to ingredients table
            $table->integer('amount'); // Amount column
            $table->foreignId('unit_id')->constrained('units'); // Foreign key to units table
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredient_balances');
    }
};
