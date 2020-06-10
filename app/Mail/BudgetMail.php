<?php

namespace App\Mail;

use App\Budget;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BudgetMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $budget;

    public function __construct(Budget $budget)
    {

        $this->budget = $budget;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('users.budgets.mail')->attach(public_path() . '/files/' . auth()->user()->id . '/' . $this->budget->pdf, array(
            'as' => 'Cotización.pdf',
            'mime' => 'application/pdf'));
    }
}
