<?php

namespace App\Repositories\Contracts;

interface OrderRepositoryInterface
{
    /**
     * Create a new order with order lines.
     *
     * @param array $orderData
     * @return mixed
     */
    public function createOrder(array $orderData);

    /**
     * Update ingredient stock.
     *
     * @param int $ingredientId
     * @param int $usedQuantity
     * @return mixed
     */
    public function updateIngredientStock(int $ingredientId, int $usedQuantity);
}
