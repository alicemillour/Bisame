<?php

namespace App\Mail;

use App\Recipe;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewRecipe extends Mailable
{
    use Queueable, SerializesModels;
    
    /**
     * The recipe instance.
     *
     * @var Recipe
     */
    public $recipe;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.recipes.new');
    }
}
