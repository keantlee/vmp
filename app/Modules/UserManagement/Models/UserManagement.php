<?php

namespace App\Modules\UserManagement\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserManagement extends Model
{
    protected $table = 'users';

    public function get_program_permission($user_login_program_status){
        $data = DB::table('progam_permissions as pp')
                    ->leftJoin('roles as r', 'pp.role_id', '=', 'r.role_id')
                    ->leftJoin('programs as p','pp.program_id', '=', 'p.program_id')
                    ->leftJoin('users as u','pp.user_id', '=', 'u.user_id')
                    ->leftJoin('agency as a', 'a.agency_id', '=', 'u.agency')
                    ->leftJoin('geo_map as g', 'g.geo_code', '=', 'u.geo_code')
                    ->where('pp.status','=', $user_login_program_status)
                    ->get();
        
        return $data;
    }

    public $timestamps = false;
}
