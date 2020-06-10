<?php

namespace App\Http\Controllers;

use Alert;
use App\Budget;
use App\Good;
use App\Mail\TicketMail;
use App\Operation;
use App\Ticket;
use App\TicketConfiguration;
use App\TicketItem;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class TicketsController extends Controller
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
        $tickets = auth()->user()->tickets()->get();

        $data['user_id'] = auth()->user()->id;
        $lastTicket = $tickets->last();
        if ($lastTicket != null) {
            # code...
            $data['serie'] = $lastTicket->serie;
            $data['code'] = $lastTicket->code + 1;
        }
        $data['expiration_date'] = Carbon::parse($data['emission_date'])->addDay($data['condition'])->format('y-m-d');

        $ticket = Ticket::create($data);
        Operation::create([
            'user_id' => auth()->user()->id,
            'ticket_id' => $ticket->id,
            'emission_date' => $ticket->emission_date,
            'expiration_date' => $ticket->expiration_date,
            'type' => 'ticket']);

        return redirect()->route('ticket.edit', $ticket);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        if ($ticket->status == null || $ticket->status == 'guardada') {
            return redirect()->route('ticket.edit', $ticket);
        }

        $items = $ticket->items()->get();
        $configuration = auth()->user()->ticketConfiguration;
        return view('users.tickets.show', compact('ticket', 'items', 'configuration'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {

        if ($ticket->status == 'facturada' || $ticket->status == 'vencida') {
            return redirect()->route('ticket.show', $ticket);
        } else {

            if (auth()->user()->ticketConfiguration == null) {
                $configuration = TicketConfiguration::create(['user_id' => auth()->user()->id]);
            } else {
                $configuration = auth()->user()->ticketConfiguration;
            }
            //  dd($configuration = auth()->user()->ticketConfiguration);
            $budgets = auth()->user()->budgets()->get();
            $tickets = auth()->user()->tickets()->get();

            $goods = Good::where('user_id', auth()->user()->id)->get();
            $items = TicketItem::where('ticket_id', $ticket->id)->get();
            // dd('here');
            return view('users.tickets.edit', compact('goods', 'items', 'ticket', 'budgets', 'tickets', 'configuration'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        if ($request->has('save')) {
            $data['status'] = 'guardada';
            $ticket->update($data);
            return redirect()->route('ticket.edit', $ticket);

        }
        if ($request->has('close')) {
            $data['status'] = 'facturada';

            $ticket->update($data);
            if ($ticket->budget_id != null) {

                $budget = Budget::find($ticket->budget_id);
                //dd($budget);
                if ($budget != null) {
                    $budget->update(['status' => 'facturada']);
                }
            }
            return redirect()->route('ticket.edit', $ticket);

        }
        if ($request->has('aproval')) {
            $data['status'] = 'aprobada';
            $ticket->update($data);
            return redirect()->route('ticket.edit', $ticket);

        }
        if ($request->has('rejected')) {
            $data['status'] = 'rechazada';
            $ticket->update($data);
            return redirect()->route('ticket.edit', $ticket);

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
            $file->move(public_path() . '/files/' . auth()->user()->id . '/tickets/', $name);
            $data['file'] = $name;
        }

        $ticket->update($data);

        return redirect()->route('ticket.edit', $ticket);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        Alert::toast('Factura eliminada', 'error', 'top-right');

        return redirect()->route('sale.index');

    }
    public function destroyItems(Ticket $ticket)
    {

        $ticket->items()->delete();
        Alert::toast('Items eliminados', 'error', 'top-right');

        return redirect()->route('ticket.edit', $ticket);
    }

    public function fromBudget(Request $request)
    {
        // dd('here');

        $data = $this->validate($request, [
            'budget_id' => 'required|integer|exists:budgets,id',
        ]);
        $budget = Budget::find($data['budget_id']);
        $tickets = auth()->user()->tickets()->get();

        if ($tickets->last() != null) {
            $lastTicket = $tickets->last();
        } else {
            $lastTicket = $budget;
        }

        if ($request->has('withBankAccounts')) {
            $ticket = Ticket::create([
                'user_id' => auth()->user()->id,
                'ruc' => $budget->ruc,
                'dni' => $budget->dni,
                'passport' => $budget->passport,
                'code' => $lastTicket->code + 1,
                'serie' => $lastTicket->serie,
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

            $ticket = Ticket::create([
                'user_id' => auth()->user()->id,
                'ruc' => $budget->ruc,
                'dni' => $budget->dni,
                'passport' => $budget->passport,
                'code' => $lastTicket->code + 1,
                'serie' => $lastTicket->serie,
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
            TicketItem::create([
                'good_id' => $item->good_id,
                'ticket_id' => $ticket->id,
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
            'ticket_id' => $ticket->id,
            'emission_date' => $ticket->emission_date,
            'expiration_date' => $ticket->expiration_date,
            'type' => 'ticket',
        ]);
        return redirect()->route('ticket.edit', $ticket);

    }

    public function copy(Request $request, Ticket $ticket)
    {
        //  dd($request->all());

        $this->validate($request, [
            'budget_id' => 'required|exists:budgets,id',
        ]);

        $budget = Budget::find($request['budget_id']);

        $ticket->update([
            'note' => $budget->note,
            'detraction_account' => $budget->detraction_account,
            'internal_message' => $budget->internal_message,
            'bank_account' => $budget->bank_account,

        ]);

        $ticket->items()->delete();

        foreach ($budget->items()->get() as $item) {
            TicketItem::create([
                'ticket_id' => $ticket->id,
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

        return redirect()->route('ticket.edit', $ticket);
    }

    public function viewPdf(Ticket $ticket)
    {

        if ($ticket->bank_account != null) {
            $accounts = true;
        } else {
            $accounts = false;
        }

        $items = $ticket->items()->get();
        $user = auth()->user();
        $sub_total = $ticket->items()->sum('sub_total');
        $today = today()->format('m-d-y');
        $tax = $ticket->items()->sum('tax');
        $total = $ticket->items()->sum('total');
        $view = \View::make('users.tickets.pdf', compact('ticket', 'items', 'user', 'sub_total', 'tax', 'total', 'today', 'accounts'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream();

        //  $pdf = PDF::loadView('users.budgets.pdf', $data);
        //  return $pdf->render();

        //return view('users.invoice.pdf', compact('invoice', 'items'));

    }

    public function mail(Ticket $ticket)
    {
        // dd('mail');
        if ($ticket->bank_account != null) {
            $accounts = true;
        } else {
            $accounts = false;
        }

        // if ($budget->pdf == null) { pendiente por realizar comprobacion para saber si ya tiene cotizacion con y sin nro de cuenta

        $data = [
            'accounts' => $accounts,
            'ticket' => $ticket,
            'items' => $ticket->items()->get(),
            'user' => auth()->user(),
            'sub_total' => $ticket->items()->sum('sub_total'),
            'today' => today()->format('m-d-y'),
            'tax' => $ticket->items()->sum('tax'),
            'total' => $ticket->items()->sum('total'),

        ];

        $name = time() . $ticket->serie . $ticket->code . '.pdf';
        $pdf = PDF::loadView('users.tickets.pdf', $data)->save(public_path() . '/files/' . auth()->user()->id . '/' . $name);

        $ticket->update(['pdf' => $name]);

        // if ($request['debtMail']) {
        //     Mail::to;
        // }
        Mail::to($ticket->client_email)->send(new TicketMail($ticket));
        Alert::toast('Factura enviada', 'success', 'top-right');

        return redirect()->route('ticket.show', $ticket);

    }

    public function configuration(Request $request, TicketConfiguration $configuration)
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

        return redirect()->route('ticket.edit', $request['ticket_id']);
    }

}
