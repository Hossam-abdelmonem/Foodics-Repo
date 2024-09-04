<?php

namespace App\Services\Contracts;

interface OrderServiceInterface
{
    /**
     * Place a new order.
     *
     * @param array $orderData
     * @return mixed
     */
    public function placeOrder(array $orderData);
}
