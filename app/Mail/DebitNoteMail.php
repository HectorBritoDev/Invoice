<?php

namespace App\Mail;

use App\DebitNote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DebitNoteMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $debitNote;
    public function __construct(DebitNote $debitNote)
    {
        $this->debitNote = $debitNote;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('users.debitNotes.mail')->attach(public_path() . '/files/' . auth()->user()->id . '/' . $this->debitNote->pdf, array(
            'as' => 'Nota_Debito.pdf',
            'mime' => 'application/pdf'));

    }
}
