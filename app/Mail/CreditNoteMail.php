<?php

namespace App\Mail;

use App\CreditNote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreditNoteMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $creditNote;
    public function __construct(CreditNote $creditNote)
    {
        $this->creditNote = $creditNote;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('users.creditNotes.mail')->attach(public_path() . '/files/' . auth()->user()->id . '/' . $this->creditNote->pdf, array(
            'as' => 'Nota_Credito.pdf',
            'mime' => 'application/pdf'));

    }
}
