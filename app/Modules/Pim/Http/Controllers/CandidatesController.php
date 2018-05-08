<?php

namespace App\Modules\Pim\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Pim\Models\UserContactDetails;
use App\Modules\Pim\Models\UserSkill;
use App\Modules\Pim\Repositories\Interfaces\CandidateRepositoryInterface as CandidateRepository;
use App\Modules\Pim\Http\Requests\CandidateRequest;
use App\Modules\Settings\Models\Skill;
use App\User;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class CandidatesController extends Controller
{
    private $candidateRepository;

    public function __construct(CandidateRepository $candidateRepository)
    {
        $this->candidateRepository = $candidateRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pim::candidates.index');
    }

    /**
     * Return data for the resource list
     *
     * @return \Illuminate\Http\Response
     */
    public function getDatatable()
    {
        return Datatables::of($this->candidateRepository->getCollection(
            [['key' => 'role', 'operator' => '=', 'value' => $this->candidateRepository->model::USER_ROLE_CANDIDATE]],
            ['id', 'first_name', 'last_name', 'email']))
            ->addColumn('actions', function ($employee) {
                return view('includes._datatable_actions', [
                    'deleteUrl' => route('pim.candidates.destroy', $employee->id),
                    'editUrl' => route('pim.candidates.edit', $employee->id)
                ]);
            })
            ->make();
    }

    /**
     * Marks a candidate as featured for easier access
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function makeFeatured($id)
    {
        $candidate = $this->candidateRepository->getById($id);
        $featured = !$candidate->featured;
        $candidate->featured = $featured;
        $candidate->save();
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pim::candidates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Modules\Pim\Http\Requests\CandidateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CandidateRequest $request)
    {
        $employeeData = $request->all();
        $employeeData['role'] = $this->candidateRepository->model::USER_ROLE_CANDIDATE;
        $employeeData = $this->candidateRepository->create($employeeData);
        $request->session()->flash('success', trans('app.pim.candidates.store_success'));
        return redirect()->route('pim.candidates.edit', $employeeData->id);
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
        $employee = $this->candidateRepository->getById($id);
        if ($employee->role == $this->candidateRepository->model::USER_ROLE_EMPLOYEE) {
            return redirect()->route('pim.employees.edit', $id);
        }
        return view('pim::candidates.edit', ['employee' => $employee, 'breadcrumb' => ['title' => $employee->first_name . ' ' . $employee->last_name, 'id' => $employee->id]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  integer  unique identifier for the resource
     * @param  \App\Modules\Pim\Http\Requests\CandidateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, CandidateRequest $request)
    {
        $employeeData = $this->candidateRepository->update($id, $request->all());
        $request->session()->flash('success', trans('app.pim.candidates.update_success'));
        return redirect()->route('pim.candidates.edit', $employeeData->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  unique identifier for the resource
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $this->candidateRepository->delete($id);
        $request->session()->flash('success', trans('app.pim.candidates.delete_success'));
        return redirect()->route('pim.candidates.index');
    }

    public function uploadCandidates()
    {
        $file = Input::file('attachment');
        $data = [];
        $maxR = [];
        Excel::selectSheetsByIndex(1)->load($file, function ($reader) use (&$data, &$maxR) {
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(1);
            $maxR = $sheet->getHighestRow();
            $data = $this->parse($sheet, $maxR);
        });
        return redirect()->route('pim.candidates.index');
    }

    protected function parse($reader, $maxRow)
    {
        try {
            $startRow = 2;
            $parsedData = [];
            $skills = [];
            do {
                if (
                    trim($reader->getCell(sprintf('A%s', $startRow))->getValue()) &&
                    trim($reader->getCell(sprintf('B%s', $startRow))->getValue()) &&
                    trim($reader->getCell(sprintf('C%s', $startRow))->getValue()) &&
                    trim($reader->getCell(sprintf('D%s', $startRow))->getValue()) &&
                    trim($reader->getCell(sprintf('F%s', $startRow))->getValue())
                ) {
                    $parsedData = [
                        'first_name' => $reader->getCell(sprintf('A%s', $startRow))->getValue(),
                        'last_name' => $reader->getCell(sprintf('B%s', $startRow))->getValue(),
                        'notes' => $reader->getCell(sprintf('M%s', $startRow))->getValue(),
                        'interview_1' => $reader->getCell(sprintf('J%s', $startRow))->getValue(),
                        'interview_2' => $reader->getCell(sprintf('N%s', $startRow))->getValue(),
                        'language' => $reader->getCell(sprintf('K%s', $startRow))->getValue(),
                        'role' => '3',
                        'is_active' => '0',
                        'personal_email' => uniqid() . '@gmail.com',
                    ];
                    $user = User::updateOrCreate(['personal_email' => $parsedData['personal_email']], $parsedData);
                    $userContact = UserContactDetails::updateOrCreate([
                        'user_id' => $user->id], [
                        'phone1' => $reader->getCell(sprintf('L%s', $startRow))->getValue()
                    ]);
                    if ($reader->getCell(sprintf('C%s', $startRow))->getValue() !== 'No') {
                        $skill = Skill::firstOrCreate(['name' => $reader->getCell('C1')->getValue()]);
                        UserSkill::create([
                            'user_id' => $user->id,
                            'skill_id' => $skill->id,
                            'evaluation' => $reader->getCell(sprintf('C%s', $startRow))->getValue(),
                        ]);
                    }
                    if ($reader->getCell(sprintf('D%s', $startRow))->getValue() !== 'No') {
                        $skill = Skill::firstOrCreate(['name' => $reader->getCell('D1')->getValue()]);
                        UserSkill::create([
                            'user_id' => $user->id,
                            'skill_id' => $skill->id,
                            'evaluation' => $reader->getCell(sprintf('D%s', $startRow))->getValue(),
                        ]);
                    }
                    if ($reader->getCell(sprintf('E%s', $startRow))->getValue() !== 'No') {
                        $skill = Skill::firstOrCreate(['name' => $reader->getCell('E1')->getValue()]);
                        UserSkill::create([
                            'user_id' => $user->id,
                            'skill_id' => $skill->id,
                            'evaluation' => $reader->getCell(sprintf('E%s', $startRow))->getValue(),
                        ]);
                    }
                    if ($reader->getCell(sprintf('F%s', $startRow))->getValue() !== 'No') {
                        $skill = Skill::firstOrCreate(['name' => $reader->getCell('F1')->getValue()]);
                        UserSkill::create([
                            'user_id' => $user->id,
                            'skill_id' => $skill->id,
                            'evaluation' => $reader->getCell(sprintf('F%s', $startRow))->getValue(),
                        ]);
                    }
                    if ($reader->getCell(sprintf('G%s', $startRow))->getValue() !== 'No') {
                        $skill = Skill::firstOrCreate(['name' => $reader->getCell('G1')->getValue()]);
                        UserSkill::create([
                            'user_id' => $user->id,
                            'skill_id' => $skill->id,
                            'evaluation' => $reader->getCell(sprintf('G%s', $startRow))->getValue(),
                        ]);
                    }
                    if ($reader->getCell(sprintf('H%s', $startRow))->getValue() !== 'No') {
                        $skill = Skill::firstOrCreate(['name' => $reader->getCell('H1')->getValue()]);
                        UserSkill::create([
                            'user_id' => $user->id,
                            'skill_id' => $skill->id,
                            'evaluation' => $reader->getCell(sprintf('H%s', $startRow))->getValue(),
                        ]);
                    }
                    if ($reader->getCell(sprintf('I%s', $startRow))->getValue() !== 'No') {
                        $skill = Skill::firstOrCreate(['name' => $reader->getCell('I1')->getValue()]);
                        UserSkill::create([
                            'user_id' => $user->id,
                            'skill_id' => $skill->id,
                            'evaluation' => $reader->getCell(sprintf('I%s', $startRow))->getValue(),
                        ]);
                    }
                }
                $startRow += 1;
            } while ($startRow <= $maxRow);
            return true;
        } catch (\Exception $exception) {
            print_r($exception);
//            return redirect()->back();
        }
    }
}