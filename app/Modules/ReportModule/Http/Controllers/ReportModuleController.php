<?php

namespace App\Modules\ReportModule\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportModuleController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("ReportModule::welcome");
    }
}
