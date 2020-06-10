<?php

namespace App\Http\Controllers;

use App\GoodServiceSubCategory;
use Illuminate\Http\Request;

class GoodServiceSubCategoriesController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GoodServiceSubCategory  $goodServiceSubCategory
     * @return \Illuminate\Http\Response
     */
    public function show(GoodServiceSubCategory $goodServiceSubCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GoodServiceSubCategory  $goodServiceSubCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(GoodServiceSubCategory $goodServiceSubCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GoodServiceSubCategory  $goodServiceSubCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoodServiceSubCategory $goodServiceSubCategory)
    {
        $this->validate($request, [
            'good' => 'sometimes|integer|in:0,1',
        ]);

        if ($request['good'] != null) {
            //dd($request->all());
            $goodServiceSubCategory->update($request->all());
            return redirect()->route('goodServiceCategory.index');
        }
        if ($request['status'] != null) {
            //dd($request->all());
            $goodServiceSubCategory->update($request->all());
            return redirect()->route('goodServiceCategory.index');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GoodServiceSubCategory  $goodServiceSubCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoodServiceSubCategory $goodServiceSubCategory)
    {
        //
    }
}
