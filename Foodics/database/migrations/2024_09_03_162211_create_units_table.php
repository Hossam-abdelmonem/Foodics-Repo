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
        Schema::create('units', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Unit name
            $table->float('converting_factor'); // Converting factor column
            $table->boolean('is_main_unit'); // Is main unit column
            $table->decimal('cost_price', 8, 2); // Cost price column
            $table->decimal('sale_price', 8, 2); // Sale price column
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
        Schema::dropIfExists('units');
    }
};
