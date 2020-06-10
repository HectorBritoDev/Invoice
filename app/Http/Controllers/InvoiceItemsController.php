<?php

namespace App\Http\Controllers;

use App\Good;
use App\GoodDetail;
use App\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceItemsController extends Controller
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

        $this->validate($request, [
            'invoice_id' => 'required|exists:invoices,id',
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
        InvoiceItem::create([
            'good_id' => $good->id,
            'invoice_id' => $request['invoice_id'],
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
        return redirect()->route('invoice.edit', $request['invoice_id']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InvoiceItem  $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceItem $invoiceItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InvoiceItem  $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceItem $invoiceItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InvoiceItem  $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceItem $invoiceItem)
    {
        $this->validate($request, [
            'option' => 'required|string',
            'detail' => 'required|string',
        ]);
        $detail = GoodDetail::find($request['detail']);

        $name = $invoiceItem->name . ', ' . $detail->name . ': ' . $request['option'];
        //dd($name);
        $invoiceItem->update(['name' => $name]);

        return redirect()->route('invoice.edit', $invoiceItem->invoice->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InvoiceItem  $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceItem $invoiceItem)
    {
        $invoiceItem->delete();
        return redirect()->route('invoice.edit', $invoiceItem->invoice_id);

    }

}
