<?php

namespace App\Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Settings\Http\Requests\ForcontactRequest;
use App\Modules\Settings\Models\Forcontact;
use App\Modules\Settings\Repositories\Interfaces\ForcontactRepositoryInterface as CompanyRepository;
use App\Modules\Settings\Http\Requests\CompanyRequest;
use Illuminate\Http\Request;
use Datatables;

class ForcontactController extends Controller
{
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('settings::forcontact.index');
    }

    /**
     * Returns data for the resource list
     * 
     * @return \Illuminate\Http\Response
     */
    public function getDatatable()
    {
        return Datatables::of($this->companyRepository->getQry([], ['id', 'company_name', 'parent_id']))
            ->editColumn('parent_id', function($company) {
                if($company->parent_id){
                    return Forcontact::where('id', $company->parent_id)->first()->company_name;
                }else{
                    return "";
                }
            })
            ->addColumn('actions', function($company){
                return view('includes._datatable_actions', [
                    'deleteUrl' => route('settings.forcontact.destroy', $company->id),
                    'editUrl' => route('settings.forcontact.edit', $company->id)
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

        $forcontact = Forcontact::all()->pluck('company_name', 'id');
        return view('settings::forcontact.create', compact('forcontact'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Modules\Settings\Http\Requests\CompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ForcontactRequest $request)
    {
        $companyData = $this->companyRepository->create($request->all());
        $request->session()->flash('success', trans('app.settings.forcontact.store_success'));
        return redirect()->route('settings.forcontact.edit', $companyData->id);
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $forcontact = Forcontact::all()->pluck('company_name', 'id');
        $company = $this->companyRepository->getById($id);
        return view('settings::forcontact.edit', ['company' => $company, 'forcontact' => $forcontact, 'breadcrumb' => ['title' => $company->name, 'id' => $company->id]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  integer  unique identifier for the resource
     * @param  \App\Modules\Settings\Http\Requests\CompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, CompanyRequest $request)
    {
        $companyData = $this->companyRepository->update($id, $request->all());
        $request->session()->flash('success', trans('app.settings.forcontact.update_success'));
        return redirect()->route('settings.forcontact.edit', $companyData->id);
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
        $this->companyRepository->delete($id);
        $request->session()->flash('success', trans('app.settings.forcontact.delete_success'));
        return redirect()->route('settings.forcontact.index');
    }
}