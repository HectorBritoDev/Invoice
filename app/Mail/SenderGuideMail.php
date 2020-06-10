<?php

namespace App\Mail;

use App\SenderGuide;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SenderGuideMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $senderGuide;
    public function __construct(SenderGuide $senderGuide)
    {
        $this->senderGuide = $senderGuide;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('users.senderGuides.mail')->attach(public_path() . '/files/' . auth()->user()->id . '/' . $this->senderGuide->pdf, array(
            'as' => 'Guia_remision.pdf',
            'mime' => 'application/pdf'));

    }
}
