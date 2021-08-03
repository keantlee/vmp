<?php

namespace App\Modules\FarmerModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Modules\FarmerModule\Models\FarmerModule;

class FarmerModuleController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function list_of_farmers_info_view(Request $request){
        $farmerModel = new FarmerModule;

        if($request->ajax()){
            return DataTables::of($farmerModel->get_voucher())
            ->addColumn('fullname_column', function($row){
                return $row->last_name.' '.$row->first_name.' '.$row->middle_name.' '.$row->ext_name;
            })
            ->addColumn('action', function($row){
                $return = '<a href="/farmer/view-details/'.$row->reference_no.'" id="btn_data" type="button" class="btn btn-success">
                            <i class="fa fa-eye"></i> View
                          </a>';
                // $return =   '<a href="#" id="view_farmer_detail_btn" type="button" class="btn btn-success" data-id="'.$row->reference_no.'" 
                //                 data-fullname = "'.$row->last_name.' '.$row->first_name.' '.$row->middle_name.' '.$row->ext_name.'"  
                //                 data-lat="21.03" data-lng="105.85" data-toggle="modal" data-target="#ViewFarmerDetailsModal">
                //                 <i class="fa fa-eye"></i> View
                //             </a>';
                return $return;
            })
            ->make(true);
        }  
        
        return view("FarmerModule::index");
    }

    // public function farmer_details_modal(Request $request, $id){
    //     $data = DB::table('voucher_transaction as vt')
    //                 ->select('vt.reference_no', 'v.first_name', 'v.middle_name', 'v.last_name', 'v.ext_name', 'p.description', 'vt.quantity', 'vt.amount', 'vt.total_amount', 'vt.tansac_by_fullname', 'vt.payout_date')
    //                 ->leftJoin('voucher as v', 'vt.reference_no', '=', 'v.reference_no')
    //                 ->leftJoin('supplier as s', 'vt.supplier_id', '=', 's.supplier_id')
    //                 ->leftJoin('supplier_programs as sp', 'vt.sub_program_id', '=', 'sp.sub_id')
    //                 ->leftJoin('programs as p', 'sp.program_id', '=', 'p.program_id')
    //                 ->where('vt.reference_no', '=', $id)
    //                 ->get();

    //     if($request->ajax()){
    //         return DataTables::of($data)
    //         ->addColumn('fullname_column', function($row){
    //             return $row->last_name.' '.$row->first_name.' '.$row->middle_name.' '.$row->ext_name;
    //         })
    //         ->make(true);
    //     } 
    // }

    public function show_map_and_intervention(){
        $farmerModel = new FarmerModule;

        $markers = $farmerModel->get_markers();
        
        return view("FarmerModule::farmer_details",['markers' => $markers]);
    }

    public function view_farmer_details_page(Request $request, $id){
        $farmerModel = new FarmerModule;

        if($request->ajax()){
            return DataTables::of($farmerModel->get_voucher_transaction($id))
            ->addColumn('fullname_column', function($row){
                return $row->last_name.' '.$row->first_name.' '.$row->middle_name.' '.$row->ext_name;
            })
            ->make(true);
        } 

        return view("FarmerModule::farmer_details");
    }
}
