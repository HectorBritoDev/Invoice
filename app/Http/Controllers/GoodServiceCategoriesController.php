<?php

namespace App\Http\Controllers;

use App\GoodServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoodServiceCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = GoodServiceCategory::where('user_id', Auth::user()->id)->orderBy('name', 'ASC')->get();
        return view('users.goods.categories.index', compact('categories'));
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
     * @param  \App\GoodServiceCategory  $goodServiceCategory
     * @return \Illuminate\Http\Response
     */
    public function show(GoodServiceCategory $goodServiceCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GoodServiceCategory  $goodServiceCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(GoodServiceCategory $goodServiceCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GoodServiceCategory  $goodServiceCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoodServiceCategory $goodServiceCategory)
    {
        $this->validate($request, [
            'good' => 'sometimes|integer|in:0,1',
            'service' => 'sometimes|integer|in:0,1',
            'status' => 'sometimes|integer|in:0,1',
        ]);
        //dd($request->all());

        if ($request['good'] == 1) {
            $goodServiceCategory->update($request->all());
            return redirect()->route('goodServiceCategory.index');
        } elseif ($request['good'] == 0) {
            $goodServiceCategory->update($request->all());
            return redirect()->route('goodServiceCategory.index');
        }
        if ($request['service'] == 1) {
            $goodServiceCategory->update($request->all());
            return redirect()->route('goodServiceCategory.index');
        } elseif ($request['service'] == 0) {
            $goodServiceCategory->update($request->all());
            return redirect()->route('goodServiceCategory.index');
        }
        if ($request['status'] == 1) {
            $goodServiceCategory->update($request->all());
            return redirect()->route('goodServiceCategory.index');
        } elseif ($request['status'] == 0) {
            $goodServiceCategory->update($request->all());
            return redirect()->route('goodServiceCategory.index');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GoodServiceCategory  $goodServiceCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoodServiceCategory $goodServiceCategory)
    {
        //
    }
}
