<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientFile;
use Illuminate\Http\Request;

class ClientFilesController extends Controller
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
     * @param  \App\Client  $client
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $client)
    {
        $this->validate($request, [
            'file' => 'required|mimes:pdf',
        ]);

        $file = $request->file('file');
        $name = time() . $file->getClientOriginalName();
        $file->move(public_path() . '/files/' . $client->id . '/', $name);
        ClientFile::create([
            'client_id' => $client->id,
            'name' => $name,
            'title' => $file->getClientOriginalName(),
        ]);
        return redirect()->route('client.edit', $client);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClientFile  $clientFile
     * @return \Illuminate\Http\Response
     */
    public function show(ClientFile $clientFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClientFile  $clientFile
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientFile $clientFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClientFile  $clientFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientFile $clientFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClientFile  $clientFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client, ClientFile $file)
    {

        $file->delete();

        return redirect()->route('client.edit', $client);
    }
}
