<?php

namespace App\Http\Controllers;

use App\ClientContact;
use Illuminate\Http\Request;

class ClientContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'client_id' => 'required|integer|exists:clients,id',
            'client_contact_name' => 'required|string|',
            'client_contact_lastname' => 'nullable|string|',
            'client_contact_cellphone' => 'required|integer|',
            'client_contact_phone' => 'required|integer|',
            'client_contact_anexo' => 'required|integer|',
            'client_contact_email' => 'required|email|',
            'client_contact_charge' => 'required|string|',
            'client_contact_birthday' => 'required|date|',
            'client_contact_responsableFor' => 'required|string|',
        ]);

        ClientContact::create($request->all());
        //dd($request->all());
        return redirect()->route('client.edit', $request['client_id']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //  dd($request->all());
        $this->validate($request, [
            'client_id' => 'required|integer|exists:clients,id',
            'client_contact_name' => 'nullable|string|',
            'client_contact_lastname' => 'sometimes|string|',
            'client_contact_cellphone' => 'nullable|integer|',
            'client_contact_phone' => 'nullable|integer|',
            'client_contact_anexo' => 'nullable|integer|',
            'client_contact_email' => 'nullable|email|',
            'client_contact_charge' => 'nullable|string|',
            'client_contact_birthday' => 'nullable|date|',
            'client_contact_responsableFor' => 'nullable|string|',
        ]);

        $contact = ClientContact::findOrFail($id);
        $contact->update($request->all());
        return redirect()->route('client.edit', $request['client_id']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $contact = ClientContact::findOrFail($id);
        $contact->delete();
        return redirect()->route('client.edit', $contact->client_id);

    }
}
