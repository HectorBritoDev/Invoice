<?php

namespace App\Http\Controllers;

use App\ClientAdress;
use Illuminate\Http\Request;

class ClientAdressesController extends Controller
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
        //
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
            'client_id' => 'required|integer|exists:clients,id',
            'client_adress' => 'sometimes|required|string|',
            'client_department_id' => 'sometimes|required|integer|exists:departments,id',
            'client_province_id' => 'sometimes|required|integer|exists:provinces,id',
            'client_district_id' => 'sometimes|required|integer|exists:districts,id',
        ]);
        ClientAdress::create($request->all());
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
        $this->validate($request, [
            'client_id' => 'required|integer|exists:clients,id',
            'client_adress' => 'sometimes|required|string|',
            'client_department_id' => 'sometimes|required|integer|exists:departments,id',
            'client_province_id' => 'sometimes|required|integer|exists:provinces,id',
            'client_district_id' => 'sometimes|required|integer|exists:districts,id',
        ]);
        $adress = ClientAdress::findOrFail($id);
        $adress->update($request->all());
        return redirect()->route('client.edit', $request['client_id']);
    }

    public function destroy($id)
    {
        $adress = ClientAdress::findOrFail($id);

        $adress->delete();

        return redirect()->route('client.edit', $adress->client_id);
    }
}
