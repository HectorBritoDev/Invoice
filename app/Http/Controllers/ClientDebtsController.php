<?php

namespace App\Http\Controllers;

use App\ClientDebt;
use App\DocumentType;
use Illuminate\Http\Request;

class ClientDebtsController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data = $this->validate($request, [
            'client_id' => 'required|integer|exists:clients,id',
            'document_type' => 'sometimes|required|string',
            'document_number' => 'sometimes|required|string',
            'document_emission' => 'sometimes|required|date',
            'document_expiration' => 'sometimes|required|date',
            'debt' => 'sometimes|required|integer',
            'file' => 'required|mimes:pdf',
        ]);

        $document_type = DocumentType::where('code', $data['document_type'])->first();
        if ($document_type != null) {
            $data['document_type'] = $document_type->name;
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $name = time() . $file->getClientOriginalName();
            $file->move(public_path() . '/files/' . $data['client_id'] . '/', $name);
            $data['file'] = $name;
            $data['file_title'] = $file->getClientOriginalName();
        }
        ClientDebt::create($data);
        //dd('go');

        return redirect()->route('client.edit', $request['client_id']);

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'client_id' => 'required|integer|exists:clients,id',
            'document_type' => 'sometimes|required|string',
            'document_number' => 'sometimes|required|string',
            'document_emission' => 'sometimes|required|date',
            'document_expiration' => 'sometimes|required|date',
            'debt' => 'sometimes|required|integer',
        ]);
        $debt = ClientDebt::findOrFail($id);
        $debt->update($request->all());

        return redirect()->route('client.edit', $debt->client_id);
    }

    public function destroy($id)
    {
        $debt = ClientDebt::findOrFail($id);
        $debt->delete();

        return redirect()->route('client.edit', $debt->client_id);

    }
}
