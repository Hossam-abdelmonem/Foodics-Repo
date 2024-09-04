<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    // Specify the primary key if it does not follow Laravel's default 'id'
    protected $primaryKey = 'id';  // Using lowercase 'id' to follow Laravel conventions

    // Specify the table name if it does not follow Laravel's naming conventions
    protected $table = 'units';  // Table name should be plural and lowercase

    // Allow mass assignment for the listed attributes
    protected $fillable = [
        'name',
        'converting_factor',
        'is_main_unit',
        'cost_price',
        'sale_price',
    ];

    // Disable auto-incrementing if the primary key is not auto-incrementing
    public $incrementing = true;

    // Set the primary key type if different from 'int'
    protected $keyType = 'int';

}
