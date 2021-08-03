<?php

namespace App\Modules\BudgetModule\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Modules\BudgetModule\Models\BudgetModule;

class BudgetModuleController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("BudgetModule::index");
    }

    public function fund_source_encoding_view()
    {
        $budgetModel = new BudgetModule;

        $programs = $budgetModel->get_program();

        $regions = $budgetModel->get_reg();
        
        return view("BudgetModule::fund_source_encoding", compact("programs", "regions"));
    }

    public function get_province($reg_code)
    {
        $budgetModel = new BudgetModule;

        $provinces = $budgetModel->get_prov($reg_code);

        return response()->json($provinces);
    }

    public function fund_encoding_ors(Request $request)
    {
        $program = $request->select_program;
        $uacs = $request->uacs;
        $amount = $request->amount;
        $region = $request->select_region;
        $province = $request->select_province;
        $particulars = $request->particulars;

        DB::table('fund_source')->insert([
            'fund_id' => Uuid::uuid4(),
            'program_id'=> $program, 
            'uacs'=> $uacs, 
            'amount'=> $amount, 
            'reg'=> $region, 
            'prv'=> $province, 
            'particulars'=> $particulars,
        ]);

        $success_response = ["success" => true, "message" => "ORS form have been submit successfully!"];
        return response()->json($success_response, 200);
    }

    public function fund_monitoring_and_disbursement_view(Request $request){
        $budgetModel = new BudgetModule;

        if($request->ajax()){
            return DataTables::of($budgetModel->disbursement()) // $budgetModel->disbursement()
            ->addColumn('action', function($row){
                $return = '<a href="/budget/fund-monitoring-and-disbursement/view-fund-source-breakdown/'.$row->fund_id.'" id="btn_data" type="button" class="btn btn-success">
                            <i class="fa fa-eye"></i> View
                           </a>';
                return $return;
            })
            ->rawColumns(['action'])
            ->make(true);
        }            

        return view("BudgetModule::fund_monitoring_and_disbursement");
    }

    public function get_fund_source_breakdown(Request $request, $fund_id){
        $budgetModel = new BudgetModule;

        if($request->ajax()){
            return DataTables::of($budgetModel->breakdown($fund_id))->make(true);
        }  

        return view("BudgetModule::fund_source_breakdown");
    }
}
