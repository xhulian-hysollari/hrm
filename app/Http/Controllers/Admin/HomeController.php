<?php

namespace App\Http\Controllers\Admin;

use App\Modules\Settings\Models\Forcontact;
use App\Modules\Time\Repositories\Interfaces\TimeLogRepositoryInterface as TimeLogRepository;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show the profile config page.
     *
     * @param  App\Modules\Time\Repositories\Interfaces\TimeLogRepositoryInterface $timeLogRepository
     * @return \Illuminate\Http\Response
     */
    public function index(TimeLogRepository $timeLogRepository)
    {
        $structures = Forcontact::all();

        return view('welcome', compact('structures'));
    }
}
