<?php

namespace App\Mail;

use App\Recipe;
use App\Anecdote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewAnecdote extends Mailable
{
    use Queueable, SerializesModels;
    
    /**
     * The recipe instance.
     *
     * @var Recipe
     */
    public $recipe;
    public $anecdote;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Recipe $recipe, Anecdote $anecdote)
    {
        $this->recipe = $recipe;
        $this->anecdote = $anecdote;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.anecdotes.new');
    }
}
