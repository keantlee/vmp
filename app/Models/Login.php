<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Login extends Model
{
    use HasFactory;

    protected $table = "users";

    protected $primary_key = "user_id";

    protected $fillable = [
        "agency", 
        "agency_loc", 
        "username", 
        "password", 
        "email", 
        "geo_code", 
        "reg",
        "prov", 
        "mun",
        "bgy", 
        "first_name", 
        "middle_name", 
        "last_name", 
        "ext_name", 
        "contact_no"
    ];

    public function user_session(){
        
    }

    public $timestamps = false;
}
