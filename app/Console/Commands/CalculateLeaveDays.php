<?php

namespace App\Console\Commands;

use App\Modules\Leave\Models\EmployeeLeave;
use App\Modules\Leave\Models\EmployeeLeaveStatus;
use App\Modules\Leave\Models\LeaveType;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CalculateLeaveDays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates leave days for the employee';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /*
         * @ToDo 1- Check if start_date is of this year
         * @ToDo 2- Calculate diff_in_months from end of January to current month
         * @ToDo 3- Reset Leaves if current month is April
         * */
        $leave_type = LeaveType::firstOrCreate(['name' => 'Annual Leaves']);
        foreach (User::where('role', '!=', 3)->get() as $user) {
            if ($user->start_date) {
                if(Carbon::parse($user->start_date)->format('Y') === Carbon::now()->format('Y')){
                    $from = Carbon::parse($user->start_date);

                }else{
                    $from = Carbon::create(date('Y'), 1, 1);
                }
                $to = Carbon::parse(date('Y-m-d'));
                $diff_in_months = $to->diffInMonths($from);
                if (Carbon::parse($user->start_date)->format('d') <= 10) {
                    if($diff_in_months == 0){
                        $diff_in_months = 1;
                    }
                    if(Carbon::now()->format('d') >= 10){
                        $diff_in_months = $diff_in_months + 1;
                    }
                    $leaves = 1.66 * $diff_in_months;
                } else {
                    if ($diff_in_months > 0) {
                        $leaves = 1.66 * ($diff_in_months - 1);
                    } else {
                        $leaves = 0;
                    }
                }
                EmployeeLeaveStatus::updateOrCreate([
                    'user_id' => $user->id,
                    'leave_type_id' => $leave_type->id,
                ], [
                    'total_available' => $leaves
                ]);
            }
        }
    }
}
