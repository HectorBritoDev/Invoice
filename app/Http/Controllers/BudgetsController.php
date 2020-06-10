<?php

namespace App\Http\Controllers;

use Alert;
use App\Budget;
use App\BudgetConfiguration;
use App\BudgetItem;
use App\Good;
use App\Mail\BudgetMail;
use App\Operation;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class BudgetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  dd(auth()->user()->budgets()->where('status', '<>','facturada')->get());
        $today = today()->format('y-m-d');

        auth()->user()->budgets()->where('status', null)->delete();
        auth()->user()->budgets()->where('status', '<>', 'facturada')->where('expiration_date', '<=', $today)->update(['status' => 'vencida']);
        $clients = auth()->user()->clients()->get();
        $budgets = auth()->user()->budgets()->get();
        $lastBudget = $budgets->last();
        return view('users.budgets.index', compact('budgets', 'clients', 'lastBudget'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // $budget = Budget::create(['user_id' => auth()->user()->id]);
        // return redirect()->route('budget.edit', $budget);

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
        $data = $this->validate($request,
            [
                'ruc' => 'sometimes|integer',
                'dni' => 'sometimes|integer',
                'client_name' => 'required|string|max:191',
                'client_email' => 'required|email',
                'client_main_adress' => 'required|string|max:191',
                'emission_date' => 'required|date',
                'condition' => 'required|integer',
                'coin' => 'required|string|max:191',

            ]);
        $budgets = auth()->user()->budgets()->get();

        $lastBudget = $budgets->last();
        if ($lastBudget != null) {

            $data['serie'] = $lastBudget->serie;
            $data['code'] = $lastBudget->code + 1;
        }
        $data['user_id'] = auth()->user()->id;
        $data['expiration_date'] = Carbon::parse($data['emission_date'])->addDay($data['condition'])->format('y-m-d');

        $budget = Budget::create($data);
        Operation::create([
            'user_id' => auth()->user()->id,
            'budget_id' => $budget->id,
            'emission_date' => $budget->emission_date,
            'expiration_date' => $budget->expiration_date,
            'type' => 'budget']);

        return redirect()->route('budget.edit', $budget);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function show(Budget $budget)
    {
        if ($budget->status == 'guardada' || $budget->status == null) {
            return redirect()->route('budget.edit', $budget);
        }
        $configuration = auth()->user()->budgetConfiguration;

        $items = BudgetItem::where('budget_id', $budget->id)->get();
        return view('users.budgets.show', compact('items', 'budget', 'configuration'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Budget $budget)
    {
        if (($request->has('beforeInvoice') && $budget->status == 'emitida') || ($request->has('beforeInvoice') && $budget->status == 'aprobada')) {
            $budgets = auth()->user()->budgets()->get();

            $goods = Good::where('user_id', auth()->user()->id)->get();
            $items = $budget->items()->get();
            return view('users.budgets.edit', compact('goods', 'items', 'budget', 'budgets'));

        }

        if ($budget->status == 'aprobada' || $budget->status == 'rechazada' || $budget->status == "emitida" || $budget->status == 'facturada') {
            //  dd('here');
            return redirect()->route('budget.show', $budget);
        } else {

            if (auth()->user()->budgetConfiguration == null) {
                $configuration = BudgetConfiguration::create(['user_id' => auth()->user()->id]);
            } else {
                $configuration = auth()->user()->budgetConfiguration;

            }

            $budgets = auth()->user()->budgets()->get();
            $goods = Good::where('user_id', auth()->user()->id)->get();
            $items = BudgetItem::where('budget_id', $budget->id)->get();
            return view('users.budgets.edit', compact('goods', 'items', 'budget', 'budgets', 'configuration'));
        }

        // if ($budget->created_at == $budget->updated_at) {
        // } else {
        //     return redirect()->route('budget.show', $budget);
        // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Budget $budget)
    {
        // dd($request->all());
        if ($request->has('save')) {
            $data['status'] = 'guardada';
            $budget->update($data);
            return redirect()->route('budget.edit', $budget);

        }
        if ($request->has('aproval')) {
            $data['status'] = 'aprobada';
            $budget->update($data);
            return redirect()->route('budget.edit', $budget);

        }
        if ($request->has('rejected')) {
            $data['status'] = 'rechazada';
            $budget->update($data);
            return redirect()->route('budget.edit', $budget);

        }

        $data = $this->validate($request, [
            'serie' => 'sometimes|required|string',
            'code' => 'sometimes|required|integer',
            'note' => 'sometimes|string',
            'detraction_account' => 'sometimes|string|max:191',
            'internal_message' => 'sometimes|string',
            'bank_account' => 'sometimes|string|max:191',
            'file' => 'sometimes|mimes:pdf',

        ]);
        if ($request->hasFile('file')) {
            # code...
            $file = $request->file('file');
            $name = time() . $file->getClientOriginalName();
            $file->move(public_path() . '/files/' . auth()->user()->id . '/budgets/', $name);
            $data['file'] = $name;
        }

        $budget->update($data);

        return redirect()->route('budget.edit', $budget);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Budget $budget)
    {

        $budget->delete();
        Alert::toast('Cotización eliminada', 'error', 'top-right');

        return redirect()->route('sale.index');
    }

    public function destroyItems(Budget $budget)
    {

        $budget->items()->delete();
        Alert::toast('Items eliminados', 'error', 'top-right');

        return redirect()->route('budget.edit', $budget);
    }

    public function copy(Request $request, Budget $budget)
    {
        //dd($request->all());

        $this->validate($request, [
            'oldBudget' => 'required|exists:budgets,id',
        ]);

        $oldBudget = Budget::find($request['oldBudget']);

        $budget->update([
            'note' => $oldBudget->note,
            'detraction_account' => $oldBudget->detraction_account,
            'internal_message' => $oldBudget->internal_message,
            'bank_account' => $oldBudget->bank_account,
            //'serie' => $oldBudget->serie,
            //'code' => $oldBudget->code + 1,

        ]);
        $budget->items()->delete();
        foreach ($oldBudget->items()->get() as $item) {
            BudgetItem::create([
                'budget_id' => $budget->id,
                'good_id' => $item->good_id,
                'name' => $item->name,
                'measure' => $item->measure,
                'reference' => $item->reference,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'discount' => $item->discount,
                'sub_total' => $item->sub_total,
                'tax' => $item->tax,
                'total' => $item->total,
                'igv_type' => $item->igv_type,

            ]);
        }
        Alert::toast('Copiado correctamente', 'success', 'top-right');

        return redirect()->route('budget.edit', $budget);
    }

    public function viewPdf(Request $request, Budget $budget)
    {

        if ($request->has('withBankAccount')) {
            $accounts = true;
        } else {
            $accounts = false;
        }

        $items = $budget->items()->get();
        $user = auth()->user();
        $sub_total = $budget->items()->sum('sub_total');
        $today = today()->format('m-d-y');
        $tax = $budget->items()->sum('tax');
        $total = $budget->items()->sum('total');
        $view = \View::make('users.budgets.pdf', compact('budget', 'items', 'user', 'sub_total', 'tax', 'total', 'today', 'accounts'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream();

        //  $pdf = PDF::loadView('users.budgets.pdf', $data);
        //  return $pdf->render();

        return view('users.budgets.pdf', compact('budget', 'items'));

    }

    public function mail(Request $request, Budget $budget)
    {
        //dd($request->has('withBankAccount'));
        if ($request->has('withBankAccount')) {
            $accounts = true;
        } else {
            $accounts = false;
        }

        // if ($budget->pdf == null) { pendiente por realizar comprobacion para saber si ya tiene cotizacion con y sin nro de cuenta

        $data = [
            'accounts' => $accounts,
            'budget' => $budget,
            'items' => $budget->items()->get(),
            'user' => auth()->user(),
            'sub_total' => $budget->items()->sum('sub_total'),
            'today' => today()->format('m-d-y'),
            'tax' => $budget->items()->sum('tax'),
            'total' => $budget->items()->sum('total'),
        ];

        $name = time() . $budget->serie . $budget->code . '.pdf';
        $pdf = PDF::loadView('users.budgets.pdf', $data)->save(public_path() . '/files/' . auth()->user()->id . '/' . $name);

        $budget->update(['pdf' => $name]);

        Mail::to($budget->client_email)->send(new BudgetMail($budget));
        Alert::toast('Cotización enviada', 'success', 'top-right');

        $budget->update(['status' => 'emitida']);
        return redirect()->route('budget.show', $budget);

        // $items = $budget->items()->get();
        // $user = auth()->user();
        // $sub_total = $budget->items()->sum('sub_total');
        // $today = today()->format('m-d-y');
        // $tax = $budget->items()->sum('tax');
        // $total = $budget->items()->sum('total');

        // $view = \View::make('users.budgets.pdf', compact('budget', 'items', 'user', 'sub_total', 'tax', 'total', 'today'))->render();
        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($view)->save(public_path() . '/files/' . auth()->user()->id . '/' . $name);

    }

    public function configuration(Request $request, BudgetConfiguration $configuration)
    {
        //dd($request->all());
        $this->validate($request, [

            'phone' => 'nullable|in:on',
            'email' => 'nullable|in:on',
            'web' => 'nullable|in:on',
            'user_description' => 'nullable|in:on',
            'seller' => 'nullable|in:on',
            'reference' => 'nullable|in:on',
            'price' => 'nullable|in:on',
            'client_message' => 'nullable|in:on',
            'internal_message' => 'nullable|in:on',
            'detraction_account' => 'nullable|in:on',
            'bank_account' => 'nullable|in:on',
        ]);
        // dd('here');
        if ($request['phone']) {
            $request['phone'] = 1;
        } else {
            $request['phone'] = 0;
        }
        if ($request['email']) {
            $request['email'] = 1;
        } else {
            $request['email'] = 0;
        }
        if ($request['web']) {
            $request['web'] = 1;
        } else {
            $request['web'] = 0;
        }
        if ($request['user_description']) {
            $request['user_description'] = 1;
        } else {
            $request['user_description'] = 0;
        }
        if ($request['seller']) {
            $request['seller'] = 1;
        } else {
            $request['seller'] = 0;
        }
        if ($request['reference']) {
            $request['reference'] = 1;
        } else {
            $request['reference'] = 0;
        }
        if ($request['price']) {
            $request['price'] = 1;
        } else {
            $request['price'] = 0;
        }
        if ($request['client_message']) {
            $request['client_message'] = 1;
        } else {
            $request['client_message'] = 0;
        }
        if ($request['internal_message']) {
            $request['internal_message'] = 1;
        } else {
            $request['internal_message'] = 0;
        }
        if ($request['detraction_account']) {
            $request['detraction_account'] = 1;
        } else {
            $request['detraction_account'] = 0;
        }
        if ($request['bank_account']) {
            $request['bank_account'] = 1;
        } else {
            $request['bank_account'] = 0;
        }
        // dd($configuration);
        $configuration->update($request->all());

        return redirect()->route('budget.edit', $request['budget_id']);
    }
}
