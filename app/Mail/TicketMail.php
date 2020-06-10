<?php

namespace App\Mail;

use App\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $ticket;
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('users.tickets.mail')->attach(public_path() . '/files/' . auth()->user()->id . '/' . $this->ticket->pdf, array(
            'as' => 'Boletas.pdf',
            'mime' => 'application/pdf'));

    }
}
