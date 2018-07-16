<?php

namespace App\Modules\Pim\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Pim\Models\CurrentSalary;
use App\Modules\Pim\Models\SalarySalaryComponent;
use App\Modules\Pim\Repositories\Interfaces\EmployeeRepositoryInterface as EmployeeRepository;
use App\Modules\Pim\Repositories\Interfaces\EmployeeSalaryRepositoryInterface as EmployeeSalaryRepository;
use App\Modules\Settings\Models\ContractType;
use App\Modules\Settings\Models\Currency;
use App\Modules\Settings\Models\SalaryComponent;
use App\Modules\Settings\Repositories\Interfaces\SalaryComponentsRepositoryInterface as SalaryComponentsRepository;
use App\Modules\Pim\Repositories\Interfaces\SalariesSalaryComponentsRepositoryInterface as SalariesSalaryComponentsRepository;
use App\Modules\Pim\Http\Requests\EmployeeSalaryRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeSalaryController extends Controller
{
    private $employeeRepository;
    private $employeeSalaryRepository;

    public function __construct(
        EmployeeRepository $employeeRepository,
        EmployeeSalaryRepository $employeeSalaryRepository
    )
    {
        $this->employeeRepository = $employeeRepository;
        $this->employeeSalaryRepository = $employeeSalaryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  integer  unique identifier for the related employee resource
     * @return \Illuminate\Http\Response
     */
    public function index($employeeId)
    {
        $employee = $this->employeeRepository->getById($employeeId);
        $currentSalary = $this->employeeSalaryRepository->getCurrentSalary($employeeId);
        $currencies = $this->employeeSalaryRepository->getCurrencies();
        $types = $this->employeeSalaryRepository->getSalaryTypes();
        $breadcrumb = [
            'parent_id' => $employeeId,
            'parent_title' => $employee->first_name . ' ' . $employee->last_name
        ];
        return view('pim::employee_salaries.index', compact('breadcrumb', 'currentSalary', 'currencies', 'types'));
    }

    /**
     * Returns data for the resource list
     *
     * @param  integer  unique identifier for the related employee resource
     * @return \Illuminate\Http\Response
     */
    public function getDatatable($employeeId)
    {
        return Datatables::of($this->employeeSalaryRepository->getQry([[
            'key' => 'user_id',
            'operator' => '=',
            'value' => $employeeId
        ]], ['id', 'gross_total', 'nett_total', 'payment_date', 'user_id']))
            ->addColumn('actions', function ($record) {
                return view('includes._datatable_actions', [
                    'deleteUrl' => route('pim.employees.salaries.destroy', [$record->user_id, $record->id]),
                    'editUrl' => route('pim.employees.salaries.edit', [$record->user_id, $record->id])
                ]);
            })
            ->removeColumn('user_id')
            ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  integer  unique identifier for the related employee resource
     * @param  \App\Modules\Settings\Repositories\Interfaces\SalaryComponentsRepositoryInterface $salaryComponentsRepository
     * @return \Illuminate\Http\Response
     */
    public function create($employeeId, SalaryComponentsRepository $salaryComponentsRepository)
    {
        $employee = $this->employeeRepository->getById($employeeId);
        $breadcrumb = [
            'parent_id' => $employeeId,
            'parent_title' => $employee->first_name . ' ' . $employee->last_name
        ];
        $salaryComponents = $salaryComponentsRepository->getAllOrdered('type', 'asc');
        return view('pim::employee_salaries.create', compact('breadcrumb', 'salaryComponents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  integer  unique identifier for the related employee resource
     * @param  \App\Modules\Pim\Http\Requests\EmployeeSalaryRequest $request
     * @param  \App\Modules\Pim\Repositories\Interfaces\SalariesSalaryComponentsRepositoryInterface $salariesSalaryComponentsRepository
     * @param  \App\Modules\Settings\Repositories\Interfaces\SalaryComponentsRepositoryInterface $salaryComponentsRepository
     * @return \Illuminate\Http\Response
     */
    public function store($employeeId,
                          EmployeeSalaryRequest $request,
                          SalariesSalaryComponentsRepository $salariesSalaryComponentsRepository,
                          SalaryComponentsRepository $salaryComponentsRepository)
    {
        // TODO: custom validation

        $salaryData = ['payment_date' => $request->input('payment_date'), 'user_id' => $employeeId];
        if ($request->hasFile('attachment')) {
            $path = $request->attachment->store('uploads/salaries');
            $salaryData['attachment'] = $path;
        }
        $salaryData = $this->employeeSalaryRepository->create($salaryData);

        $components = $request->input('components');
        $total = $expense = 0;
        if ($components) {
            foreach ($components as $key => $value) {
                $component = $salaryComponentsRepository->getById($key);
                if ($component->type == $salaryComponentsRepository->model::TYPE_EARNING) {
                    $total += $value;
                } else {
                    $expense += $value;
                }
                $salariesSalaryComponentsRepository->create([
                    'value' => $value,
                    'salary_component_id' => $key,
                    'salary_id' => $salaryData->id
                ]);
            }
        }

        $this->employeeSalaryRepository->update($salaryData->id, ['gross_total' => $total, 'nett_total' => $total - $expense]);

        $request->session()->flash('success', trans('app.pim.employees.salaries.store_success'));
        return redirect()->route('pim.employees.salaries.edit', [$employeeId, $salaryData->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer  unique identifier for the related employee resource
     * @param  integer  unique identifier for the resource
     * @return \Illuminate\Http\Response
     */
    public function show($employeeId, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer  unique identifier for the related employee resource
     * @param  integer  unique identifier for the resource
     * @param  \App\Modules\Pim\Repositories\Interfaces\SalariesSalaryComponentsRepositoryInterface $salariesSalaryComponentsRepository
     * @param  \App\Modules\Settings\Repositories\Interfaces\SalaryComponentsRepositoryInterface $salaryComponentsRepository
     * @return \Illuminate\Http\Response
     */
    public function edit($employeeId, $id,
                         SalariesSalaryComponentsRepository $salariesSalaryComponentsRepository,
                         SalaryComponentsRepository $salaryComponentsRepository)
    {
        $employee = $this->employeeRepository->getById($employeeId);
        $salaryComponents = $salaryComponentsRepository->getAllOrdered('type', 'asc');
        $salary = $this->employeeSalaryRepository->getById($id);
        $salary->components = $salary->components->pluck('value', 'salary_component_id');
        $breadcrumb = [
            'parent_id' => $employee->id,
            'parent_title' => $employee->first_name . ' ' . $employee->last_name,
            'id' => $salary->id,
            'title' => '#' . $salary->id
        ];
        return view('pim::employee_salaries.edit', compact('salary', 'breadcrumb', 'salaryComponents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  integer  unique identifier for the related employee resource
     * @param  integer  unique identifier for the resource
     * @param  \App\Modules\Pim\Http\Requests\EmployeeSalaryRequest $request
     * @param  \App\Modules\Pim\Repositories\Interfaces\SalariesSalaryComponentsRepositoryInterface $salariesSalaryComponentsRepository
     * @param  \App\Modules\Settings\Repositories\Interfaces\SalaryComponentsRepositoryInterface $salaryComponentsRepository
     * @return \Illuminate\Http\Response
     */
    public function update($employeeId, $id,
                           EmployeeSalaryRequest $request,
                           SalariesSalaryComponentsRepository $salariesSalaryComponentsRepository,
                           SalaryComponentsRepository $salaryComponentsRepository)
    {
        $components = $request->input('components');
        $total = $expense = 0;
        $salariesSalaryComponentsRepository->deleteByColumn('salary_id', $id);
        foreach ($components as $key => $value) {
            $component = $salaryComponentsRepository->getById($key);
            if ($component->type == $salaryComponentsRepository->model::TYPE_EARNING) {
                $total += $value;
            } else {
                $expense += $value;
            }
            $salariesSalaryComponentsRepository->create([
                'value' => $value,
                'salary_component_id' => $key,
                'salary_id' => $id
            ]);
        }
        $salaryData = ['gross_total' => $total, 'nett_total' => $total - $expense, 'payment_date' => $request->input('payment_date')];
        if ($request->hasFile('attachment')) {
            $path = $request->attachment->store('uploads/salaries');
            $salaryData['attachment'] = $path;
        }
        $this->employeeSalaryRepository->update($id, $salaryData);
        $request->session()->flash('success', trans('app.pim.employees.salaries.update_success'));
        return redirect()->route('pim.employees.salaries.edit', [$employeeId, $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  unique identifier for the related employee resource
     * @param  integer  unique identifier for the resource
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($employeeId, $id, Request $request)
    {
        $this->employeeSalaryRepository->delete($id);
        $request->session()->flash('success', trans('app.pim.employees.salaries.delete_success'));
        return redirect()->route('pim.employees.salaries.index', $employeeId);
    }

    /**
     * Saves the current salary changes
     *
     * @param  integer $employeeId
     * @param  Request $request
     *
     * @return \Illuminate\Http\Response
     *
     * @todo Create a separate request handler
     */
    public function configSalary($employeeId, Request $request)
    {
        $salary = [
            'amount' => $request->amount,
            'type' => $request->type,
            'currency_id' => $request->currency_id,
            'bank_account' => $request->bank_account,
            'id_number' => $request->id_number,
            'user_id' => $employeeId,
        ];
        $this->employeeSalaryRepository->changeCurrentSalary($salary);
        return redirect()->route('pim.employees.salaries.index', $employeeId);
    }

    public function uploadSalaries()
    {
        $file = Input::file('attachment');
        $data = [];
        $maxR = [];
        Excel::selectSheetsByIndex(0)->load($file, function ($reader) use (&$data, &$maxR) {
            $reader->calculate();
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);
            $maxR = $sheet->getHighestRow();
            $data = $this->parseSalaries($sheet, $maxR);
        });
        return redirect()->back();
    }

    protected function parseSalaries($reader, $maxRow)
    {
        $startRow = 2;
        $skills = [];
        do {
            if (
            trim($reader->getCell(sprintf('D%s', $startRow))->getValue() !== "")
            ) {
                $parsedData = [
                    'matricola' => intval($reader->getCell(sprintf('D%s', $startRow))->getCalculatedValue()),
                    'contract_type' => intval($reader->getCell(sprintf('G%s', $startRow))->getCalculatedValue()),
                    'net_salary' => $reader->getCell(sprintf('L%s', $startRow))->getCalculatedValue(),
                    'extra_salary' => $reader->getCell(sprintf('M%s', $startRow))->getCalculatedValue(),
                    'evening_50_salary' => $reader->getCell(sprintf('N%s', $startRow))->getCalculatedValue(),
                    'sick_days' => $reader->getCell(sprintf('O%s', $startRow))->getCalculatedValue(),
                    'holidays' => $reader->getCell(sprintf('F%s', $startRow))->getCalculatedValue(),
                    'holiday_salary' => $reader->getCell(sprintf('Q%s', $startRow))->getCalculatedValue(),
                    'incentive' => $reader->getCell(sprintf('R%s', $startRow))->getCalculatedValue(),
                    'base_wage' => $reader->getCell(sprintf('S%s', $startRow))->getCalculatedValue(),
                    'evening_50_wage' => $reader->getCell(sprintf('T%s', $startRow))->getCalculatedValue(),
                    'extra_wage' => $reader->getCell(sprintf('U%s', $startRow))->getCalculatedValue(),
                    'sick_wage' => $reader->getCell(sprintf('V%s', $startRow))->getCalculatedValue(),
                    'holiday_wage' => $reader->getCell(sprintf('Y%s', $startRow))->getCalculatedValue(),
                    'net_wage' => $reader->getCell(sprintf('Z%s', $startRow))->getCalculatedValue()
                ];
                $user = User::where('matricola', $parsedData['matricola'])->first();
                if ($user) {
                    $salary = CurrentSalary::where('user_id', $user->id)->latest()->first();
                    if ($salary) {
                        if ($salary->amount !== $parsedData['net_salary'] && $parsedData['net_salary'] != null) {
                            $salary->amount = $parsedData['net_salary'];
                            $salary->save();
                        }
                    } else {
                        if ($parsedData['net_salary'] != null) {
                            $salary = new CurrentSalary();
                            $salary->amount = $parsedData['net_salary'];
                            $salary->user_id = $user->id;
                            $salary->type = 1;
                            $salary->currency_id = Currency::where('currency_code', 'ALL')->first()->id;
                            $salary->save();
                        }
                    }
                    $paymentDate = Carbon::now()->startOfMonth()->addDays(14);
                    $salaryData = ['payment_date' => $paymentDate, 'user_id' => $user->id];
                    $createdSalary = $this->employeeSalaryRepository->create($salaryData);
                    $contract_type_id = '';
                    switch ($parsedData['contract_type']) {
                        case 6 :
                            $contract_type_id = ContractType::where('name', 'Part Time 6')->first()->id;
                            break;
                        case 4 :
                            $contract_type_id = ContractType::where('name', 'Part Time 4')->first()->id;
                            break;
                        default :
                            $contract_type_id = ContractType::where('name', 'Full Time')->first()->id;
                            break;
                    }
                    if ($contract_type_id !== '' && $user->contract_type !== $contract_type_id) {
                        $user->contract_type = $contract_type_id;
                        $user->save();
                    }
                    $components = [
                        'Y1' => 'holiday_wage',
                        'R1' => 'incentive',
                        'S1' => 'base_wage',
                        'T1' => 'evening_50_wage',
                        'U1' => 'extra_wage',
                        'V1' => 'sick_wage'
                    ];
                    $total = $expense = 0;
                    foreach ($components as $key => $component) {
                        $salaryComponent = SalaryComponent::firstOrCreate(['name' => $reader->getCell($key)->getValue()], ['type' => 1, 'is_cost' => 1, 'contract_type_id' => $contract_type_id]);
                        if ($salaryComponent->type == 1) {
                            $total += $parsedData[$component];
                        } else {
                            $expense += $parsedData[$component];
                        }
                        $salarySalaryComponent = new SalarySalaryComponent();
                        $salarySalaryComponent->value = $parsedData[$component] ? $parsedData[$component] : 0;
                        $salarySalaryComponent->salary_component_id = $salaryComponent->id;
                        $salarySalaryComponent->salary_id = $createdSalary->id;
                        $salarySalaryComponent->save();
                    }
                    $salaryData = ['gross_total' => $total, 'nett_total' => $total - $expense];
                    $this->employeeSalaryRepository->update($createdSalary->id, $salaryData);
                }
            }
            $startRow += 1;
        } while ($startRow <= $maxRow);
    }
}