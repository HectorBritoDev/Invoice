<?php

namespace App\Http\Controllers;

use App\Sale;
use App\SaleConfiguration;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd(auth()->user()->creditNotes);
        //dd(auth()->user()->budgets()->where('status', '<>','facturada')->get());
        //MARCAR COMO EXPIRADAS LAS COTIZACIONES / SE PUEDE HACER CON OPERACIONES PERO VAMOS A CONFIRMAR PRIMERO
        $today = today()->format('y-m-d');
        auth()->user()->budgets()->where('status', null)->delete();
        auth()->user()->budgets()->where('expiration_date', '<=', $today)->where('status', '<>', 'facturada')->update(['status' => 'vencida']);
        auth()->user()->invoices()->where('status', null)->delete();
        auth()->user()->tickets()->where('status', null)->delete();
        auth()->user()->debitNotes()->where('status', null)->delete();
        auth()->user()->creditNotes()->where('status', null)->delete();
        auth()->user()->senderGuides()->where('status', null)->delete();

        if (auth()->user()->saleConfiguration == null) {
            $configuration = SaleConfiguration::create(['user_id' => auth()->user()->id]);
        } else {
            $configuration = auth()->user()->saleConfiguration;
        }
        if ($request->has('from_date') && $request->has('to_date') && $request->has('type')) {
            //dd($request->all());
            $from = $request['from_date'];
            $to = $request['to_date'];
            $type = $request['type'];
            //dd($type);
            if ($request['type'] == 'all') {
                $operations = auth()->user()->operations()->whereBetween('emission_date', [$from, $to])->orWhereBetween('expiration_date', [$from, $to])->get();
                // dd($operations);

            } else {
                $operations = auth()->user()->operations()->whereBetween('emission_date', [$from, $to])->orWhereBetween('expiration_date', [$from, $to])->get();
                $operations = $operations->where('type', $type);

            }
        } else {

            $operations = auth()->user()->operations;
        }
        $clients = auth()->user()->clients;

        return view('users.sales.index', compact('operations', 'configuration', 'clients'));

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
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }

    public function configuration(Request $request, SaleConfiguration $configuration)
    {
        //dd($request->all());
        $this->validate($request, [

            'emission_date' => 'nullable|in:on',
            'type' => 'nullable|in:on',
            'number' => 'nullable|in:on',
            'client' => 'nullable|in:on',
            'expiration_date' => 'nullable|in:on',
            'debt' => 'nullable|in:on',
            'invoiced' => 'nullable|in:on',
            'status' => 'nullable|in:on',
            'seller' => 'nullable|in:on',
            'unique_code' => 'nullable|in:on',
        ]);
        if ($request['emission_date']) {
            $request['emission_date'] = 1;
        } else {
            $request['emission_date'] = 0;
        }
        if ($request['type']) {
            $request['type'] = 1;
        } else {
            $request['type'] = 0;
        }
        if ($request['number']) {
            $request['number'] = 1;
        } else {
            $request['number'] = 0;
        }
        if ($request['client']) {
            $request['client'] = 1;
        } else {
            $request['client'] = 0;
        }
        if ($request['expiration_date']) {
            $request['expiration_date'] = 1;
        } else {
            $request['expiration_date'] = 0;
        }
        if ($request['debt']) {
            $request['debt'] = 1;
        } else {
            $request['debt'] = 0;
        }
        if ($request['invoiced']) {
            $request['invoiced'] = 1;
        } else {
            $request['invoiced'] = 0;
        }
        if ($request['status']) {
            $request['status'] = 1;
        } else {
            $request['status'] = 0;
        }
        if ($request['seller']) {
            $request['seller'] = 1;
        } else {
            $request['seller'] = 0;
        }
        if ($request['unique_code']) {
            $request['unique_code'] = 1;
        } else {
            $request['unique_code'] = 0;
        }

        $configuration->update($request->all());

        return redirect()->route('sale.index');
    }
}
