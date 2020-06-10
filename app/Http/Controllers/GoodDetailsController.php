<?php

namespace App\Http\Controllers;

use App\Good;
use App\GoodDetail;
use App\GoodDetailOption;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoodDetailsController extends Controller
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
                'name' => 'required|string|max:191',
                // 'measure' => 'required|string|min:1|max:191',
                // 'brand' => 'required|string|min:1|max:191',
                // 'model' => 'required|string|min:1|max:191',
                // 'serie' => 'required|string|min:1|max:191',
                // 'badge' => 'required|string|min:1|max:191',
                // 'color' => 'required|string|min:1|max:191',
                // 'size' => 'required|string|min:1|max:191',
            ]);

            GoodDetail::create($request->all());
            return redirect()->route('good.show', $request['good_id']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GoodDetail  $goodDetail
     * @return \Illuminate\Http\Response
     */
    public function show(GoodDetail $goodDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GoodDetail  $goodDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(GoodDetail $goodDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GoodDetail  $goodDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoodDetail $goodDetail)
    {

        if (\Gate::allows('isUser') && Good::find($request['good_id'])->user->id == auth()->user()->id) {
            $this->validate($request, [
                'good_id' => 'required|integer|exists:goods,id',
                // 'measure' => 'required|string|min:1|max:191',
                // 'brand' => 'required|string|min:1|max:191',
                // 'model' => 'required|string|min:1|max:191',
                // 'serie' => 'required|string|min:1|max:191',
                // 'badge' => 'required|string|min:1|max:191',
                // 'color' => 'required|string|min:1|max:191',
                // 'size' => 'required|string|min:1|max:191',
            ]);

            $goodDetail->update($request->all());
            return redirect()->route('good.show', $request['good_id']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GoodDetail  $goodDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoodDetail $goodDetail)
    {

        $goodDetail->delete();

        return redirect()->route('good.show', $goodDetail->good_id);
    }

    public function options(Request $request)
    {
        // dd($request->all());
        $options = GoodDetailOption::where('good_detail_id', $request['id'])->get();

        return json_decode($options);
    }
}
