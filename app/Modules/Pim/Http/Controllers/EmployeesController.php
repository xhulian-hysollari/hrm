<?php

namespace App\Modules\Pim\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Pim\Http\Requests\EmployeeRequest;
use App\Modules\Pim\Repositories\Interfaces\EmployeeRepositoryInterface as EmployeeRepository;
use App\Modules\Settings\Models\Forcontact;
use App\User;
use Datatables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Route;

class EmployeesController extends Controller
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
        return view('pim::employees.index');
    }

    /**
     * Display a list of the birthdays.
     *
     * @return array
     */
    public function birthdays(Request $request)
    {
        $items = $this->employeeRepository->getBirthdays($request->get('date'));
        return $items;
    }

    /**
     * Return data for the resource list
     *
     * @return \Illuminate\Http\Response
     */
    public function getDatatable()
    {
        return Datatables::of($this->employeeRepository->getCollection(
            [['key' => 'role', 'operator' => '=', 'value' => $this->employeeRepository->model::USER_ROLE_EMPLOYEE]],
            ['id', 'first_name', 'last_name', 'email']))
            ->addColumn('actions', function ($employee) {
                return view('includes._datatable_actions', [
                    'deleteUrl' => route('pim.employees.destroy', $employee->id),
                    'editUrl' => route('pim.employees.edit', $employee->id)
                ]);
            })
            ->make();
    }

    /**
     * Returns all employee details for using with select2
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getSelectJson(Request $request)
    {
        return $this->employeeRepository->getSelect2Data($request->get('q'), $request->get('page'));
    }

    /**
     * Returns the selected employee details for using with select2
     * @param  integer $id the primary key of the selected employee
     * @return \Illuminate\Http\Response
     */
    public function getSelect2Selection($id)
    {
        return $this->employeeRepository->getSelect2Selection($id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $structure = Forcontact::all()->pluck('company_name', 'id');
        $users = User::all()->pluck('first_name', 'id');
        return view('pim::employees.create', compact('structure', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Modules\Pim\Http\Requests\EmployeeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        $employeeData = $request->all();
        $employeeData['role'] = $this->employeeRepository->model::USER_ROLE_EMPLOYEE;
        $employeeData = $this->employeeRepository->create($employeeData);
        $this->sendPassword($employeeData->id);

        $request->session()->flash('success', trans('app.pim.employees.store_success'));
        return redirect()->route('pim.employees.edit', $employeeData->id);
    }

    public function resendPassword($id, Request $request)
    {
        $this->sendPassword($id);
        $request->session()->flash('success', trans('app.pim.employees.pass_success'));
        return redirect()->back();
    }

    private function sendPassword($id)
    {
        $password = rand();
        $employeeData = $this->employeeRepository->update($id, ['password' => bcrypt($password)]);
        $data['email'] = [
            'name' => $employeeData->first_name,
            'system' => config('app.name'),
            'url' => url('/'),
            'email' => $employeeData->email,
            'password' => $password,
            'change_pass_route' => url('password/reset'),
            'signature' => env('APP_NAME', 'HRM')
        ];
        Mail::send('emails.employee-login-password', $data, function ($message) use ($employeeData) {
            $message->subject(trans('emails.employee_login.subject', ['name' => config('app.name')]));
            $message->to($employeeData['email']);
        });
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
        $structure = Forcontact::all()->pluck('company_name', 'id');
        $users = User::all()->pluck('first_name', 'id');
        $employee = $this->employeeRepository->getById($id);
        if ($employee->role == $this->employeeRepository->model::USER_ROLE_CANDIDATE) {
            return redirect()->route('pim.candidates.edit', $id);
        }
        return view('pim::employees.edit', ['employee' => $employee, 'structure' => $structure, 'users' => $users, 'breadcrumb' => ['title' => $employee->first_name . ' ' . $employee->last_name, 'id' => $employee->id]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  integer  unique identifier for the resource
     * @param  \App\Modules\Pim\Http\Requests\EmployeeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, EmployeeRequest $request)
    {
        $employeeData = $this->employeeRepository->update($id, $request->all());
        $request->session()->flash('success', trans('app.pim.employees.update_success'));
        return redirect()->route('pim.employees.edit', $employeeData->id);
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
        $this->employeeRepository->delete($id);
        $request->session()->flash('success', trans('app.pim.employees.delete_success'));
        return redirect()->route('pim.employees.index');
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
    }

    public function uploadEmployees()
    {
        $file = Input::file('attachment');
        $data = [];
        $maxR = [];
        Excel::selectSheetsByIndex(0)->load($file, function ($reader) use (&$data, &$maxR) {
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);
            $maxR = $sheet->getHighestRow();
            $data = $this->parseEmployees($sheet, $maxR);
        });
        return redirect()->route('pim.employees.index');
    }

    protected function parseEmployees($reader, $maxRow)
    {
        $startRow = 2;
        $skills = [];
        do {
            if (
            trim($reader->getCell(sprintf('B%s', $startRow))->getValue() !== "")
            ) {
                $first_name = $reader->getCell(sprintf('C%s', $startRow))->getValue();
                $last_name = $reader->getCell(sprintf('E%s', $startRow))->getValue();
                $email = trim($reader->getCell(sprintf('M%s', $startRow))->getValue());
                $personalMail = (isset($email) && $email != "") ? $email : strtolower($first_name) . '.' . strtolower($last_name) . '@forcontact.com';
                $emailValue = trim(strtolower($first_name)) . '.' . trim(strtolower($last_name)) . '@forcontact.com';
                $parsedData = [
                    'first_name' => ucfirst(strtolower($first_name)),
                    'last_name' => ucfirst(strtolower($last_name)),
                    'father_name' => $reader->getCell(sprintf('D%s', $startRow))->getValue(),
                    'contact' => $reader->getCell(sprintf('L%s', $startRow))->getValue(),
                    'birth_date' => $reader->getCell(sprintf('F%s', $startRow))->getValue(),
                    'matricola' => $reader->getCell(sprintf('B%s', $startRow))->getValue(),
                    'birthplace' => $reader->getCell(sprintf('H%s', $startRow))->getValue(),
                    'id_card' => $reader->getCell(sprintf('G%s', $startRow))->getValue(),
                    'education_title' => $reader->getCell(sprintf('J%s', $startRow))->getValue(),
                    'address' => $reader->getCell(sprintf('I%s', $startRow))->getValue(),
                    'profession' => $reader->getCell(sprintf('K%s', $startRow))->getValue(),
                    'active' => 1,
                    'role' => 2,
                    'personal_email' => $personalMail,
                    'email' => $emailValue,
                ];
                $user = User::create($parsedData);
                $this->sendPassword($user->id);
                $startRow += 1;
            }
        } while ($startRow <= $maxRow);
    }

    protected function parse($reader, $maxRow)
    {
        $startRow = 2;
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
                    'father_name' => $reader->getCell(sprintf('B%s', $startRow))->getValue(),
//                    'comment' => $reader->getCell(sprintf('M%s', $startRow))->getValue(),
//                    'interview_1' => $reader->getCell(sprintf('J%s', $startRow))->getValue(),
//                    'interview_2' => $reader->getCell(sprintf('N%s', $startRow))->getValue(),
//                    'contact' => $reader->getCell(sprintf('L%s', $startRow))->getValue(),
//                    'language' => $reader->getCell(sprintf('K%s', $startRow))->getValue(),
//                    'contact' => Carbon::createFromFormat('d.m.Y', $reader->getCell(sprintf('F%s', $startRow))->getValue()), //-1 is added to fix the date shift by 1
                    'role' => '3',
                    'email' => uniqid() . '@gmail.com',
                ];
                $user = User::create($parsedData);
                if ($reader->getCell(sprintf('C%s', $startRow))->getValue() !== 'No') {
                    $skills[] = [
                        'user_id' => $user->id,
                        'skill' => 'Italian',
                        'evaluation' => $reader->getCell(sprintf('C%s', $startRow))->getValue(),
                    ];
                }
                if ($reader->getCell(sprintf('D%s', $startRow))->getValue() !== 'No') {
                    $skills[] = [
                        'user_id' => $user->id,
                        'skill' => 'English',
                        'evaluation' => $reader->getCell(sprintf('D%s', $startRow))->getValue(),
                    ];
                }
                if ($reader->getCell(sprintf('E%s', $startRow))->getValue() !== 'No') {
                    $skills[] = [
                        'user_id' => $user->id,
                        'skill' => 'German',
                        'evaluation' => $reader->getCell(sprintf('E%s', $startRow))->getValue(),
                    ];
                }
                if ($reader->getCell(sprintf('F%s', $startRow))->getValue() !== 'No') {
                    $skills[] = [
                        'user_id' => $user->id,
                        'skill' => 'Spanish',
                        'evaluation' => $reader->getCell(sprintf('F%s', $startRow))->getValue(),
                    ];
                }
                if ($reader->getCell(sprintf('G%s', $startRow))->getValue() !== 'No') {
                    $skills[] = [
                        'user_id' => $user->id,
                        'skill' => 'Turkish',
                        'evaluation' => $reader->getCell(sprintf('G%s', $startRow))->getValue(),
                    ];
                }
                if ($reader->getCell(sprintf('H%s', $startRow))->getValue() !== 'No') {
                    $skills[] = [
                        'user_id' => $user->id,
                        'skill' => 'French',
                        'evaluation' => $reader->getCell(sprintf('H%s', $startRow))->getValue(),
                    ];
                }
                if ($reader->getCell(sprintf('I%s', $startRow))->getValue() !== 'No') {
                    $skills[] = [
                        'user_id' => $user->id,
                        'skill' => 'Greek',
                        'evaluation' => $reader->getCell(sprintf('I%s', $startRow))->getValue(),
                    ];
                }
            }
            $startRow += 1;
        } while ($startRow <= $maxRow);
    }
}
