<?php

namespace App\Modules\Login\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Modules\Login\Models\OTP;
use Illuminate\Support\Facades\DB;
use App\Modules\Login\Models\Login;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Login\Http\Controllers\MailController;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        "contact_no",
        'date_created'
    ];

    public function check_email($email){
        $data = Login::where('email', '=', $email)->exists();;

        return $data;
    }

    public function check_uuid($uuid){
        $data =  OTP::where("user_id", '=', $uuid)->exists();

        return $data;
    }

    public function get_user($email){
        $data = DB::select('select * from users where email = ?', [$email]);

        return $data;
    }

    public function get_otp_query($uuid){
        $data = DB::table("user_otp")->where('user_id','=', $uuid)->get();

        return $data;
    }

    public function reset_status($uuid){
        $data = DB::table('users')->where('user_id', $uuid)->update(['password_reset_status' => 1]);;
        
        return $data;
    }

    public function get_user_id($uuid){
        $data = DB::select('select user_id, email, username, password, password_reset_status from users where user_id = ?', [$uuid]);

        return $data;
    }

    public function update_password($uuid, $new_pwd){
        $data = DB::table('users')->where('user_id', $uuid)->update(['password' => bcrypt($new_pwd), 'password_reset_status' => 0]);

        return $data;
    }

    public function email_otp($uuid, $email, $username, $otp, $date_created){
        $data = MailController::send_OTP_mail($uuid, $email, $username, $otp, $date_created);

        return $data;
    }

    public function email_reset_link($uuid, $email, $username, $firstname, $lastname, $date_created){
        $data = MailController::send_reset_password($uuid, $email, $username, $firstname, $lastname, $date_created);

        return $data;
    }

    public function email_confirm_password($uuid, $email, $username, $date_created){
        $data = MailController::send_confirmation_update_password($uuid, $email, $username, $date_created);

        return $data;
    }

    public $timestamps = false;
}
