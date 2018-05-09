<?php

namespace App\Modules\Employee\Training\Http\Controllers;

use App\Modules\Employee\Training\Models\Training;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Pim\Repositories\Interfaces\EmployeeRepositoryInterface as EmployeeRepository;
use Datatables;
use App\Modules\Dashboard\Repositories\Interfaces\DashboardDocumentsRepositoryInterface as DashboardDocumentsRepository;
use Illuminate\Support\Facades\DB;


class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EmployeeRepository $employeeRepository)
    {
        $users = $employeeRepository->pluckName();
        return view('employee.training::index', compact('users'));
    }

    /**
     * Returns data for the resource list
     *
     * @return \Illuminate\Http\Response
     */
    public function getDatatable()
    {
        return Datatables::of(Training::all())
            ->addColumn('actions', function ($training) {
                return view('includes._datatable_actions', [
                    'deleteUrl' => route('admin.training.destroy', $training->id),
                    'editUrl' => route('admin.training.edit', $training->id),
                    'downloadUrl' => route('admin.training.download', $training->attachment)
                ]);
            })
            ->make();
    }

    public function download($attachment)
    {
        return response()->download(base_path('storage/app/' . $attachment));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(EmployeeRepository $employeeRepository)
    {
        $users = $employeeRepository->pluckName();
        return view('employee.training::create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attachment = "";
        if ($request->hasFile('attachment')) {
            $attachment = $request->attachment->store('uploads/documents');
        }
        $training = new Training();
        $training->name = $request->name;
        $training->attachment = $attachment;
        $training->location = $request->location;
        $training->training_date = $request->training_date;
        $training->notes = $request->notes;
        $training->save();

//        dd($request->all());
        foreach ($request->users as $user) {
            DB::table('user_trainings')->insert(
                ['user_id' => $user, 'training_id' => $training->id]);
        }
        return redirect()->route('admin.training.edit', $training->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('employee.training::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, EmployeeRepository $employeeRepository)
    {
        $training = Training::findOrFail($id);
        $users = $employeeRepository->pluckName();
        return view('employee.training::edit', ['training' => $training, 'users' => $users, 'breadcrumb' => ['title' => $training->name, 'id' => $training->id]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
