<?php

namespace App\Http\Controllers;

use App\Good;
use App\GoodName;
use Illuminate\Http\Request;

class GoodNamesController extends Controller
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
                'other_name' => 'required|string|min:1|max:191',
                'other_code' => 'required|string|min:1|max:191',
                'other_reference' => 'required|string|min:1|max:191',
            ]);

            GoodName::create($request->all());

            return redirect()->route('good.show', $request['good_id']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GoodName  $goodName
     * @return \Illuminate\Http\Response
     */
    public function show(GoodName $goodName)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GoodName  $goodName
     * @return \Illuminate\Http\Response
     */
    public function edit(GoodName $name)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GoodName  $goodName
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoodName $goodName)
    {

        if (\Gate::allows('isUser') && Good::find($request['good_id'])->user->id == auth()->user()->id) {
            $this->validate($request, [
                'good_id' => 'required|integer|exists:goods,id',
                'other_name' => 'required|string|min:1|max:191',
                'other_code' => 'required|string|min:1|max:191',
                'other_reference' => 'required|string|min:1|max:191',
            ]);
            $goodName->update($request->all());

            return redirect()->route('good.show', $request['good_id']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GoodName  $goodName
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoodName $goodName)
    {
        if (\Gate::allows('isUser') && Good::find($goodName->good_id)->user->id == auth()->user()->id) {

            $goodName->delete();
            return redirect()->route('good.show', $goodName->good_id);
        }
    }
}
