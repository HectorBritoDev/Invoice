<?php

namespace App\Http\Controllers;

use App\Good;
use App\GoodDetail;
use App\SenderGuideItem;
use Illuminate\Http\Request;

class SenderGuideItemsController extends Controller
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
            'sender_guide_id' => 'required|exists:sender_guides,id',
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
        SenderGuideItem::create([
            'good_id' => $good->id,
            'sender_guide_id' => $request['sender_guide_id'],
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
        return redirect()->route('senderGuide.edit', $request['sender_guide_id']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SenderGuideItem  $senderGuideItem
     * @return \Illuminate\Http\Response
     */
    public function show(SenderGuideItem $senderGuideItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SenderGuideItem  $senderGuideItem
     * @return \Illuminate\Http\Response
     */
    public function edit(SenderGuideItem $senderGuideItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SenderGuideItem  $senderGuideItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SenderGuideItem $senderGuideItem)
    {
        $this->validate($request, [
            'option' => 'required|string',
            'detail' => 'required|string',
        ]);
        $detail = GoodDetail::find($request['detail']);

        $name = $senderGuideItem->name . ', ' . $detail->name . ': ' . $request['option'];
//dd($name);
        $senderGuideItem->update(['name' => $name]);

        return redirect()->route('senderGuide.edit', $senderGuideItem->senderGuide->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SenderGuideItem  $senderGuideItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(SenderGuideItem $senderGuideItem)
    {
        $senderGuideItem->delete();
        return redirect()->route('senderGuide.edit', $senderGuideItem->sender_guide_id);

    }
}
