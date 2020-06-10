<?php

namespace App\Http\Controllers;

use App\Good;
use App\GoodPrice;
use Illuminate\Http\Request;

class GoodPricesController extends Controller
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
        if (\Gate::allows('isUser') && Good::find($request['good_id'])->user->id == auth()->user()->id) {

            $this->validate($request, [
                'good_id' => 'required|integer|exists:goods,id',
                'wholesale_price' => 'required|regex:/^\d*(\.\d{2})?$/',
                'unit_price' => 'required|regex:/^\d*(\.\d{2})?$/',
                'tax' => 'required|integer|in:1,2,3',
            ]);

            GoodPrice::create($request->all());
            return redirect()->route('good.show', $request['good_id']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GoodPrice  $goodPrice
     * @return \Illuminate\Http\Response
     */
    public function show(GoodPrice $goodPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GoodPrice  $goodPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(GoodPrice $goodPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GoodPrice  $goodPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoodPrice $goodPrice)
    {
        if (\Gate::allows('isUser') && Good::find($request['good_id'])->user->id == auth()->user()->id) {

            $this->validate($request, [
                'good_id' => 'required|integer|exists:goods,id',
                'wholesale_price' => 'required|regex:/^\d*(\.\d{2})?$/',
                'unit_price' => 'required|regex:/^\d*(\.\d{2})?$/',
                'tax' => 'required|integer|in:1,2,3',
            ]);

            $goodPrice->update($request->all());
            return redirect()->route('good.show', $request['good_id']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GoodPrice  $goodPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoodPrice $goodPrice)
    {
        $goodPrice->delete();

        return redirect()->route('good.show', $goodPrice->good_id);
    }
}
