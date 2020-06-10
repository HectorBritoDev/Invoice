<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'photo', 'type', 'ruc',
        'sunat_situation', 'client_cellphone', 'client_note',
    ];
    protected $dates = ['deleted_at'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function clients()
    {
        return $this->hasMany('App\Client');
    }
    // public function clients()
    // {
    //     return $this->belongsToMany('App\Client', 'client_user')->withTimestamps();
    // }
    public function budgets()
    {
        return $this->hasMany('App\Budget');
    }
    public function invoices()
    {
        return $this->hasMany('App\Invoice');
    }
    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }
    public function debitNotes()
    {
        return $this->hasMany('App\DebitNote');
    }
    public function creditNotes()
    {
        return $this->hasMany('App\CreditNote');
    }
    public function senderGuides()
    {
        return $this->hasMany('App\SenderGuide');
    }
    public function operations()
    {
        return $this->hasMany('App\Operation');
    }
    public function saleConfiguration()
    {
        return $this->hasOne('App\SaleConfiguration');
    }
    public function clientConfiguration()
    {
        return $this->hasOne('App\ClientConfiguration');
    }
    public function budgetConfiguration()
    {
        return $this->hasOne('App\BudgetConfiguration');
    }
    public function invoiceConfiguration()
    {
        return $this->hasOne('App\InvoiceConfiguration');
    }
    public function ticketConfiguration()
    {
        return $this->hasOne('App\TicketConfiguration');
    }
    public function debitNoteConfiguration()
    {
        return $this->hasOne('App\DebitNoteConfiguration');
    }
    public function creditNoteConfiguration()
    {
        return $this->hasOne('App\CreditNoteConfiguration');
    }
    public function senderGuideConfiguration()
    {
        return $this->hasOne('App\SenderGuideConfiguration');
    }

    public function categories()
    {
        return $this->hasMany('App\GoodServiceCategory');
    }
}
