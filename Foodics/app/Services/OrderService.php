<?php

namespace App\Services;

use App\Services\Contracts\OrderServiceInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\LowStockAlert;
use Exception;

class OrderService implements OrderServiceInterface
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function placeOrder(array $orderData)
    {
        DB::beginTransaction();

        try {
            // Place the order using the repository
            $order = $this->orderRepository->createOrder($orderData);

            // Business logic for stock management and sending alerts
            $this->manageStockAndSendAlerts($order);

            DB::commit();

            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    protected function manageStockAndSendAlerts($order)
    {
        $ingredientsToUpdate = [];
        $emailsSent = [];

        // Process each order line and update stock
        foreach ($order->orderLines as $orderLine) {
            foreach ($orderLine->product->ingredients as $ingredient) {
                $requiredQuantity = $ingredient->pivot->quantity * $orderLine->quantity;

                if (!isset($ingredientsToUpdate[$ingredient->id])) {
                    $ingredientsToUpdate[$ingredient->id] = 0;
                }

                $ingredientsToUpdate[$ingredient->id] += $requiredQuantity;
            }
        }

        foreach ($ingredientsToUpdate as $ingredientId => $usedQuantity) {
            $ingredient = $this->orderRepository->updateIngredientStock($ingredientId, $usedQuantity);

        }
    }
}
