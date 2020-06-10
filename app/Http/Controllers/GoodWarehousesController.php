<?php

namespace App\Http\Controllers;

use App\Good;
use App\GoodWarehouse;
use Illuminate\Http\Request;

class GoodWarehousesController extends Controller
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
                'name' => 'required|string|min:1|max:191',
                'adress' => 'required|string|min:1|max:191',
            ]);
            GoodWarehouse::create($request->all());
            return redirect()->route('good.show', $request['good_id']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GoodWarehouse  $goodWarehouse
     * @return \Illuminate\Http\Response
     */
    public function show(GoodWarehouse $goodWarehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GoodWarehouse  $goodWarehouse
     * @return \Illuminate\Http\Response
     */
    public function edit(GoodWarehouse $goodWarehouse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GoodWarehouse  $goodWarehouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoodWarehouse $goodWarehouse)
    {
        if (\Gate::allows('isUser') && Good::find($request['good_id'])->user->id == auth()->user()->id) {
            $this->validate($request, [
                'good_id' => 'required|integer|exists:goods,id',
                'name' => 'required|string|min:1|max:191',
                'adress' => 'required|string|min:1|max:191',
            ]);
            $goodWarehouse->update($request->all());
            return redirect()->route('good.show', $request['good_id']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GoodWarehouse  $goodWarehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoodWarehouse $goodWarehouse)
    {
        if (\Gate::allows('isUser') && Good::find($goodWarehouse->good_id)->user->id == auth()->user()->id) {
            $goodWarehouse->delete();
            return redirect()->route('good.show', $goodWarehouse->good_id);
        }

    }
}
