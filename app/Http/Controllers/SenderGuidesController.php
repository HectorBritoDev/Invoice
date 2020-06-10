<?php

namespace App\Http\Controllers;

use Alert;
use App\Good;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Mail\SenderGuideMail;
use App\Operation;
use App\SenderGuide;
use App\SenderGuideConfiguration;
use App\SenderGuideItem;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class SenderGuidesController extends Controller
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
        // dd($request->all());

        $data = $this->validate($request,
            [
                //client
                'client_name' => 'required|string|max:191',
                'ruc' => 'sometimes|integer',
                'dni' => 'sometimes|integer',
                'client_email' => 'required|email',
                'emission_date' => 'required|date',

                'start_point' => 'required|string|max:191',
                'end_point' => 'required|string|max:191',
                'licence_plate' => 'required|string',
                'car_brand' => 'required|string',
                'reason' => 'required|string|max:191',
                'driver_licence' => 'required|string',
                'driver_name' => 'required|string',
                'transfer_date' => 'required|date',
                'driver_ruc' => 'required|integer',

                'payer_dni' => 'sometimes|integer',
                'payer_ruc' => 'sometimes|integer',

            ]);
        //dd($data['payer_ruc']);
        $senderGuides = auth()->user()->senderGuides()->get();
        //dd('here');

        $data['user_id'] = auth()->user()->id;
        $senderGuide = $senderGuides->last();
        if ($senderGuide != null) {
            # code...
            $data['serie'] = $senderGuide->serie;
            $data['code'] = $senderGuide->code + 1;
        }
        $data['date'] = Carbon::parse(today())->format('y-m-d');

        $senderGuide = SenderGuide::create($data);
        Operation::create([
            'user_id' => auth()->user()->id,
            'sender_guide_id' => $senderGuide->id,
            'emission_date' => $senderGuide->emission_date,
            'expiration_date' => $senderGuide->expiration_date,
            'type' => 'senderGuide']);

        return redirect()->route('senderGuide.edit', $senderGuide);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SenderGuide  $senderGuide
     * @return \Illuminate\Http\Response
     */
    public function show(SenderGuide $senderGuide)
    {
        if ($senderGuide->status == null || $senderGuide->status == 'guardada') {
            return redirect()->route('senderGuide.edit', $senderGuide);
        }

        $items = $senderGuide->items()->get();
        $configuration = auth()->user()->senderGuideConfiguration;
        return view('users.senderGuides.show', compact('senderGuide', 'items', 'configuration'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SenderGuide  $senderGuide
     * @return \Illuminate\Http\Response
     */
    public function edit(SenderGuide $senderGuide)
    {
        if ($senderGuide->status == 'facturada' || $senderGuide->status == 'vencida') {
            return redirect()->route('senderGuide.show', $senderGuide);
        } else {

            if (auth()->user()->senderGuideConfiguration == null) {
                $configuration = SenderGuideConfiguration::create(['user_id' => auth()->user()->id]);
            } else {
                $configuration = auth()->user()->senderGuideConfiguration;
            }
            //  dd($configuration = auth()->user()->senderGuideConfiguration);
            $invoices = auth()->user()->invoices()->get();
            $senderGuides = auth()->user()->senderGuides()->get();

            $goods = Good::where('user_id', auth()->user()->id)->get();
            $items = SenderGuideItem::where('sender_guide_id', $senderGuide->id)->get();
            // dd('here');
            return view('users.senderGuides.edit', compact('goods', 'items', 'senderGuide', 'invoices', 'senderGuides', 'configuration'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SenderGuide  $senderGuide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SenderGuide $senderGuide)
    {
        if ($request->has('save')) {
            $data['status'] = 'guardada';
            $senderGuide->update($data);
            return redirect()->route('senderGuide.edit', $senderGuide);

        }
        if ($request->has('close')) {
            $data['status'] = 'facturada';

            $senderGuide->update($data);
            if ($senderGuide->invoice_id != null) {

                $invoice = Invoice::find($senderGuide->invoice_id);
                //dd($invoice);
                if ($invoice != null) {
                    $invoice->update(['status' => 'facturada']);
                }
            }
            return redirect()->route('senderGuide.edit', $senderGuide);

        }
        if ($request->has('aproval')) {
            $data['status'] = 'aprobada';
            $senderGuide->update($data);
            return redirect()->route('senderGuide.edit', $senderGuide);

        }
        if ($request->has('rejected')) {
            $data['status'] = 'rechazada';
            $senderGuide->update($data);
            return redirect()->route('senderGuide.edit', $senderGuide);

        }
//dd($request->all());
        $data = $this->validate($request, [
            'serie' => 'sometimes|required|string',
            'code' => 'sometimes|required|integer',
            'sunat_resolution' => 'sometimes|required|string',
            'note' => 'sometimes|string',
            'detraction_account' => 'sometimes|string|max:191',
            'internal_message' => 'sometimes|string',
            'bank_account' => 'sometimes|string|max:191',
            'file' => 'sometimes|mimes:pdf',

        ]);
        if ($request->hasFile('file')) {
            # code...
            $file = $request->file('file');
            $name = time() . $file->getClientOriginalName();
            $file->move(public_path() . '/files/' . auth()->user()->id . '/senderGuides/', $name);
            $data['file'] = $name;
        }

        $senderGuide->update($data);

        return redirect()->route('senderGuide.edit', $senderGuide);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SenderGuide  $senderGuide
     * @return \Illuminate\Http\Response
     */
    public function destroy(SenderGuide $senderGuide)
    {
        $senderGuide->delete();
        Alert::toast('Guia de remisión eliminada', 'error', 'top-right');

        return redirect()->route('sale.index');

    }

    public function destroyItems(SenderGuide $senderGuide)
    {

        $senderGuide->items()->delete();
        Alert::toast('Items eliminados', 'error', 'top-right');

        return redirect()->route('senderGuide.edit', $senderGuide);
    }

    public function fromInvoice(Request $request)
    {
        // dd('here');

        $data = $this->validate($request, [
            'invoice_id' => 'required|integer|exists:invoices,id',
        ]);
        $invoice = Invoice::find($data['invoice_id']);
        $senderGuides = auth()->user()->senderGuides()->get();

        if ($senderGuides->last() != null) {
            $lastSenderGuide = $senderGuides->last();
        } else {
            $lastSenderGuide = $invoice;
        }

        if ($request->has('withBankAccounts')) {
            $senderGuide = SenderGuide::create([
                'user_id' => auth()->user()->id,
                'ruc' => $invoice->ruc,
                'dni' => $invoice->dni,
                'passport' => $invoice->passport,
                'code' => $lastSenderGuide->code + 1,
                'serie' => $lastSenderGuide->serie,
                'sunat_resolution' => $invoice->sunat_resolution,
                'client_name' => $invoice->client_name,
                'client_main_adress' => $invoice->client_main_adress,
                'client_phone' => $invoice->client_phone,
                'client_email' => $invoice->client_email,
                'emission_date' => $invoice->emission_date,
                'condition' => $invoice->condition,
                'expiration_date' => $invoice->expiration_date,
                'coin' => $invoice->coin,
                'budget_id' => $invoice->id,
                'bank_account' => $invoice->bank_account,
                // 'total' => $invoice->items()->sum('total'),
                // 'sub_total' => $invoice->items()->sum('sub_total'),
                // 'tax' => $invoice->items()->sum('tax'),
            ]);
        } else {

            $senderGuide = SenderGuide::create([
                'user_id' => auth()->user()->id,
                'ruc' => $invoice->ruc,
                'dni' => $invoice->dni,
                'passport' => $invoice->passport,
                'code' => $lastSenderGuide->code + 1,
                'serie' => $lastSenderGuide->serie,
                'sunat_resolution' => $invoice->sunat_resolution,
                'client_name' => $invoice->client_name,
                'client_main_adress' => $invoice->client_main_adress,
                'client_phone' => $invoice->client_phone,
                'client_email' => $invoice->client_email,
                'emission_date' => $invoice->emission_date,
                'condition' => $invoice->condition,
                'expiration_date' => $invoice->expiration_date,
                'coin' => $invoice->coin,
                'invoice_id' => $invoice->id,
                // 'total' => $invoice->items()->sum('total'),
                // 'sub_total' => $invoice->items()->sum('sub_total'),
                // 'tax' => $invoice->items()->sum('tax'),
            ]);
        }
        foreach ($invoice->items()->get() as $item) {
            SenderGuideItem::create([
                'good_id' => $item->good_id,
                'sender_guide_id' => $senderGuide->id,
                'name' => $item->name,
                'measure' => $item->measure,
                'reference' => $item->reference,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'discount' => $item->discount,
                'sub_total' => $item->sub_total,
                'tax' => $item->tax,
                'total' => $item->total,
                'igv_type' => $item->igv_type,

            ]);
        }

        Operation::create([
            'user_id' => auth()->user()->id,
            'sender_guide_id' => $senderGuide->id,
            'emission_date' => $senderGuide->emission_date,
            'expiration_date' => $senderGuide->expiration_date,
            'type' => 'senderGuide',
        ]);
        return redirect()->route('senderGuide.edit', $senderGuide);

    }

    public function copy(Request $request, SenderGuide $senderGuide)
    {
        //  dd($request->all());

        $this->validate($request, [
            'invoice_id' => 'required|exists:invoices,id',
        ]);

        $invoice = Invoice::find($request['invoice_id']);

        $senderGuide->update([
            'note' => $invoice->note,
            'client_name' => $invoice->client_name,
            'client_main_adress' => $invoice->client_main_adress,
            'client_main_adress' => $invoice->client_main_adress,
            'client_email' => $invoice->client_email,
            'dni' => $invoice->dni,
            'ruc' => $invoice->ruc,
            'detraction_account' => $invoice->detraction_account,
            'internal_message' => $invoice->internal_message,
            'bank_account' => $invoice->bank_account,
            'emission_date' => $invoice->emission_date,
            'expiration_date' => $invoice->expiration_date,
            'condition' => $invoice->condition,

            'invoice_id' => $invoice->id,
            'coin' => $invoice->coin,
        ]);

        $senderGuide->items()->delete();

        foreach ($invoice->items()->get() as $item) {
            SenderGuideItem::create([
                'sender_guide_id' => $senderGuide->id,
                'good_id' => $item->good_id,
                'name' => $item->name,
                'measure' => $item->measure,
                'reference' => $item->reference,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'discount' => $item->discount,
                'sub_total' => $item->sub_total,
                'tax' => $item->tax,
                'total' => $item->total,
                'igv_type' => $item->igv_type,

            ]);
        }

        Alert::toast('Factura copiada', 'success', 'top-right');

        return redirect()->route('senderGuide.edit', $senderGuide);
    }

    public function mail(SenderGuide $senderGuide)
    {
        // dd('mail');
        if ($senderGuide->bank_account != null) {
            $accounts = true;
        } else {
            $accounts = false;
        }

        // if ($budget->pdf == null) { pendiente por realizar comprobacion para saber si ya tiene cotizacion con y sin nro de cuenta

        $data = [
            'accounts' => $accounts,
            'senderGuide' => $senderGuide,
            'items' => $senderGuide->items()->get(),
            'user' => auth()->user(),
            'sub_total' => $senderGuide->items()->sum('sub_total'),
            'today' => today()->format('m-d-y'),
            'tax' => $senderGuide->items()->sum('tax'),
            'total' => $senderGuide->items()->sum('total'),

        ];

        $name = time() . $senderGuide->serie . $senderGuide->code . '.pdf';
        $pdf = PDF::loadView('users.senderGuides.pdf', $data)->save(public_path() . '/files/' . auth()->user()->id . '/' . $name);

        $senderGuide->update(['pdf' => $name]);

        // if ($request['debtMail']) {
        //     Mail::to;
        // }
        Mail::to($senderGuide->client_email)->send(new SenderGuideMail($senderGuide));
        Alert::toast('Guia de remisión enviada', 'success', 'top-right');

        return redirect()->route('senderGuide.show', $senderGuide);

    }

    public function viewPdf(senderGuide $senderGuide)
    {

        if ($senderGuide->bank_account != null) {
            $accounts = true;
        } else {
            $accounts = false;
        }

        $items = $senderGuide->items()->get();
        $user = auth()->user();
        $sub_total = $senderGuide->items()->sum('sub_total');
        $today = today()->format('m-d-y');
        $tax = $senderGuide->items()->sum('tax');
        $total = $senderGuide->items()->sum('total');
        $view = \View::make('users.senderGuides.pdf', compact('senderGuide', 'items', 'user', 'sub_total', 'tax', 'total', 'today', 'accounts'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream();

        //  $pdf = PDF::loadView('users.budgets.pdf', $data);
        //  return $pdf->render();

        //return view('users.invoice.pdf', compact('invoice', 'items'));

    }

    public function configuration(Request $request, SenderGuideConfiguration $configuration)
    {
        //dd($request->all());
        $this->validate($request, [

            'phone' => 'nullable|in:on',
            'email' => 'nullable|in:on',
            'web' => 'nullable|in:on',
            'user_description' => 'nullable|in:on',
            'seller' => 'nullable|in:on',
            'reference' => 'nullable|in:on',
            'price' => 'nullable|in:on',
            'client_message' => 'nullable|in:on',
            'internal_message' => 'nullable|in:on',
            'detraction_account' => 'nullable|in:on',
            'bank_account' => 'nullable|in:on',
        ]);
        // dd('here');
        if ($request['phone']) {
            $request['phone'] = 1;
        } else {
            $request['phone'] = 0;
        }
        if ($request['email']) {
            $request['email'] = 1;
        } else {
            $request['email'] = 0;
        }
        if ($request['web']) {
            $request['web'] = 1;
        } else {
            $request['web'] = 0;
        }
        if ($request['user_description']) {
            $request['user_description'] = 1;
        } else {
            $request['user_description'] = 0;
        }
        if ($request['seller']) {
            $request['seller'] = 1;
        } else {
            $request['seller'] = 0;
        }
        if ($request['reference']) {
            $request['reference'] = 1;
        } else {
            $request['reference'] = 0;
        }
        if ($request['price']) {
            $request['price'] = 1;
        } else {
            $request['price'] = 0;
        }
        if ($request['client_message']) {
            $request['client_message'] = 1;
        } else {
            $request['client_message'] = 0;
        }
        if ($request['internal_message']) {
            $request['internal_message'] = 1;
        } else {
            $request['internal_message'] = 0;
        }
        if ($request['detraction_account']) {
            $request['detraction_account'] = 1;
        } else {
            $request['detraction_account'] = 0;
        }
        if ($request['bank_account']) {
            $request['bank_account'] = 1;
        } else {
            $request['bank_account'] = 0;
        }
        // dd($configuration);
        $configuration->update($request->all());

        return redirect()->route('senderGuide.edit', $request['sender_guide_id']);
    }

}
