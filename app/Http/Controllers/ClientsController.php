<?php

namespace App\Http\Controllers;

use Alert;
use App\Client;
use App\ClientAdress;
use App\ClientAgreement;
use App\ClientConfiguration;
use App\ClientContact;
use App\ClientDebt;
use App\ConditionOption;
use App\Department;
use App\District;
use App\DocumentType;
use App\Exports\ClientsExport;
use App\Http\Controllers\Controller;
use App\Imports\ClientsImport;
use App\Mail\DebtMail;
use App\PayOption;
use App\Province;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (\Gate::allows('isUser')) {
            //dd($request->all());
            if (auth()->user()->clientConfiguration == null) {
                $configuration = ClientConfiguration::create(['user_id' => auth()->user()->id]);
            } else {
                $configuration = auth()->user()->clientConfiguration;

            }

            if ($request['from_date'] != null && $request['to_date'] != null && $request['client_name'] != null) {
                //dd($request->all());
                $from = $request['from_date'];
                $to = $request['to_date'];
                $client_name = $request['client_name'];

                if ($client_name == 'all') {
                    $clients = auth()->user()->clients()->whereBetween('created_at', [$from, $to])->get();
                    //$clients = $clients;
                    //dd($clients);

                } else {
                    $clients = auth()->user()->clients()->whereBetween('created_at', [$from, $to])->get();
                    $clients = $clients->where('client_name', $client_name);
                    // dd($clients);
                }
            } elseif ($request['from_date'] == null && $request['to_date'] == null && $request['client_name'] != null) {
                if ($request['client_name'] == 'all') {
                    $clients = auth()->user()->clients;

                } else {

                    $clients = auth()->user()->clients->where('client_name', $request['client_name']);
                }
            } else {
                $clients = auth()->user()->clients;

            }
            $clientsList = auth()->user()->clients;

            $total_debt = 0;

            // foreach ($clients as $client) {
            //     $total_debt = $total_debt + $client->clientDebt();
            // }
            //dd($configuration);
            return view('users.clients.index', compact('clients', 'total_debt', 'configuration', 'clientsList'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        $document_type_options = DocumentType::all();
        $pay_options = PayOption::all();
        $condition_options = ConditionOption::all();
        return view('users.clients.create', compact('departments', 'document_type_options', 'pay_options', 'condition_options'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Gate::allows('isUser')) {

            //dd($request->all());
            // dd($request['client_main_adress']);
            $this->validate($request, [
                //CLIENT DATA

                'ruc' => 'sometimes|required|integer|unique:clients,ruc,NULL,id,user_id,' . Auth::id(),
                'dni' => 'sometimes|required|integer|unique:clients,dni,NULL,id,user_id,' . Auth::id(),
                'passport' => 'sometimes|required|integer|unique:clients,passport,NULL,id,user_id,' . Auth::id(),
                'client_name' => 'required|string|max:191',
                'client_lastname' => 'sometimes|string|max:191',
                'client_email' => 'sometimes|required|string|email|max:191',
                'client_main_adress' => 'sometimes|string|max:191',
                'sunat_situation' => 'sometimes|required|string|',
                //'client_cellphone' => 'required|integer|',
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
                'file' => 'sometimes|required|mimes:pdf',
            ]);
            // dd('passed');
            $client = Client::create([

                'user_id' => auth()->user()->id,
                'ruc' => $request['ruc'],
                'dni' => $request['dni'],
                'passport' => $request['passport'],
                'client_name' => $request['client_name'],
                'client_lastname' => $request['client_lastname'],
                'client_email' => $request['client_email'],
                'client_main_adress' => $request['client_main_adress'],
                'sunat_situation' => $request['sunat_situation'],
                'client_cellphone' => $request['client_cellphone'],

            ]);

            // ClientAdress::create([
            //     'client_id' => $client->id,
            //     'client_adress' => $request['client_adress'],
            // ]);

            // ClientContact::create([
            //     'client_id' => $client->id,
            //     'client_contact_name' => $request['client_contact_name'],
            //     'client_contact_cellphone' => $request['client_contact_cellphone'],
            //     'client_contact_phone' => $request['client_contact_phone'],
            //     'client_contact_anexo' => $request['client_contact_anexo'],
            //     'client_contact_email' => $request['client_contact_email'],
            //     'client_contact_charge' => $request['client_contact_charge'],
            //     'client_contact_birthday' => $request['client_contact_birthday'],
            //     'client_contact_responsableFor' => $request['client_contact_responsableFor'],
            // ]);
            // ClientAgreement::create([
            //     'client_id' => $client->id,
            //     'conditions' => $request['conditions'],
            //     'credit_line' => $request['credit_line'],
            //     'pay_method' => $request['pay_method'],
            // ]);
            // ClientDebt::create([
            //     'client_id' => $client->id,
            //     'document_type' => $request['document_type'],
            //     'document_number' => $request['document_number'],
            //     'document_emission' => $request['document_emission'],
            //     'document_expiration' => $request['document_expiration'],
            //     'debt' => $request['debt'],
            // ]);

            // if ($request->hasFile('file')) {
            //     $file = $request->file('file');
            //     $name = time() . $file->getClientOriginalName();
            //     $file->move(public_path() . '/files/' . $client->id . '/', $name);

            //     ClientFile::create([
            //         'client_id' => $client->id,
            //         'name' => $name,
            //         'title' => $file->getClientOriginalName(),
            //     ]);

            // }

            // ClientUser::create([
            //     'user_id' => auth()->user()->id,
            //     'client_id' => $client->id,
            // ]);

            Alert::toast('Cliente agregado correctamente', 'success', 'top-right');

            return redirect()->route('client.edit', $client);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        if (\Gate::allows('isUser')) {

            $departments = Department::all();
            $provinces = Province::all();
            $districts = District::all();
            return view('users.clients.show', compact('client', 'departments', 'provinces', 'districts'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        if (\Gate::allows('isUser')) {

            // $departments = Department::all();
            // $provinces = Province::all();
            // $districts = District::all();

            $document_type_options = DocumentType::all();
            $pay_options = PayOption::all();
            $condition_options = ConditionOption::all();
            $document_options = DocumentType::all();

            return view('users.clients.edit', compact('client', 'departments',
                'provinces', 'districts', 'document_type_options', 'pay_options', 'condition_options', 'document_options'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        if (\Gate::allows('isUser')) {

            $this->validate($request, [
                //CLIENT DATA
                'client_email' => 'sometimes|string|email|max:191,',
                'client_cellphone' => 'sometimes|integer|',
                'client_note' => 'sometimes|string',
                'client_main_adress' => 'sometimes|string',
                //ADRESS
                'client_adress' => 'sometimes|required|string|',
                'client_department_id' => 'sometimes|required|integer|exists:departments,id',
                'client_province_id' => 'sometimes|required|integer|exists:provinces,id',
                'client_district_id' => 'sometimes|required|integer|exists:districts,id',

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

            if ($request['client_note']) {

                $client->update($request->all());
                return redirect()->route('client.show', $client);

            }

            $client = Client::findOrFail($client);

            $adress = ClientAdress::findorFail($client->adresses()->first()->id);
            $contact = ClientContact::findOrFail($client->contacts()->first()->id);
            $agrement = ClientAgreement::findOrFail($client->agreements()->first()->id);
            $debt = ClientDebt::findOrFail($client->debts()->first()->id);

            $client->update($request->all());
            $adress->update($request->all());
            $contact->update($request->all());
            $agrement->update($request->all());
            $debt->update($request->all());

            Alert::toast('Editado correctamente', 'success', 'top-right');

            return redirect()->route('client.edit', $id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {

        if (\Gate::allows('isUser')) {

            $client->delete();
            Alert::toast('Cliente eliminado', 'error', 'top-right');

            return redirect()->route('client.index');
        }
    }

    public function clientList()
    {
        $clients = User::where('type', 'user')->orderBy('created_at', 'DES')->get();

        return view('users.clients.list', compact('clients'));
    }

    public function import(Request $request)
    {

        Excel::import(new ClientsImport, request()->file('xls'));

        return back();
    }

    public function export()
    {
        return Excel::download(new ClientsExport, 'clients.xlsx');

    }

    public function dataTable()
    {
        return datatables()
            ->eloquent(User::query()->find(Auth::user()->id)->clients())
            ->addColumn('btn', 'users.clients.actions')
            ->rawColumns(['btn'])
            ->toJson();
    }

    public function configuration(Request $request, ClientConfiguration $configuration)
    {
        //dd($request->all());
        $this->validate($request, [

            'client' => 'nullable|in:on',
            'phone' => 'nullable|in:on',
            'invoiced' => 'nullable|in:on',
            'debt' => 'nullable|in:on',
            'expiration_date' => 'nullable|in:on',
            'debt' => 'nullable|in:on',

        ]);
        if ($request['client']) {
            $request['client'] = 1;
        } else {
            $request['client'] = 0;
        }
        if ($request['phone']) {
            $request['phone'] = 1;
        } else {
            $request['phone'] = 0;
        }
        if ($request['invoiced']) {
            $request['invoiced'] = 1;
        } else {
            $request['invoiced'] = 0;
        }
        if ($request['debt']) {
            $request['debt'] = 1;
        } else {
            $request['debt'] = 0;
        }

        $configuration->update($request->all());

        Alert::toast('Configurado', 'success', 'top-right');

        return redirect()->route('client.index');
    }

    public function debtMail(Client $client)
    {
        //dd('recibido');
        Mail::to($client->client_email)->send(new DebtMail($client));
        Alert::toast('Notificación de deuda enviada', 'success', 'top-right');

        return redirect()->route('client.index');

    }

    public function sunat(Request $request)
    {
        $ruc = $request['ruc'];
        $data = file_get_contents("https://api.sunat.cloud/ruc/" . $ruc);
        // $response = json_decode($data);
        $info = json_decode($data, true);
        //dd($info);
        if ($data === '[]' || $info['fecha_inscripcion'] === '--') {
            // dd('here');
            $datos = array(0 => 'nada');
            return json_encode($datos);
        } elseif ((Auth::user()->clients->where('ruc', $info['ruc'])->count()) > 0) {
//
            $datos = array(0 => 'exists');
            return json_encode($datos);

        } else {

            $datos = array(
                0 => $info['ruc'],
                1 => $info['razon_social'],
                2 => $info['contribuyente_condicion'],
                3 => $info['domicilio_fiscal'],

            );

            echo json_encode($datos);
        }

    }

    public function reniec(Request $request)
    {

        $consulta = file_get_contents('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI=' . $request['dni']);

//LA LOGICA DE LA PAGINAS ES APELLIDO PATERNO | APELLIDO MATERNO | NOMBRES
        $partes = explode("|", $consulta);

        $datos = array(
            0 => $request['dni'],
            1 => $partes[0],
            2 => $partes[1],
            3 => $partes[2],
        );
        //dd((Auth::user()->clients->where('dni', $request['dni'])->count()) > 0);
        if ((Auth::user()->clients->where('dni', $request['dni'])->count()) > 0) {
            $datos[0] = "";
        }
        //dd($datos[0] == "");
        return json_encode($datos);

    }

    public function contactsBySunat(Request $request)
    {
        $ruc = $request['ruc'];
        $client_id = auth()->user()->clients->where('ruc', $ruc)->first()->id;
        //dd($client_id);
        $data = file_get_contents("https://api.sunat.cloud/ruc/" . $ruc);
        // $response = json_decode($data);
        $info = json_decode($data, true);

        foreach ($info['representante_legal'] as $contact) {

            $contact['nombre'];
            ClientContact::create([
                'client_id' => $client_id,
                'client_contact_name' => $contact['nombre'],
                'client_contact_charge' => $contact['cargo']]);
        }
        return ('success');

    }

    public function byName(Request $request)
    {

        $name = $request['name'];
        $client = auth()->user()->clients()->where('client_name', 'LIKE', "%$name%")->first();
        $adresses = $client->adresses;

        if ($client === null) {
            $client = array(0 => 'nada');
            return json_encode($client);
        } else {

            //echo json_encode($client);
            return json_encode(array('client' => $client, 'adresses' => $adresses));

        }


    }
    public function byRuc(Request $request)
    {
        $ruc = $request['ruc'];
        $client =auth()->user()->clients()->where('ruc', $ruc)->with('adresses')->orWhere('dni', $ruc)->orWhere('passport', $ruc)->first();
        //$info = dd(json_decode($data, true));
        if ($client === null) {
            $client = array(0 => 'nada');
            echo json_encode($client);
        } else {

            echo json_encode($client);
        }

    }

}
