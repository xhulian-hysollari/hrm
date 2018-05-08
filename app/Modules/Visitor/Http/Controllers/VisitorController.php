<?php

namespace App\Modules\Visitor\Http\Controllers;

use App\Modules\Visitor\Http\Requests\VisitorRequest;
use App\Modules\Visitor\Repositories\Interfaces\VisitorRepositoryInterface as VisitorRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VisitorController extends Controller
{

    /**
     * @var VisitorRepository
     */
    private $visitorRepository;

    public function __construct(VisitorRepository $visitorRepository)
    {
        $this->visitorRepository = $visitorRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('visitor::visitor.index');
    }

    /**
     * Returns data for the resource list
     *
     * @return \Illuminate\Http\Response
     */
    public function getDatatable()
    {
        return Datatables::of($this->visitorRepository->getQry([], ['id', 'name']))
            ->addColumn('actions', function($client){
                return view('includes._datatable_actions', [
                    'deleteUrl' => route('visitor.destroy', $client->id),
                    'editUrl' => route('visitor.edit', $client->id)
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
        return view('visitor::visitor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Modules\Settings\Http\Requests\ClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VisitorRequest $request)
    {
        $visitorData = $this->visitorRepository->create($request->all());
        $request->session()->flash('success', trans('app.visitor.store_success'));
        return redirect()->route('visitor.edit', $visitorData->id);
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
        $visitor = $this->visitorRepository->getById($id);
        return view('visitor::visitor.edit', ['visitor' => $visitor, 'breadcrumb' => ['title' => $visitor->name, 'id' => $visitor->id]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  integer  unique identifier for the resource
     * @param  \App\Modules\Settings\Http\Requests\ClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, VisitorRequest $request)
    {
        $visitorData = $this->visitorRepository->update($id, $request->all());
        $request->session()->flash('success', trans('app.visitor.update_success'));
        return redirect()->route('visitor.edit', $visitorData->id);
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
        $this->visitorRepository->delete($id);
        $request->session()->flash('success', trans('app.visitor.delete_success'));
        return redirect()->route('visitor.index');
    }
}
