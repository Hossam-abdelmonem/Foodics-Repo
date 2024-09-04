<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    protected $primaryKey = 'id';

    // Specify the table name
    protected $table = 'order_lines';

    // Allow mass assignment for the listed attributes
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
    ];

    // Relationship with Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }


}
