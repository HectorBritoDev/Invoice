<?php

namespace App\Http\Controllers;

use App\Good;
use App\GoodName;
use App\GoodPrice;
use App\GoodWarehouse;
use App\MeasureOption;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goods = Good::where('user_id', auth()->user()->id)->get();
        return view('users.goods.index', compact('goods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->has('good')) {
            $good = true;
        } else {
            $good = false;
        }
        $measure_options = MeasureOption::all();
        $categories = auth()->user()->categories->where('status', 1);
        return view('users.goods.create', compact('categories', 'good', 'measure_options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  dd($request->all());
        $data = $this->validate($request, [
            'category_id' => 'required|integer|exists:good_service_categories,id',
            'name' => 'required|string|min:1|max:191',
            'code' => 'required|string|min:1|max:191',
            'reference' => 'required|string|min:1|max:191',
            'other_name' => 'sometimes|nullable|string|min:1|max:191',
            'other_code' => 'sometimes|nullable|string|min:1|max:191',
            'other_reference' => 'sometimes|nullable|string|min:1|max:191',
            'measure' => 'required|string|min:1|max:191',
            // 'brand' => 'sometimes|nullable|string|min:1|max:191',
            // 'model' => 'sometimes|nullable|string|min:1|max:191',
            // 'serie' => 'sometimes|nullable|string|min:1|max:191',
            // 'badge' => 'sometimes|nullable|string|min:1|max:191',
            // 'color' => 'sometimes|nullable|string|min:1|max:191',
            // 'size' => 'sometimes|nullable|string|min:1|max:191',
            'wholesale_price' => 'required|regex:/^\d*(\.\d{2})?$/',
            'unit_price' => 'required|regex:/^\d*(\.\d{2})?$/',
            // 'tax' => 'required|integer|in:1,2,3',
            'warehouse_name' => 'sometimes|nullable|string|min:1|max:191',
            'warehouse_adress' => 'sometimes|nullable|string|min:1|max:191',

        ]);
        // dd($request->has('good'));
        if ($request->has('good')) {
            $type = 'good';
        } else {
            $type = 'service';
        }
        $measure_option = MeasureOption::where('code', $data['measure'])->first();

        if ($measure_option != null) {
            $data['measure'] = $measure_option->name;
        }

        //dd($request->has('good'));
        $good = Good::create([
            'type' => 'good',
            'user_id' => auth()->user()->id,
            'name' => $data['name'],
            'code' => $data['code'],
            'reference' => $data['reference'],
            'category_id' => $data['category_id'],
            'type' => $type,
            'measure' => $data['measure'],
        ]);

        if (!empty($data['other_name'])) {

            GoodName::create([
                'good_id' => $good->id,
                'other_name' => $data['other_name'],
                'other_code' => $data['other_code'],
                'other_reference' => $data['other_reference'],
            ]);
        }
        // GoodDetail::create([
        //     'good_id' => $good->id,
        //     'measure' => $data['measure'],
        //     'brand' => $data['brand'],
        //     'model' => $data['model'],
        //     'serie' => $data['serie'],
        //     'badge' => $data['badge'],
        //     'color' => $data['color'],
        //     'size' => $data['size'],
        // ]);
        GoodPrice::create([
            'good_id' => $good->id,
            'wholesale_price' => $data['wholesale_price'],
            'unit_price' => $data['unit_price'],
            //'tax' => $data['tax'],
        ]);
        if (!empty($data['warehouse_name']) && !empty($data['warehouse_adress'])) {

            GoodWarehouse::create([
                'good_id' => $good->id,
                'name' => $data['warehouse_name'],
                'adress' => $data['warehouse_adress'],
            ]);
        }

        return redirect()->route('good.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function show(Good $good)
    {
        return view('users.goods.show', compact('good'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function edit(Good $good)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Good $good)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function destroy(Good $good)
    {
        $good->delete();

        return redirect()->route('good.index');
    }
}
