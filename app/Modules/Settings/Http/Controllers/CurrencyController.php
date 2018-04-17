<?php

namespace App\Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Settings\Http\Requests\CurrencyRequest;
use App\Modules\Settings\Repositories\Interfaces\CurrencyRepositoryInterface as CurrencyRepository;
use Illuminate\Http\Request;
use Datatables;

class CurrencyController extends Controller
{
    /**
     * @var CurrencyRepository
     */
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Modules\Settings\Repositories\Interfaces\ContractTypeRepositoryInterface  $contractTypeRepository
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('settings::currency.index');
    }

    /**
     * Returns data for the resource list
     * 
     * @return \Illuminate\Http\Response
     */
    public function getDatatable()
    {
        return Datatables::of($this->currencyRepository->getCollection([], ['id', 'currency_code', 'currency_display']))
            ->addColumn('actions', function($currency){
                return view('includes._datatable_actions', [
                    'deleteUrl' => route('settings.currency.destroy', $currency->id),
                    'editUrl' => route('settings.currency.edit', $currency->id)
                ]);
            })
            ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings::currency.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CurrencyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurrencyRequest $request)
    {
        $currencyData = $this->currencyRepository->create($request->all());
        $request->session()->flash('success', trans('app.settings.currency.store_success'));
        return redirect()->route('settings.currency.edit', $currencyData->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer  unique identifier for the resource
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer  unique identifier for the resource
     * @param  \App\Modules\Settings\Repositories\Interfaces\ContractTypeRepositoryInterface  $contractTypeRepository
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $currency = $this->currencyRepository->getById($id);
        return view('settings::currency.edit', ['currency' => $currency, 'breadcrumb' => ['title' => $currency->currency_display, 'id' => $currency->id]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  integer  unique identifier for the resource
     * @param CurrencyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, CurrencyRequest $request)
    {
        $this->currencyRepository->update($id, $request->all());
        $request->session()->flash('success', trans('app.settings.currency.update_success'));
        return redirect()->route('settings.currency.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  unique identifier for the resource
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $this->currencyRepository->delete($id);
        $request->session()->flash('success', trans('app.settings.currency.delete_success'));
        return redirect()->route('settings.currency.index');
    }
}