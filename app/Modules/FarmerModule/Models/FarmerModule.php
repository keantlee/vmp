<?php

namespace App\Modules\FarmerModule\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FarmerModule extends Model
{
    use HasFactory;

    public function get_voucher(){
        $data = DB::table('voucher')->select('reference_no', 'first_name', 'middle_name', 'last_name', 'ext_name')->get();

        return $data;
    }
    public function get_voucher_transaction($id){
        $data = DB::table('voucher_transaction as vt')
                    ->select('vt.reference_no', 'v.first_name', 'v.middle_name', 'v.last_name', 'v.ext_name', 'p.description', 'vt.quantity', 'vt.amount', 'vt.total_amount', 'vt.tansac_by_fullname', 'vt.payout_date')
                    ->leftJoin('voucher as v', 'vt.reference_no', '=', 'v.reference_no')
                    ->leftJoin('supplier as s', 'vt.supplier_id', '=', 's.supplier_id')
                    ->leftJoin('supplier_programs as sp', 'vt.sub_program_id', '=', 'sp.sub_id')
                    ->leftJoin('programs as p', 'sp.program_id', '=', 'p.program_id')
                    ->where('vt.reference_no', '=', $id)
                    ->get();

        return $data;
    }

    public function get_voucher_attachments(){
        return $data;
    }

    public function get_markers(){
        $data = DB::table('voucher_transaction')->get();

        // $data = DB::table('voucher_transaction')->where("voucher_details_id", '=', '00ffb7f9-c202-47ba-b097-8f654c488028')->get();

        return $data;
    }
}
