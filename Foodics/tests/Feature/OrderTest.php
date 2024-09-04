<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\IngredientBalance;
use App\Models\IngredientProduct;
use App\Models\Product;
use App\Models\Unit;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    protected $orderService;
    protected $orderRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock the OrderRepositoryInterface
        $this->orderRepositoryMock = $this->createMock(OrderRepositoryInterface::class);

        // Create an instance of OrderService with the mocked repository
        $this->orderService = new OrderService($this->orderRepositoryMock);
    }
    use RefreshDatabase;

    /** @test */
    public function it_stores_an_order_correctly_and_updates_stock()
    {
        // Arrange: Create a unit for measurement (e.g., grams)
        $unit = Unit::create([
            'name' => 'grams',
            'converting_factor' => '1',
            'is_main_unit' => '1',
            'cost_price' => '4',
            'sale_price' => '5',
        ]);

        $ingredient = Ingredient::create([
            'Name' => 'beef',
        ]);

        $ingredientBalance = IngredientBalance::create([
            'ingredient_id' => $ingredient->id,
            'amount' => '100',
            'initial_stock_balance' => '100',
            'unit_id' => $unit->id,
        ]);

        // Create a product
        $product = Product::create(['name' => 'burger']);

        // Link product to ingredient with a specific quantity using ProductIngredient
        IngredientProduct::create([
            'product_id' => $product->id,
            'ingredient_id' => $ingredient->id,
            'quantity' => 2, // Quantity required for the product
            'unit_id' => $unit->id,
        ]);

        // Define the mock order lines structure
        $orderLines = [
            (object)[
                'product' => (object)[
                    'ingredients' => [
                        (object)[
                            'pivot' => (object)[
                                'quantity' => 2,
                            ],
                            'id' => $ingredient->id,
                        ],
                    ],
                ],
                'quantity' => 5,
            ],
        ];

        // Mock the OrderRepositoryInterface to return a structured order
        $this->orderRepositoryMock->method('createOrder')
            ->willReturn((object)[
                'orderLines' => $orderLines
            ]);

        // Define order data
        $orderData = [
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 5,
                ],
            ],
        ];

        // Act: Place the order
        $this->orderService->placeOrder($orderData);
        // Assert: Check if the order was stored correctly
        $this->assertDatabaseHas('orders', ['id' => 1]);
        $this->assertDatabaseHas('order_lines', [
            'product_id' => $product->id,
            'quantity' => 5,
        ]);

        // Assert: Check if the stock was updated correctly
        $updatedIngredientBalance = IngredientBalance::find($ingredientBalance->id);
        $expectedStock = 100 - (2 * 5); // Initial stock minus quantity used
        $this->assertEquals($expectedStock, $updatedIngredientBalance->amount);
    }

//    /** @test */
//    public function it_throws_an_exception_when_stock_is_insufficient()
//    {
//        // Arrange: Create a unit for measurement
//        // Arrange: Create a unit for measurement (e.g., grams)
//        $unit = Unit::create([
//            'name' => 'grams',
//            'converting_factor' => '1',
//            'is_main_unit' => '1',
//            'cost_price' => '4',
//            'sale_price' => '5',
//        ]);
//
//        $ingredient = Ingredient::create([
//            'Name' => 'beef',
//        ]);
//
//        $ingredientBalance = IngredientBalance::create([
//            'ingredient_id' => $ingredient->id,
//            'amount' => '100',
//            'initial_stock_balance' => '100',
//            'unit_id' => $unit->id,
//        ]);
//
//        // Create a product
//        $product = Product::create(['name' => 'burger']);
//
//        // Link product to ingredient with a specific quantity using ProductIngredient
//        IngredientProduct::create([
//            'product_id' => $product->id,
//            'ingredient_id' => $ingredient->id,
//            'quantity' => 2, // Quantity required for the product
//            'unit_id' => $unit->id,
//        ]);
//
//
//
//
//        // Define order data
//        $orderData = [
//            'products' => [
//                [
//                    'product_id' => $product->id,
//                    'quantity' => 5,
//                ],
//            ],
//        ];
//
//        // Act and Assert: Attempt to place the order and expect an exception
//        $this->expectException(\Exception::class);
//        $this->expectExceptionMessage('Insufficient stock.');
//
//        $orderRepositoryMock = $this->createMock(OrderRepositoryInterface::class);
//
//        // Act: Place the order
//        $orderService = new OrderService($orderRepositoryMock);
//        $orderService->placeOrder($orderData);
//    }

}
