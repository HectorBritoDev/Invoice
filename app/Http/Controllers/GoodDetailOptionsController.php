<?php

namespace App\Http\Controllers;

use App\GoodDetail;
use App\GoodDetailOption;
use Illuminate\Http\Request;

class GoodDetailOptionsController extends Controller
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
        // dd($request->all());

        $data = $this->validate($request, [
            'good_detail_id' => 'required|exists:good_details,id',
            'name' => 'required|string',
        ]);

        $options = (explode(",", $data['name']));
        //dd($options[1]);
        for ($i = 0; $i < count($options); $i++) {
            GoodDetailOption::create([
                'good_detail_id' => $request['good_detail_id'],
                'name' => $options[$i],
            ]);

        }
        $detail = GoodDetail::find($request['good_detail_id']);
        // GoodDetailOption::create($data);

        return redirect()->route('good.show', $detail->good->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GoodDetailOption  $goodDetailOption
     * @return \Illuminate\Http\Response
     */
    public function show(GoodDetailOption $goodDetailOption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GoodDetailOption  $goodDetailOption
     * @return \Illuminate\Http\Response
     */
    public function edit(GoodDetailOption $goodDetailOption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GoodDetailOption  $goodDetailOption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoodDetailOption $goodDetailOption)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GoodDetailOption  $goodDetailOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoodDetailOption $goodDetailOption)
    {
        //dd($goodDetailOption->detail);
        $good = $goodDetailOption->detail->good->id;
        $goodDetailOption->delete();

        return redirect()->route('good.show', $good);
    }
}
