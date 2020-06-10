<?php

namespace App\Http\Controllers;

use Alert;
use App\DebitNote;
use App\DebitNoteConfiguration;
use App\DebitNoteItem;
use App\Good;
use App\Invoice;
use App\Mail\DebitNoteMail;
use App\Operation;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class DebitNotesController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $this->validate($request,
            [

                'reason' => 'required|string|max:191',

            ]);
        $debitNotes = auth()->user()->debitNotes()->get();

        $data['user_id'] = auth()->user()->id;
        $lastDebitNote = $debitNotes->last();
        if ($lastDebitNote != null) {
            # code...
            $data['serie'] = $lastDebitNote->serie;
            $data['code'] = $lastDebitNote->code + 1;
        }
        $data['date'] = Carbon::parse(today())->format('y-m-d');

        $debitNote = DebitNote::create($data);

        return redirect()->route('debitNote.edit', $debitNote);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DebitNote  $debitNote
     * @return \Illuminate\Http\Response
     */
    public function show(DebitNote $debitNote)
    {
        if ($debitNote->status == null || $debitNote->status == 'guardada') {
            return redirect()->route('debitNote.edit', $debitNote);
        }

        $items = $debitNote->items()->get();
        $configuration = auth()->user()->debitNoteConfiguration;
        return view('users.debitNotes.show', compact('debitNote', 'items', 'configuration'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DebitNote  $debitNote
     * @return \Illuminate\Http\Response
     */
    public function edit(DebitNote $debitNote)
    {
        if ($debitNote->status == 'facturada' || $debitNote->status == 'vencida') {
            return redirect()->route('debitNote.show', $debitNote);
        } else {

            if (auth()->user()->debitNoteConfiguration == null) {
                $configuration = DebitNoteConfiguration::create(['user_id' => auth()->user()->id]);
            } else {
                $configuration = auth()->user()->debitNoteConfiguration;
            }
            //  dd($configuration = auth()->user()->debitNoteConfiguration);
            $invoices = auth()->user()->invoices()->get();
            $debitNotes = auth()->user()->debitNotes()->get();

            $goods = Good::where('user_id', auth()->user()->id)->get();
            $items = DebitNoteItem::where('debit_note_id', $debitNote->id)->get();
            // dd('here');
            return view('users.debitNotes.edit', compact('goods', 'items', 'debitNote', 'invoices', 'debitNotes', 'configuration'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DebitNote  $debitNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DebitNote $debitNote)
    {
        if ($request->has('save')) {
            $data['status'] = 'guardada';
            $debitNote->update($data);
            return redirect()->route('debitNote.edit', $debitNote);

        }
        if ($request->has('close')) {
            $data['status'] = 'facturada';

            $debitNote->update($data);
            if ($debitNote->invoice_id != null) {

                $invoice = Invoice::find($debitNote->invoice_id);
                //dd($invoice);
                if ($invoice != null) {
                    $invoice->update(['status' => 'facturada']);
                }
            }
            return redirect()->route('debitNote.edit', $debitNote);

        }
        if ($request->has('aproval')) {
            $data['status'] = 'aprobada';
            $debitNote->update($data);
            return redirect()->route('debitNote.edit', $debitNote);

        }
        if ($request->has('rejected')) {
            $data['status'] = 'rechazada';
            $debitNote->update($data);
            return redirect()->route('debitNote.edit', $debitNote);

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
            $file->move(public_path() . '/files/' . auth()->user()->id . '/debitNotes/', $name);
            $data['file'] = $name;
        }

        $debitNote->update($data);

        return redirect()->route('debitNote.edit', $debitNote);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DebitNote  $debitNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(DebitNote $debitNote)
    {
        $debitNote->delete();
        Alert::toast('Factura eliminada', 'error', 'top-right');

        return redirect()->route('sale.index');

    }
    public function destroyItems(DebitNote $debitNote)
    {

        $debitNote->items()->delete();
        Alert::toast('Items eliminados', 'error', 'top-right');

        return redirect()->route('debitNote.edit', $debitNote);
    }

    public function fromInvoice(Request $request)
    {
        // dd('here');

        $data = $this->validate($request, [
            'invoice_id' => 'required|integer|exists:invoices,id',
        ]);
        $invoice = Invoice::find($data['invoice_id']);
        $debitNotes = auth()->user()->debitNotes()->get();

        if ($debitNotes->last() != null) {
            $lastDebitNote = $debitNotes->last();
        } else {
            $lastDebitNote = $invoice;
        }

        if ($request->has('withBankAccounts')) {
            $debitNote = DebitNote::create([
                'user_id' => auth()->user()->id,
                'ruc' => $invoice->ruc,
                'dni' => $invoice->dni,
                'passport' => $invoice->passport,
                'code' => $lastDebitNote->code + 1,
                'serie' => $lastDebitNote->serie,
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

            $debitNote = DebitNote::create([
                'user_id' => auth()->user()->id,
                'ruc' => $invoice->ruc,
                'dni' => $invoice->dni,
                'passport' => $invoice->passport,
                'code' => $lastDebitNote->code + 1,
                'serie' => $lastDebitNote->serie,
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
            DebitNoteItem::create([
                'good_id' => $item->good_id,
                'debit_note_id' => $debitNote->id,
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
        //$data['status'] = 'facturado';
        //  $invoice->update(['status' => $data['status']]);
        // $data['status'] = 'Facturado';
        // $invoice->update($data);
        Operation::create([
            'user_id' => auth()->user()->id,
            'debit_note_id' => $debitNote->id,
            'emission_date' => $debitNote->emission_date,
            'expiration_date' => $debitNote->expiration_date,
            'type' => 'debitNote',
        ]);
        return redirect()->route('debitNote.edit', $debitNote);

    }

    public function copy(Request $request, DebitNote $debitNote)
    {
        //  dd($request->all());

        $this->validate($request, [
            'invoice_id' => 'required|exists:invoices,id',
        ]);

        $invoice = Invoice::find($request['invoice_id']);

        $debitNote->update([
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

        $debitNote->items()->delete();

        foreach ($invoice->items()->get() as $item) {
            DebitNoteItem::create([
                'debit_note_id' => $debitNote->id,
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
        Operation::create([
            'user_id' => auth()->user()->id,
            'debit_note_id' => $debitNote->id,
            'emission_date' => $invoice->emission_date,
            'expiration_date' => $invoice->expiration_date,
            'type' => 'debitNote']);

        return redirect()->route('debitNote.edit', $debitNote);
    }

    public function viewPdf(DebitNote $debitNote)
    {

        if ($debitNote->bank_account != null) {
            $accounts = true;
        } else {
            $accounts = false;
        }

        $items = $debitNote->items()->get();
        $user = auth()->user();
        $sub_total = $debitNote->items()->sum('sub_total');
        $today = today()->format('m-d-y');
        $tax = $debitNote->items()->sum('tax');
        $total = $debitNote->items()->sum('total');
        $view = \View::make('users.debitNotes.pdf', compact('debitNote', 'items', 'user', 'sub_total', 'tax', 'total', 'today', 'accounts'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream();

        //  $pdf = PDF::loadView('users.budgets.pdf', $data);
        //  return $pdf->render();

        //return view('users.invoice.pdf', compact('invoice', 'items'));

    }

    public function mail(DebitNote $debitNote)
    {
        // dd('mail');
        if ($debitNote->bank_account != null) {
            $accounts = true;
        } else {
            $accounts = false;
        }

        // if ($budget->pdf == null) { pendiente por realizar comprobacion para saber si ya tiene cotizacion con y sin nro de cuenta

        $data = [
            'accounts' => $accounts,
            'debitNote' => $debitNote,
            'items' => $debitNote->items()->get(),
            'user' => auth()->user(),
            'sub_total' => $debitNote->items()->sum('sub_total'),
            'today' => today()->format('m-d-y'),
            'tax' => $debitNote->items()->sum('tax'),
            'total' => $debitNote->items()->sum('total'),

        ];

        $name = time() . $debitNote->serie . $debitNote->code . '.pdf';
        $pdf = PDF::loadView('users.debitNotes.pdf', $data)->save(public_path() . '/files/' . auth()->user()->id . '/' . $name);

        $debitNote->update(['pdf' => $name]);

        // if ($request['debtMail']) {
        //     Mail::to;
        // }
        Mail::to($debitNote->client_email)->send(new DebitNoteMail($debitNote));
        Alert::toast('Factura enviada', 'success', 'top-right');

        return redirect()->route('debitNote.show', $debitNote);

    }

    public function configuration(Request $request, DebitNoteConfiguration $configuration)
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

        return redirect()->route('debitNote.edit', $request['debit_note_id']);
    }

}
