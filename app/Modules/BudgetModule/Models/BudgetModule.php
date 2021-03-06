<?php

namespace App\Modules\BudgetModule\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BudgetModule extends Model
{
    use HasFactory;

    protected $table = "fund_source";
    
    protected $fillable = [
        "fund_id", 
        "program_id", 
        "fund_cluster", 
        "uacs", 
        "appropriation", 
        "description", 
        "amount", 
        "reg", "prv", 
        "particulars", 
        "date_created", 
        "created_by_id", 
        "created_by_fullname"
    ];

    public function get_program(){
        $data = DB::table('programs')->get();

        return $data;
    }

    public function insert_new_fund($program, $uacs, $amount, $region, $province, $particulars){
        $data = DB::table('fund_source')->insert([
                    'fund_id' => Uuid::uuid4(),
                    'program_id'=> $program, 
                    'uacs'=> $uacs, 
                    'amount'=> $amount, 
                    'reg'=> $region, 
                    'prv'=> $province, 
                    'particulars'=> $particulars,
                ]);

        return $data;
    }
    
    public function get_reg(){
        $data = DB::select("CALL get_regions");
        
        return $data;
    }

    public function get_prov($reg_code){
        $data = DB::select("CALL get_provinces(" . $reg_code . ")");

        return $data;
    }

    public function disbursement(){
        $data = DB::table('fund_source as fs')
                    ->leftJoin('programs as p', 'fs.program_id', '=', 'p.program_id')
                    ->get();

        return $data;
    }

    public function breakdown($fund_id, $reg_program){
        //add another column for the receive intervention (item_id on program_items table)
        $data = DB::table('voucher_transaction as vt')
                    ->select('fs.fund_name', 'vt.reference_no', 's.supplier_name', 'p.description', 'vt.quantity', 'vt.amount', 'vt.total_amount')
                    ->leftJoin('supplier as s', 'vt.supplier_id', '=', 's.supplier_id')
                    ->leftJoin('supplier_programs as sp', 'vt.sub_program_id', '=', 'sp.sub_id')
                    ->leftJoin('programs as p', 'sp.program_id', '=', 'p.program_id')
                    ->leftJoin('program_items as pi', 'sp.item_id', '=', 'pi.item_id')
                    ->leftJoin('fund_source as fs', 'vt.fund_id', '=', 'fs.fund_id')
                    ->where('fs.fund_id', '=', $fund_id)
                    ->where('p.description', '=', $reg_program)
                    ->get();

        return $data;
    }

    public $timestamps = false;
}
