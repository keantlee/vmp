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
                $html = '<a href="/farmer/view-details/'.$row->reference_no.'" id="btn_data" type="button" class="btn btn-success">
                            <i class="fa fa-eye"></i> View
                        </a>';

                return $html;
            })
            ->make(true);
        }  
        return view("FarmerModule::index");
    }

    public function view_farmer_details_page(Request $request, $ref_no){
        $farmerModel = new FarmerModule;

        $markers = $farmerModel->get_voucher_transaction($ref_no);

        if($request->ajax()){
            return DataTables::of($markers)
            ->addColumn('fullname_column', function($row){
                return $row->last_name.' '.$row->first_name.' '.$row->middle_name.' '.$row->ext_name;
            })
            ->make(true);
        } 

        return view("FarmerModule::farmer_details", ['markers' => $markers]);
        // return view("FarmerModule::farmer_details");
    }

    // public function imageInterv(){
    //     $storagePath = storage_path('/attachments/' . $person . '/profile_' . $size . '.jpg');
    
    //     // return Image::make($storagePath)->response();
    //     return response()->file($storagePath);
    // }
}
