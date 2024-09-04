<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    // Use 'id' as the primary key if your schema follows Laravel convention
    protected $primaryKey = 'id';

    // Set this to false if the primary key is not auto-incrementing
    public $incrementing = true;

    // Define the data type of the primary key
    protected $keyType = 'int'; // Change to 'string' if the primary key is non-numeric

    // Define the relationship with OrderLine
    public function orderLines()
    {
        return $this->hasMany(OrderLine::class, 'order_id', 'id'); // Match foreign key 'order_id' with 'id' in orders table
    }
}
