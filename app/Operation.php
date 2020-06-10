<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Operation extends Model
{

    protected $fillable = ['user_id',
        'budget_id',
        'invoice_id',
        'ticket_id',
        'debit_note_id',
        'credit_note_id',
        'sender_guide_id',
        'emission_date',
        'expiration_date',
        'type'];

    public function budget()
    {
        return $this->belongsTo('App\Budget');
    }
    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
    public function ticket()
    {
        return $this->belongsTo('App\Ticket');
    }
    public function debitNote()
    {
        return $this->belongsTo('App\DebitNote');
    }
    public function creditNote()
    {
        return $this->belongsTo('App\CreditNote');
    }
    public function senderGuide()
    {
        return $this->belongsTo('App\SenderGuide');
    }

    public function getRealTypeAttribute()
    {
        if ($this->type == 'budget') {
            return 'cotizacion';

        }

        if ($this->type == 'invoice') {
            return 'factura';

        }
        if ($this->type == 'ticket') {
            return 'boleta';

        }
        if ($this->type == 'debitNote') {
            return 'Nota de debito';

        }
        if ($this->type == 'creditNote') {
            return 'Nota de credito';

        }
        if ($this->type == 'senderGuide') {
            return 'Guia de remision';

        }

    }

    public function getEmissionDateAttribute()
    {
        //dd($this->invoice);

        if ($this->type == 'budget' && $this->budget != null) {

            return Carbon::parse($this->budget->emission_date)->format('d-m-y');

        }
        if ($this->type == 'invoice' && $this->invoice != null) {

            return Carbon::parse($this->invoice->emission_date)->format('d-m-y');

        }
        if ($this->type == 'ticket' && $this->ticket != null) {

            return Carbon::parse($this->ticket->emission_date)->format('d-m-y');

        }
        if ($this->type == 'debitNote' && $this->debitNote != null) {

            return Carbon::parse($this->debitNote->emission_date)->format('d-m-y');

        }
        if ($this->type == 'creditNote' && $this->creditNote != null) {

            return Carbon::parse($this->creditNote->emission_date)->format('d-m-y');

        }
        if ($this->type == 'senderGuide' && $this->senderGuide != null) {

            return Carbon::parse($this->senderGuide->emission_date)->format('d-m-y');

        }
    }
    public function getNumberAttribute()
    {
        if ($this->type == 'budget' && $this->budget != null) {

            return $this->budget->serie . '-' . $this->budget->code;
        }
        if ($this->type == 'invoice' && $this->invoice != null) {
            return $this->invoice->serie . '-' . $this->invoice->code;
        }
        if ($this->type == 'ticket' && $this->ticket != null) {
            return $this->ticket->serie . '-' . $this->ticket->code;
        }
        if ($this->type == 'debitNote' && $this->debitNote != null) {
            return $this->debitNote->serie . '-' . $this->debitNote->code;
        }
        if ($this->type == 'creditNote' && $this->creditNote != null) {
            return $this->creditNote->serie . '-' . $this->creditNote->code;
        }
        if ($this->type == 'senderGuide' && $this->senderGuide != null) {
            return $this->senderGuide->serie . '-' . $this->senderGuide->code;
        }
    }
    public function getClientAttribute()
    {
        if ($this->type == 'budget' && $this->budget != null) {
            return $this->budget->client_name;
        }
        if ($this->type == 'invoice' && $this->invoice != null) {
            return $this->invoice->client_name;
        }
        if ($this->type == 'ticket' && $this->ticket != null) {
            return $this->ticket->client_name;
        }
        if ($this->type == 'debitNote' && $this->debitNote != null) {
            return $this->debitNote->client_name;
        }
        if ($this->type == 'creditNote' && $this->creditNote != null) {
            return $this->creditNote->client_name;
        }
        if ($this->type == 'senderGuide' && $this->senderGuide != null) {
            return $this->senderGuide->client_name;
        }
    }
    public function getExpirationDateAttribute()
    {
        if ($this->type == 'budget' && $this->budget != null) {
            return Carbon::parse($this->budget->expiration_date)->format('d-m-y');
        }
        if ($this->type == 'invoice' && $this->invoice != null) {
            return Carbon::parse($this->invoice->expiration_date)->format('d-m-y');
        }
        if ($this->type == 'ticket' && $this->ticket != null) {
            return Carbon::parse($this->ticket->expiration_date)->format('d-m-y');
        }
        if ($this->type == 'debitNote' && $this->debitNote != null) {
            return Carbon::parse($this->debitNote->expiration_date)->format('d-m-y');
        }
        if ($this->type == 'creditNote' && $this->creditNote != null) {
            return Carbon::parse($this->creditNote->expiration_date)->format('d-m-y');
        }
        if ($this->type == 'senderGuide' && $this->senderGuide != null) {
            return Carbon::parse($this->senderGuide->expiration_date)->format('d-m-y');
        }
    }
    public function getStatusAttribute()
    {
        if ($this->type == 'budget' && $this->budget != null) {
            return $this->budget->status;
        }
        if ($this->type == 'invoice' && $this->invoice != null) {
            return $this->invoice->status;
        }
        if ($this->type == 'ticket' && $this->ticket != null) {
            return $this->ticket->status;
        }
        if ($this->type == 'debitNote' && $this->debitNote != null) {
            return $this->debitNote->status;
        }
        if ($this->type == 'creditNote' && $this->creditNote != null) {
            return $this->creditNote->status;
        }
        if ($this->type == 'senderGuide' && $this->senderGuide != null) {
            return $this->senderGuide->status;
        }
    }
    public function getUrlAttribute()
    {
        if ($this->type == 'budget' && $this->budget != null) {
            return 'budget/' . $this->budget->id . '/edit';
        }
        if ($this->type == 'invoice' && $this->invoice != null) {
            return 'invoice/' . $this->invoice->id . '/edit';
        }
        if ($this->type == 'ticket' && $this->ticket != null) {
            return 'ticket/' . $this->ticket->id . '/edit';
        }
        if ($this->type == 'debitNote' && $this->debitNote != null) {
            return 'debitNote/' . $this->debitNote->id . '/edit';
        }
        if ($this->type == 'creditNote' && $this->creditNote != null) {
            return 'creditNote/' . $this->creditNote->id . '/edit';
        }
        if ($this->type == 'senderGuide' && $this->senderGuide != null) {
            return 'senderGuide/' . $this->senderGuide->id . '/edit';
        }
    }
    public function getShowAttribute()
    {
        if ($this->type == 'budget' && $this->budget != null) {
            return 'budget/' . $this->budget->id;
        }
        if ($this->type == 'invoice' && $this->invoice != null) {
            return 'invoice/' . $this->invoice->id;
        }
        if ($this->type == 'ticket' && $this->ticket != null) {
            return 'ticket/' . $this->ticket->id;
        }
        if ($this->type == 'debitNote' && $this->debitNote != null) {
            return 'debitNote/' . $this->debitNote->id;
        }
        if ($this->type == 'creditNote' && $this->creditNote != null) {
            return 'creditNote/' . $this->creditNote->id;
        }
        if ($this->type == 'senderGuide' && $this->senderGuide != null) {
            return 'senderGuide/' . $this->senderGuide->id;
        }
    }

    public function getDeleteUrlAttribute()
    {
        if ($this->type == 'budget' && $this->budget != null) {
            return 'budget/' . $this->budget->id;
        }
        if ($this->type == 'invoice' && $this->invoice != null) {
            return 'invoice/' . $this->invoice->id;
        }
        if ($this->type == 'ticket' && $this->ticket != null) {
            return 'ticket/' . $this->ticket->id;
        }
        if ($this->type == 'debitNote' && $this->debitNote != null) {
            return 'debitNote/' . $this->debitNote->id;
        }
        if ($this->type == 'creditNote' && $this->creditNote != null) {
            return 'creditNote/' . $this->creditNote->id;
        }
        if ($this->type == 'senderGuide' && $this->senderGuide != null) {
            return 'senderGuide/' . $this->senderGuide->id;
        }

    }

    public function getMailUrlAttribute()
    {
        if ($this->type == 'budget' && $this->budget != null) {
            return 'mail/budget' . $this->budget->id;
        }
        if ($this->type == 'invoice' && $this->invoice != null) {
            return 'mail/invoice' . $this->invoice->id;
        }
        if ($this->type == 'ticket' && $this->ticket != null) {
            return 'mail/ticket' . $this->ticket->id;
        }
        if ($this->type == 'debitNote' && $this->debitNote != null) {
            return 'mail/debitNote' . $this->debitNote->id;
        }
        if ($this->type == 'creditNote' && $this->creditNote != null) {
            return 'mail/creditNote' . $this->creditNote->id;
        }
        if ($this->type == 'senderGuide' && $this->senderGuide != null) {
            return 'mail/senderGuide' . $this->senderGuide->id;
        }

    }
    public function getPdfViewUrlAttribute()
    {
        if ($this->type == 'budget' && $this->budget != null) {
            return 'pdf/budget/' . $this->budget->id . '/view';
        }
        if ($this->type == 'invoice' && $this->invoice != null) {
            return 'pdf/invoice/' . $this->invoice->id . '/view';
        }
        if ($this->type == 'ticket' && $this->ticket != null) {
            return 'pdf/ticket/' . $this->ticket->id . '/view';
        }
        if ($this->type == 'debitNote' && $this->debitNote != null) {
            return 'pdf/debitNote/' . $this->debitNote->id . '/view';
        }
        if ($this->type == 'creditNote' && $this->creditNote != null) {
            return 'pdf/creditNote/' . $this->creditNote->id . '/view';
        }
        if ($this->type == 'senderGuide' && $this->senderGuide != null) {
            return 'pdf/senderGuide/' . $this->senderGuide->id . '/view';
        }

    }

}
