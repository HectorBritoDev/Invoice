<?php

namespace App\Http\Controllers;

use Alert;
use App\Budget;
use App\Good;
use App\Invoice;
use App\InvoiceConfiguration;
use App\InvoiceItem;
use App\Mail\InvoiceMail;
use App\Operation;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = today()->format('y-m-d');

        auth()->user()->invoices()->where('expiration_date', '<=', $today)->update(['status' => 'vencida']);
        auth()->user()->invoices()->where('status', null)->delete();

        $clients = auth()->user()->clients()->get();
        $invoices = auth()->user()->invoices()->get();
        $lastInvoice = $invoices->last();
        return view('users.invoices.index', compact('invoices', 'clients', 'lastInvoice'));

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
        //dd($request->all());
        $data = $this->validate($request,
            [
                'ruc' => 'sometimes|integer',
                'dni' => 'sometimes|integer',
                'client_name' => 'required|string|max:191',
                'client_email' => 'required|email',
                'client_main_adress' => 'required|string|max:191',
                'emission_date' => 'required|date',
                'condition' => 'required|integer',
                'coin' => 'required|string|max:191',

            ]);
        $invoices = auth()->user()->invoices()->get();

        $data['user_id'] = auth()->user()->id;
        $lastInvoice = $invoices->last();
        if ($lastInvoice != null) {
            # code...
            $data['serie'] = $lastInvoice->serie;
            $data['code'] = $lastInvoice->code + 1;
        }
        $data['expiration_date'] = Carbon::parse($data['emission_date'])->addDay($data['condition'])->format('y-m-d');

        $invoice = Invoice::create($data);
        Operation::create([
            'user_id' => auth()->user()->id,
            'invoice_id' => $invoice->id,
            'emission_date' => $invoice->emission_date,
            'expiration_date' => $invoice->expiration_date,
            'type' => 'invoice']);

        return redirect()->route('invoice.edit', $invoice);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        if ($invoice->status == null || $invoice->status == 'guardada') {
            return redirect()->route('invoice.edit', $invoice);
        }
        $items = $invoice->items()->get();
        $configuration = auth()->user()->invoiceConfiguration;
        return view('users.invoices.show', compact('invoice', 'items', 'configuration'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {

        if ($invoice->status == 'facturada' || $invoice->status == 'vencida') {
            return redirect()->route('invoice.show', $invoice);
        } else {

            if (auth()->user()->invoiceConfiguration == null) {
                $configuration = InvoiceConfiguration::create(['user_id' => auth()->user()->id]);
            } else {
                $configuration = auth()->user()->invoiceConfiguration;

            }

            $budgets = auth()->user()->budgets()->get();
            $invoices = auth()->user()->invoices()->get();
            $goods = Good::where('user_id', auth()->user()->id)->get();
            $items = InvoiceItem::where('invoice_id', $invoice->id)->get();
            return view('users.invoices.edit', compact('goods', 'items', 'invoice', 'invoices', 'budgets', 'configuration'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {

        if ($request->has('save')) {
            $data['status'] = 'guardada';
            $invoice->update($data);
            return redirect()->route('invoice.edit', $invoice);

        }
        if ($request->has('close')) {
            $data['status'] = 'facturada';

            $invoice->update($data);
            if ($invoice->budget_id != null) {

                $budget = Budget::find($invoice->budget_id);
                //dd($budget);
                if ($budget != null) {
                    $budget->update(['status' => 'facturada']);
                }
            }
            return redirect()->route('invoice.edit', $invoice);

        }
        if ($request->has('aproval')) {
            $data['status'] = 'aprobada';
            $invoice->update($data);
            return redirect()->route('invoice.edit', $invoice);

        }
        if ($request->has('rejected')) {
            $data['status'] = 'rechazada';
            $invoice->update($data);
            return redirect()->route('invoice.edit', $invoice);

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
            $file->move(public_path() . '/files/' . auth()->user()->id . '/invoices/', $name);
            $data['file'] = $name;
        }

        $invoice->update($data);

        return redirect()->route('invoice.edit', $invoice);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        Alert::toast('Factura eliminada', 'error', 'top-right');

        return redirect()->route('sale.index');

    }

    public function destroyItems(Invoice $invoice)
    {

        $invoice->items()->delete();
        Alert::toast('Items eliminados', 'error', 'top-right');

        return redirect()->route('invoice.edit', $invoice);
    }

    public function fromBudget(Request $request)
    {
        // dd('here');

        $data = $this->validate($request, [
            'budget_id' => 'required|integer|exists:budgets,id',
        ]);
        $budget = Budget::find($data['budget_id']);
        $invoices = auth()->user()->invoices()->get();

        if ($invoices->last() != null) {
            $lastInvoice = $invoices->last();
        } else {
            $lastInvoice = $budget;
        }

        if ($request->has('withBankAccounts')) {
            $invoice = Invoice::create([
                'user_id' => auth()->user()->id,
                'ruc' => $budget->ruc,
                'dni' => $budget->dni,
                'passport' => $budget->passport,
                'code' => $lastInvoice->code + 1,
                'serie' => $lastInvoice->serie,
                'sunat_resolution' => $budget->sunat_resolution,
                'client_name' => $budget->client_name,
                'client_main_adress' => $budget->client_main_adress,
                'client_phone' => $budget->client_phone,
                'client_email' => $budget->client_email,
                'emission_date' => $budget->emission_date,
                'condition' => $budget->condition,
                'expiration_date' => $budget->expiration_date,
                'coin' => $budget->coin,
                'budget_id' => $budget->id,
                'bank_account' => $budget->bank_account,
                // 'total' => $budget->items()->sum('total'),
                // 'sub_total' => $budget->items()->sum('sub_total'),
                // 'tax' => $budget->items()->sum('tax'),
            ]);
        } else {

            $invoice = Invoice::create([
                'user_id' => auth()->user()->id,
                'ruc' => $budget->ruc,
                'dni' => $budget->dni,
                'passport' => $budget->passport,
                'code' => $lastInvoice->code + 1,
                'serie' => $lastInvoice->serie,
                'sunat_resolution' => $budget->sunat_resolution,
                'client_name' => $budget->client_name,
                'client_main_adress' => $budget->client_main_adress,
                'client_phone' => $budget->client_phone,
                'client_email' => $budget->client_email,
                'emission_date' => $budget->emission_date,
                'condition' => $budget->condition,
                'expiration_date' => $budget->expiration_date,
                'coin' => $budget->coin,
                'budget_id' => $budget->id,
                // 'total' => $budget->items()->sum('total'),
                // 'sub_total' => $budget->items()->sum('sub_total'),
                // 'tax' => $budget->items()->sum('tax'),
            ]);
        }

        foreach ($budget->items()->get() as $item) {
            InvoiceItem::create([
                'good_id' => $item->good_id,
                'invoice_id' => $invoice->id,
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
        //  $budget->update(['status' => $data['status']]);
        // $data['status'] = 'Facturado';
        // $budget->update($data);
        Operation::create([
            'user_id' => auth()->user()->id,
            'invoice_id' => $invoice->id,
            'emission_date' => $invoice->emission_date,
            'expiration_date' => $invoice->expiration_date,
            'type' => 'invoice',
        ]);
        return redirect()->route('invoice.edit', $invoice);

    }

    public function copy(Request $request, Invoice $invoice)
    {
        //  dd($request->all());

        $this->validate($request, [
            'budget_id' => 'required|exists:budgets,id',
        ]);

        $budget = Budget::find($request['budget_id']);

        $invoice->update([
            'note' => $budget->note,
            'detraction_account' => $budget->detraction_account,
            'internal_message' => $budget->internal_message,
            'bank_account' => $budget->bank_account,

        ]);

        $invoice->items()->delete();
        foreach ($budget->items()->get() as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
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

        Alert::toast('Cotización copiada', 'success', 'top-right');

        return redirect()->route('invoice.edit', $invoice);
    }
    public function viewPdf(Invoice $invoice)
    {

        if ($invoice->bank_account != null) {
            $accounts = true;
        } else {
            $accounts = false;
        }

        $items = $invoice->items()->get();
        $user = auth()->user();
        $sub_total = $invoice->items()->sum('sub_total');
        $today = today()->format('m-d-y');
        $tax = $invoice->items()->sum('tax');
        $total = $invoice->items()->sum('total');
        $view = \View::make('users.invoices.pdf', compact('invoice', 'items', 'user', 'sub_total', 'tax', 'total', 'today', 'accounts'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream();

        //  $pdf = PDF::loadView('users.budgets.pdf', $data);
        //  return $pdf->render();

        //return view('users.invoice.pdf', compact('invoice', 'items'));

    }

    public function mail(Invoice $invoice)
    {
        // dd('mail');
        if ($invoice->bank_account != null) {
            $accounts = true;
        } else {
            $accounts = false;
        }

        // if ($budget->pdf == null) { pendiente por realizar comprobacion para saber si ya tiene cotizacion con y sin nro de cuenta

        $data = [
            'accounts' => $accounts,
            'invoice' => $invoice,
            'items' => $invoice->items()->get(),
            'user' => auth()->user(),
            'sub_total' => $invoice->items()->sum('sub_total'),
            'today' => today()->format('m-d-y'),
            'tax' => $invoice->items()->sum('tax'),
            'total' => $invoice->items()->sum('total'),

        ];

        $name = time() . $invoice->serie . $invoice->code . '.pdf';
        $pdf = PDF::loadView('users.invoices.pdf', $data)->save(public_path() . '/files/' . auth()->user()->id . '/' . $name);

        $invoice->update(['pdf' => $name]);

        // if ($request['debtMail']) {
        //     Mail::to;
        // }
        Mail::to($invoice->client_email)->send(new invoiceMail($invoice));
        Alert::toast('Factura enviada', 'success', 'top-right');

        return redirect()->route('invoice.show', $invoice);

    }

    public function configuration(Request $request, InvoiceConfiguration $configuration)
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

        return redirect()->route('invoice.edit', $request['invoice_id']);
    }
}
