<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Pim\Repositories\Interfaces\EmployeeRepositoryInterface as EmployeeRepository;
use Illuminate\Support\Facades\Auth;
use Datatables;

class ScheduleController extends Controller
{
    private $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('schedule.index');
    }

    public function getDatatable()
    {
        return Datatables::of($this->employeeRepository->getCollection([[
            'key' => 'supervisor',
            'operator' => '=',
            'value' => Auth::user()->id
        ]], ['id','first_name', 'last_name']))
            ->addColumn('full_name', function($row){
                return $row->first_name. ' ' .$row->last_name;
            })
            ->addColumn('time_monday', function($row){
                return '<div style="display:flex; align-items:center; margin-left:-0.75rem"> <input class="form-control time start-frame-child" style="width:70px; border:none" name="start_time_monday[]" id="start_time_monday'.$row->id.'" />-<input style="width:70px; border:none" class="form-control time end-frame-child" name="end_time_monday[]" id="end_time_monday'.$row->id.'" /></div>';
            })
            ->addColumn('time_tuesday', function($row){
                return '<div style="display:flex; align-items:center; margin-left:-0.75rem"> <input class="form-control time start-frame-child" style="width:70px; border:none" name="start_time_tuesday[]" id="start_time_tuesday'.$row->id.'" />-<input style="width:70px; border:none" class="form-control time end-frame-child" name="end_time_tuesday[]" id="end_time_tuesday'.$row->id.'" /></div>';
            })
            ->addColumn('time_wednesday', function($row){
                return '<div style="display:flex; align-items:center; margin-left:-0.75rem"> <input class="form-control time start-frame-child" style="width:70px; border:none" name="start_time_wednesday[]" id="start_time_wednesday'.$row->id.'" />-<input style="width:70px; border:none" class="form-control time end-frame-child" name="end_time_wednesday[]" id="end_time_wednesday'.$row->id.'" /></div>';
            })
            ->addColumn('time_thursday', function($row){
                return '<div style="display:flex; align-items:center; margin-left:-0.75rem"> <input class="form-control time start-frame-child" style="width:70px; border:none" name="start_time_thursday[]" id="start_time_thursday'.$row->id.'" />-<input style="width:70px; border:none" class="form-control time end-frame-child" name="end_time_thursday[]" id="end_time_thursday'.$row->id.'" /></div>';
            })
            ->addColumn('time_friday', function($row){
                return '<div style="display:flex; align-items:center; margin-left:-0.75rem"> <input class="form-control time start-frame-child" style="width:70px; border:none" name="start_time_friday[]" id="start_time_friday'.$row->id.'" />-<input style="width:70px; border:none" class="form-control time end-frame-child" name="end_time_friday[]" id="end_time_friday'.$row->id.'" /></div>';
            })
            ->addColumn('time_saturday', function($row){
                return '<div style="display:flex; align-items:center; margin-left:-0.75rem"> <input class="form-control time start-frame-child" style="width:70px; border:none" name="start_time_saturday[]" id="start_time_saturday'.$row->id.'" />-<input style="width:70px; border:none" class="form-control time end-frame-child" name="end_time_saturday[]" id="end_time_saturday'.$row->id.'" /></div>';
            })
            ->addColumn('time_sunday', function($row){
                return '<div style="display:flex; align-items:center; margin-left:-0.75rem"> <input class="form-control time start-frame-child" style="width:70px; border:none" name="start_time_sunday[]" id="start_time_sunday'.$row->id.'" />-<input style="width:70px; border:none" class="form-control time end-frame-child" name="end_time_sunday[]" id="end_time_sunday'.$row->id.'" /></div>';
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
