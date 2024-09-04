<?php

namespace App\Repositories;

use App\Mail\LowStockAlert;
use App\Models\IngredientBalance;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Models\Order;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Mail;

class OrderRepository implements OrderRepositoryInterface
{
    public function createOrder(array $orderData)
    {
        $order = Order::create();

        // Loop through each product in the order data
        foreach ($orderData['products'] as $product) {
            // Create a new OrderLine associated with the Order
            $order->orderLines()->create([
                'order_id' => $order->Id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
            ]);
        }

        return $order;
    }

        public function updateIngredientStock(int $ingredientId, int $usedQuantity)
        {
            // Find the IngredientBalance record for the given ingredient
            $ingredientBalance = IngredientBalance::where('ingredient_id', $ingredientId)->first();

            // Check if the record exists
            if (!$ingredientBalance) {
                throw new \Exception('Ingredient balance not found for IngredientId: ' . $ingredientId);
            }

            // Log the current amount for debugging
            \Log::info('Current Amount: ' . $ingredientBalance->amount);

            // Ensure the used quantity is valid and does not exceed the current amount
            if ($usedQuantity <= 0) {
                throw new \Exception('Invalid quantity used.');
            }
            if ($ingredientBalance->amount < $usedQuantity) {
                throw new \Exception('Insufficient stock.');
            }

            // Update the stock amount
            $ingredientBalance->amount -= $usedQuantity;

            // Save the updated record
            $ingredientBalance->save();

            // Log the updated amount for debugging
            \Log::info('Updated Amount: ' . $ingredientBalance->Amount);

            static $emailsSent = [];

            // Send email if stock is low
            $initialStock = $ingredientBalance->initial_stock_balance;
            if ($ingredientBalance->amount < $initialStock * 0.5) {
                if (!in_array($ingredientId, $emailsSent)) {
                    Mail::to('hossam.abdelmonem007@gmail.com')->send(new LowStockAlert($ingredientBalance));
                    $emailsSent[] = $ingredientId;
                }
            }
            return $ingredientBalance;
        }
}
