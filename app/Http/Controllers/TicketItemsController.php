<?php

namespace App\Http\Controllers;

use App\Good;
use App\GoodDetail;
use App\TicketItem;
use Illuminate\Http\Request;

class TicketItemsController extends Controller
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
            'ticket_id' => 'required|exists:tickets,id',
            'good_id' => 'required|exists:goods,id',
            // 'measure' => 'sometimes|string|max:191',
            // 'brand' => 'sometimes|string|max:191',
            // 'model' => 'sometimes|string|max:191',
            // 'color' => 'sometimes|string|max:191',
            // 'quantity' => 'required|integer',
            'price' => 'required|regex:/^\d*(\.\d{2})?$/',
            'tax' => 'required|regex:/^\d*(\.\d{2})?$/',
            'total' => 'required|regex:/^\d*(\.\d{2})?$/',
            'sub_total' => 'required|regex:/^\d*(\.\d{2})?$/',
            'discount' => 'nullable|integer',
            'igv_type' => 'required|integer|in:1,2,3',
        ]);

        $good = Good::find($request['good_id']);
        TicketItem::create([
            'good_id' => $good->id,
            'ticket_id' => $request['ticket_id'],
            'name' => $good->name,
            'measure' => $good->measure,
            'reference' => $good->reference,
            'quantity' => $request['quantity'],
            'price' => $request['price'],
            'discount' => $request['discount'],
            'sub_total' => $request['sub_total'],
            'tax' => $request['tax'],
            'total' => $request['total'],
            'igv_type' => $request['igv_type'],
        ]);
        return redirect()->route('ticket.edit', $request['ticket_id']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TicketItem  $ticketItem
     * @return \Illuminate\Http\Response
     */
    public function show(TicketItem $ticketItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TicketItem  $ticketItem
     * @return \Illuminate\Http\Response
     */
    public function edit(TicketItem $ticketItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TicketItem  $ticketItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TicketItem $ticketItem)
    {
        $this->validate($request, [
            'option' => 'required|string',
            'detail' => 'required|string',
        ]);
        $detail = GoodDetail::find($request['detail']);

        $name = $ticketItem->name . ', ' . $detail->name . ': ' . $request['option'];
//dd($name);
        $ticketItem->update(['name' => $name]);

        return redirect()->route('ticket.edit', $ticketItem->ticket->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TicketItem  $ticketItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(TicketItem $ticketItem)
    {
        $ticketItem->delete();
        return redirect()->route('ticket.edit', $ticketItem->ticket_id);

    }
}
