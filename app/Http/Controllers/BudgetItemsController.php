<?php

namespace App\Http\Controllers;

use App\BudgetItem;
use App\Good;
use App\GoodDetail;
use Illuminate\Http\Request;

class BudgetItemsController extends Controller
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
        //dd($request->all());
        $data = $this->validate($request, [
            'budget_id' => 'required|exists:budgets,id',
            'good_id' => 'required|exists:goods,id',
            // 'measure' => 'required|string|max:191',
            // 'brand' => 'nullable|string|max:191',
            // 'model' => 'nullable|string|max:191',
            // 'serie' => 'nullable|string|max:191',
            // 'badge' => 'nullable|string|max:191',
            // 'color' => 'nullable|string|max:191',
            // 'size' => 'nullable|string|max:191',
            'quantity' => 'required|integer',
            'price' => 'required|regex:/^\d*(\.\d{2})?$/',
            'tax' => 'required|regex:/^\d*(\.\d{2})?$/',
            'total' => 'required|regex:/^\d*(\.\d{2})?$/',
            'sub_total' => 'required|regex:/^\d*(\.\d{2})?$/',
            'discount' => 'nullable|integer',
            'igv_type' => 'required|in:1,2,3',
        ]);

        //dd($request->all());
        $good = Good::find($data['good_id']);

        BudgetItem::create([
            'good_id' => $good->id,
            'budget_id' => $data['budget_id'],
            'name' => $good->name,
            'measure' => $good->measure,
            'reference' => $good->reference,
            'quantity' => $data['quantity'],
            'price' => $data['price'],
            'discount' => $data['discount'],
            'sub_total' => $data['sub_total'],
            'tax' => $data['tax'],
            'total' => $data['total'],
            'igv_type' => $data['igv_type'],
        ]);

        if ($request->has('beforeInvoice')) {
            return redirect('/budget/' . $data['budget_id'] . '/edit?beforeInvoice');

        }
        return redirect()->route('budget.edit', $data['budget_id']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BudgetItem  $budgetItem
     * @return \Illuminate\Http\Response
     */
    public function show(BudgetItem $budgetItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BudgetItem  $budgetItem
     * @return \Illuminate\Http\Response
     */
    public function edit(BudgetItem $budgetItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BudgetItem  $budgetItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BudgetItem $budgetItem)
    {
        $this->validate($request, [
            'option' => 'required|string',
            'detail' => 'required|string',
        ]);

        $detail = GoodDetail::find($request['detail']);

        $name = $budgetItem->name . ', ' . $detail->name . ': ' . $request['option'];
//dd($name);
        $budgetItem->update(['name' => $name]);

        return redirect()->route('budget.edit', $budgetItem->budget->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BudgetItem  $budgetItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(BudgetItem $budgetItem)
    {
        $budgetItem->delete();
        return redirect()->route('budget.edit', $budgetItem->budget_id);
    }
}
