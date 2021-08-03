<?php

namespace App\Modules\Login\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Login\Http\Controllers\MailController;

class OTP extends Model
{
    use HasFactory;

    protected $table = 'user_otp';

    protected $fillable = ['otp_id', 'user_id', 'otp', 'date_created', 'status'];

    public function generate_otp($user_id){       
        // create random otp pin
        $otp = rand(1000, 9999);
        
        // default status "not active"
        $otp_status = "0";

        // create date and time base on GMT+8
        $otp_date_created = Carbon::now('GMT+8');

        // updateOrInsert() = update if the user has already exists and insert if not yet exists, create new data 
        DB::table('user_otp')->updateOrInsert(
            ['user_id'=>$user_id],
            ['user_id' => $user_id,'otp' => $otp, 'date_created' =>$otp_date_created, 'status' => $otp_status, ]
        );

        return ['otp'=>$otp, 'date_created'=>$otp_date_created];
    }
    
    public function check_otp_expiration($otp_date_created){
        $otp_start_date = $otp_date_created;
        $otp_end_date = 24; //mins
        $otp_expired_at = Carbon::parse($otp_start_date, 'GMT+8')->addHours($otp_end_date);

        // if date_created is 24hrs expired
        if($otp_expired_at->lessThan(Carbon::now('GMT+8'))){
            return true;
        }
        // if not yet expired
        return false;
    }
}
