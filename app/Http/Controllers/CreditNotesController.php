<?php

namespace App\Http\Controllers;

use Alert;
use App\CreditNote;
use App\CreditNoteConfiguration;
use App\CreditNoteItem;
use App\Good;
use App\Invoice;
use App\Mail\CreditNoteMail;
use App\Operation;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class CreditNotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        $creditNotes = auth()->user()->creditNotes()->get();

        $data['user_id'] = auth()->user()->id;
        $lasCreditNote = $creditNotes->last();
        if ($lasCreditNote != null) {
            # code...
            $data['serie'] = $lasCreditNote->serie;
            $data['code'] = $lasCreditNote->code + 1;
        }
        $data['date'] = Carbon::parse(today())->format('y-m-d');

        $creditNote = CreditNote::create($data);

        return redirect()->route('creditNote.edit', $creditNote);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CreditNote  $creditNote
     * @return \Illuminate\Http\Response
     */
    public function show(CreditNote $creditNote)
    {
        if ($creditNote->status == null || $creditNote->status == 'guardada') {
            return redirect()->route('creditNote.edit', $creditNote);
        }

        $items = $creditNote->items()->get();
        $configuration = auth()->user()->creditNoteConfiguration;
        return view('users.creditNotes.show', compact('creditNote', 'items', 'configuration'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CreditNote  $creditNote
     * @return \Illuminate\Http\Response
     */
    public function edit(CreditNote $creditNote)
    {
        if ($creditNote->status == 'facturada' || $creditNote->status == 'vencida') {
            return redirect()->route('creditNote.show', $creditNote);
        } else {

            if (auth()->user()->creditNoteConfiguration == null) {
                $configuration = CreditNoteConfiguration::create(['user_id' => auth()->user()->id]);
            } else {
                $configuration = auth()->user()->creditNoteConfiguration;
            }
            //  dd($configuration = auth()->user()->creditNoteConfiguration);
            $invoices = auth()->user()->invoices()->get();
            $creditNotes = auth()->user()->creditNotes()->get();

            $goods = Good::where('user_id', auth()->user()->id)->get();
            $items = CreditNoteItem::where('credit_note_id', $creditNote->id)->get();
            // dd('here');
            return view('users.creditNotes.edit', compact('goods', 'items', 'creditNote', 'invoices', 'creditNotes', 'configuration'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CreditNote  $creditNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CreditNote $creditNote)
    {
        if ($request->has('save')) {
            $data['status'] = 'guardada';
            $creditNote->update($data);
            return redirect()->route('creditNote.edit', $creditNote);

        }
        if ($request->has('close')) {
            $data['status'] = 'facturada';

            $creditNote->update($data);
            if ($creditNote->invoice_id != null) {

                $invoice = Invoice::find($creditNote->invoice_id);
                //dd($invoice);
                if ($invoice != null) {
                    $invoice->update(['status' => 'facturada']);
                }
            }
            return redirect()->route('creditNote.edit', $creditNote);

        }
        if ($request->has('aproval')) {
            $data['status'] = 'aprobada';
            $creditNote->update($data);
            return redirect()->route('creditNote.edit', $creditNote);

        }
        if ($request->has('rejected')) {
            $data['status'] = 'rechazada';
            $creditNote->update($data);
            return redirect()->route('creditNote.edit', $creditNote);

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
            $file->move(public_path() . '/files/' . auth()->user()->id . '/creditNotes/', $name);
            $data['file'] = $name;
        }

        $creditNote->update($data);

        return redirect()->route('creditNote.edit', $creditNote);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CreditNote  $creditNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(CreditNote $creditNote)
    {
        $creditNote->delete();
        Alert::toast('Nota de crédito eliminada', 'error', 'top-right');

        return redirect()->route('sale.index');

    }
    public function destroyItems(CreditNote $creditNote)
    {

        $creditNote->items()->delete();
        Alert::toast('Items eliminados', 'error', 'top-right');

        return redirect()->route('creditNote.edit', $creditNote);
    }
    public function fromInvoice(Request $request)
    {
        // dd('here');

        $data = $this->validate($request, [
            'invoice_id' => 'required|integer|exists:invoices,id',
        ]);
        $invoice = Invoice::find($data['invoice_id']);
        $creditNotes = auth()->user()->creditNotes()->get();

        if ($creditNotes->last() != null) {
            $lastCreditNote = $creditNotes->last();
        } else {
            $lastCreditNote = $invoice;
        }

        if ($request->has('withBankAccounts')) {
            $creditNote = CreditNote::create([
                'user_id' => auth()->user()->id,
                'ruc' => $invoice->ruc,
                'dni' => $invoice->dni,
                'passport' => $invoice->passport,
                'code' => $lastCreditNote->code + 1,
                'serie' => $lastCreditNote->serie,
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

            $creditNote = CreditNote::create([
                'user_id' => auth()->user()->id,
                'ruc' => $invoice->ruc,
                'dni' => $invoice->dni,
                'passport' => $invoice->passport,
                'code' => $lastCreditNote->code + 1,
                'serie' => $lastCreditNote->serie,
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
            creditNoteItem::create([
                'good_id' => $item->good_id,
                'creditt_note_id' => $creditNote->id,
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
            'credit_note_id' => $creditNote->id,
            'emission_date' => $creditNote->emission_date,
            'expiration_date' => $creditNote->expiration_date,
            'type' => 'creditNote',
        ]);
        return redirect()->route('creditNote.edit', $creditNote);

    }

    public function copy(Request $request, CreditNote $creditNote)
    {
        //  dd($request->all());

        $this->validate($request, [
            'invoice_id' => 'required|exists:invoices,id',
        ]);

        $invoice = Invoice::find($request['invoice_id']);

        $creditNote->update([
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

        $creditNote->items()->delete();

        foreach ($invoice->items()->get() as $item) {
            CreditNoteItem::create([
                'credit_note_id' => $creditNote->id,
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
            'credit_note_id' => $creditNote->id,
            'emission_date' => $invoice->emission_date,
            'expiration_date' => $invoice->expiration_date,
            'type' => 'creditNote']);

        return redirect()->route('creditNote.edit', $creditNote);
    }

    public function mail(CreditNote $creditNote)
    {
        // dd('mail');
        if ($creditNote->bank_account != null) {
            $accounts = true;
        } else {
            $accounts = false;
        }

        // if ($budget->pdf == null) { pendiente por realizar comprobacion para saber si ya tiene cotizacion con y sin nro de cuenta

        $data = [
            'accounts' => $accounts,
            'creditNote' => $creditNote,
            'items' => $creditNote->items()->get(),
            'user' => auth()->user(),
            'sub_total' => $creditNote->items()->sum('sub_total'),
            'today' => today()->format('m-d-y'),
            'tax' => $creditNote->items()->sum('tax'),
            'total' => $creditNote->items()->sum('total'),

        ];

        $name = time() . $creditNote->serie . $creditNote->code . '.pdf';
        $pdf = PDF::loadView('users.creditNotes.pdf', $data)->save(public_path() . '/files/' . auth()->user()->id . '/' . $name);

        $creditNote->update(['pdf' => $name]);

        // if ($request['debtMail']) {
        //     Mail::to;
        // }
        Mail::to($creditNote->client_email)->send(new CreditNoteMail($creditNote));
        Alert::toast('Factura enviada', 'success', 'top-right');

        return redirect()->route('creditNote.show', $creditNote);

    }

    public function viewPdf(CreditNote $creditNote)
    {

        if ($creditNote->bank_account != null) {
            $accounts = true;
        } else {
            $accounts = false;
        }

        $items = $creditNote->items()->get();
        $user = auth()->user();
        $sub_total = $creditNote->items()->sum('sub_total');
        $today = today()->format('m-d-y');
        $tax = $creditNote->items()->sum('tax');
        $total = $creditNote->items()->sum('total');
        $view = \View::make('users.creditNotes.pdf', compact('creditNote', 'items', 'user', 'sub_total', 'tax', 'total', 'today', 'accounts'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream();

        //  $pdf = PDF::loadView('users.budgets.pdf', $data);
        //  return $pdf->render();

        //return view('users.invoice.pdf', compact('invoice', 'items'));

    }

    public function configuration(Request $request, CreditNoteConfiguration $configuration)
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

        return redirect()->route('creditNote.edit', $request['credit_note_id']);
    }

}
