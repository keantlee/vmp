<?php

namespace App\Modules\Login\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Modules\Login\Models\OTP;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class OTPController extends Controller
{
    public function otp_page(){
        return view("Login::login_otp");
    }

    public function verify_OTP_form(Request $request){
        $input_otp = $request->otp;
        $users_otp = DB::select('select * from user_otp where user_id = ?', [Session::get('uuid')]);

        foreach($users_otp as $uOTP){
            if($uOTP->otp != $input_otp ){
                $error_response = ['error'=> true, 'message'=>'Invalid OTP!', 'auth'=>false];
                return response()->json( $error_response, 302); 
            }
            elseif($uOTP->otp == $input_otp){
                $check = new OTP;

                if($check->check_otp_expiration($uOTP->date_created) == true){
                    DB::table('user_otp')->where('user_id', [Session::get('uuid')])->update(['status' => "0"]);

                    $error_response = ['error'=> true, 'message'=>'The OTP Pin has been expired!', 'auth'=>false];
                    return response()->json( $error_response, 302); 
                }else{
                    DB::table('user_otp')->where('user_id', [Session::get('uuid')])->update(['status' => "1"]);
                    
                    $otp_verified_response = ['success'=> true, 'message' => 'OTP Pin is Valid!', 'auth' => false];
                    return response()->json($otp_verified_response, 200);
                }
            }
        }
        return view('Login::login_otp');
    }

    public function resend_otp(Request $request){
        $gen_otp_func = new OTP;

        $uuid = Session::get('uuid');
        $email = Session::get('email');
        $username = Session::get('username');
        $resend_otp = $gen_otp_func->generate_otp($uuid);
        $otp = $otp = $resend_otp['otp'];
        $date_created = $resend_otp['date_created']->toDateTimeString();

        MailController::send_OTP_mail($uuid, $email, $username, $otp, $date_created);

        $reset_otp_mail_success = ['success'=>true, 'message' => 'We send new OTP Pin through your email', 'auth'=>false];
        return response()->json($reset_otp_mail_success, 200);
    }
}
