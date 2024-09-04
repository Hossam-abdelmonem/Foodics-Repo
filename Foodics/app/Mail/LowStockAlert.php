<?php

namespace App\Mail;

use App\Models\IngredientBalance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LowStockAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $ingredientBalance;

    /**
     * Create a new message instance.
     *
     * @param  IngredientBalance  $ingredientBalance
     * @return void
     */
    public function __construct(IngredientBalance $ingredientBalance)
    {
        $this->ingredientBalance = $ingredientBalance;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.low_stock_alert')
            ->subject('Low Stock Alert for Ingredient: ' . $this->ingredientBalance->ingredient->name);
    }
}
