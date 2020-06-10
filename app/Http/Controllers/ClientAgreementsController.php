<?php

namespace App\Http\Controllers;

use App\ClientAgreement;
use App\ConditionOption;
use App\PayOption;
use Illuminate\Http\Request;

class ClientAgreementsController extends Controller
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

    public function store(Request $request)
    {
        //dd($request->all());
        $data = $this->validate($request, [
            'client_id' => 'required|integer|exists:clients,id',
            'conditions' => 'sometimes|required|integer',
            'credit_line' => 'sometimes|required|integer',
            'pay_method' => 'sometimes|required|string',
        ]);
        $pay_option = PayOption::where('code', $data['pay_method'])->first();
        $condition = ConditionOption::where('code', $data['conditions'])->first();

        // dd($condition);
        if ($pay_option != null) {
            $data['pay_method'] = $pay_option->name;
        }
        if ($condition != null) {
            $data['conditions'] = $condition->name;
        }

        ClientAgreement::create($data);

        return redirect()->route('client.edit', $request['client_id']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $data = $this->validate($request, [

            'client_id' => 'required|integer|exists:clients,id',
            'conditions' => 'sometimes|required|integer',
            'credit_line' => 'sometimes|required|integer',
            'pay_method' => 'sometimes|required|string',

        ]);
        $pay_option = PayOption::where('code', $data['pay_method'])->first();
        $condition = ConditionOption::where('code', $data['conditions'])->first();

// dd($condition);
        if ($pay_option != null) {
            $data['pay_method'] = $pay_option->name;
        }
        if ($condition != null) {
            $data['conditions'] = $condition->name;
        }

        $agreement = ClientAgreement::findOrFail($id);
        $agreement->update($data);

        return redirect()->route('client.edit', $agreement->client_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agreement = ClientAgreement::findOrFail($id);
        $agreement->delete();

        return redirect()->route('client.edit', $agreement->client_id);
    }
}
