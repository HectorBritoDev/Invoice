<?php

namespace App\Http\Controllers;

use App\DebitNoteItem;
use App\Good;
use App\GoodDetail;
use Illuminate\Http\Request;

class DebitNoteItemsController extends Controller
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
            'debit_note_id' => 'required|exists:debit_notes,id',
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
        DebitNoteItem::create([
            'good_id' => $good->id,
            'debit_note_id' => $request['debit_note_id'],
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
        return redirect()->route('debitNote.edit', $request['debit_note_id']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DebitNoteItem  $debitNoteItem
     * @return \Illuminate\Http\Response
     */
    public function show(DebitNoteItem $debitNoteItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DebitNoteItem  $debitNoteItem
     * @return \Illuminate\Http\Response
     */
    public function edit(DebitNoteItem $debitNoteItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DebitNoteItem  $debitNoteItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DebitNoteItem $debitNoteItem)
    {
        //dd('here');
        $this->validate($request, [
            'option' => 'required|string',
            'detail' => 'required|string',
        ]);
        $detail = GoodDetail::find($request['detail']);

        $name = $debitNoteItem->name . ', ' . $detail->name . ': ' . $request['option'];
//dd($name);
        $debitNoteItem->update(['name' => $name]);

        return redirect()->route('debitNote.edit', $debitNoteItem->debitNote->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DebitNoteItem  $debitNoteItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(DebitNoteItem $debitNoteItem)
    {
        $debitNoteItem->delete();
        return redirect()->route('debitNote.edit', $debitNoteItem->debit_note_id);

    }
}
