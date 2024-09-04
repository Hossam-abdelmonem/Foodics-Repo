<?php

namespace App\Http\Controllers;

use App\Services\Contracts\OrderServiceInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function placeOrder(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'products' => 'required|array',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1'
            ]);

            $order = $this->orderService->placeOrder($validatedData);

            return response()->json(['message' => 'Order placed successfully', 'order' => $order], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
