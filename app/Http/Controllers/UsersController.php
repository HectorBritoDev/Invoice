<?php

namespace App\Http\Controllers;

use App\ClientAdress;
use App\ClientAgreement;
use App\ClientContact;
use App\ClientDebt;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index()
    {

        // if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
        //     $clients = User::where('type', 'user')->latest()->get();
        //     $total_debt = 0;

        //     foreach ($clients as $client) {
        //         $total_debt = $total_debt + $client->clientDebt();
        //     }

        //     return view('users.clients.index', compact('clients', 'total_debt'));
        // }

    }

    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            //CLIENT DATA
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'ruc' => 'required|integer|unique:users',
            'sunat_situation' => 'required|string|',
            'client_cellphone' => 'required|integer|',
            //ADRESS
            'client_adress' => 'sometimes|required|string|',
            //CONTACT DATA
            'client_contact_name' => 'sometimes|required|string|',
            'client_contact_cellphone' => 'sometimes|required|integer|',
            'client_contact_phone' => 'sometimes|required|integer|',
            'client_contact_anexo' => 'sometimes|required|integer|',
            'client_contact_email' => 'sometimes|required|email|',
            'client_contact_charge' => 'sometimes|required|string|',
            'client_contact_birthday' => 'sometimes|required|date|',
            'client_contact_responsableFor' => 'sometimes|required|string|',
            //AGREEMENTS
            'conditions' => 'sometimes|required|string',
            'credit_line' => 'sometimes|required|string',
            'pay_method' => 'sometimes|required|string',
            //DEBT
            'document_type' => 'sometimes|required|string',
            'document_number' => 'sometimes|required|string',
            'document_emission' => 'sometimes|required|date',
            'document_expiration' => 'sometimes|required|date',
            'debt' => 'sometimes|required|integer',

        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'ruc' => $request['ruc'],
            'sunat_situation' => $request['sunat_situation'],
            'client_cellphone' => $request['client_cellphone'],

        ]);

        ClientAdress::create([
            'user_id' => $user->id,
            'client_adress' => $request['client_adress'],
        ]);

        ClientContact::create([
            'user_id' => $user->id,
            'client_contact_name' => $request['client_contact_name'],
            'client_contact_cellphone' => $request['client_contact_cellphone'],
            'client_contact_phone' => $request['client_contact_phone'],
            'client_contact_anexo' => $request['client_contact_anexo'],
            'client_contact_email' => $request['client_contact_email'],
            'client_contact_charge' => $request['client_contact_charge'],
            'client_contact_birthday' => $request['client_contact_birthday'],
            'client_contact_responsableFor' => $request['client_contact_responsableFor'],
        ]);
        ClientAgreement::create([
            'user_id' => $user->id,
            'conditions' => $request['conditions'],
            'credit_line' => $request['credit_line'],
            'pay_method' => $request['pay_method'],
        ]);
        ClientDebt::create([
            'user_id' => $user->id,
            'document_type' => $request['document_type'],
            'document_number' => $request['document_number'],
            'document_emission' => $request['document_emission'],
            'document_expiration' => $request['document_expiration'],
            'debt' => $request['debt'],
        ]);

        return redirect()->route('client.index');

    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }

}
