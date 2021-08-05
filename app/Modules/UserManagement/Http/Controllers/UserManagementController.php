<?php

namespace App\Modules\UserManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Modules\UserManagement\Models\UserManagement;
use App\Modules\UserManagement\Models\GeoMap;
use Symfony\Component\HttpKernel\DataCollector\AjaxDataCollector;
use Yajra\DataTables\Facades\DataTables;

class UserManagementController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        return view("UserManagement::index");
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $UserManagementModel = new UserManagement;

        $user_login_program_status = "1";
        
        if($request->ajax()){
            return DataTables::of($UserManagementModel->get_program_permission($user_login_program_status))
            ->addColumn('fullname_column', function($row){
                return $row->last_name.' '.$row->first_name.' '.$row->middle_name.' '.$row->ext_name;
            })
            ->addColumn('reg_prov_column', function($row){
                return $row->reg_name.' '.$row->prov_name;
            })
            ->addColumn('action', function($row){
                $return = '<a href="#" id="btn_data" type="button" class="btn btn-success" id="'.$row->user_id.'" data-description="'.$row->description.'"
                            data-email="'.$row->email.'" data-contact_no="'.$row->contact_no.'" data-role="'.$row->role.'" data-toggle="modal" data-target="#ViewModal">
                            <i class="fa fa-eye"></i> View
                           </a>';
                return $return;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view("UserManagement::list_of_users"); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    } 
}
