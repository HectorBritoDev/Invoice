<?php

namespace App\Mail;

use App\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $invoice;

    public function __construct(Invoice $invoice)
    {

        $this->invoice = $invoice;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('users.invoices.mail')->attach(public_path() . '/files/' . auth()->user()->id . '/' . $this->invoice->pdf, array(
            'as' => 'Factura.pdf',
            'mime' => 'application/pdf'));

    }
}
