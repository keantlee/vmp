<?php

namespace App\Modules\Login\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Modules\Login\Http\Controllers\MailController;
use App\Modules\Login\Models\OTP;
use App\Modules\Login\Models\Login;
use Carbon\Carbon;

class LoginController extends Controller
{
    /**
     * View: login_page.blade.php
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        /**
         * 1.) Check if the user session is active
         *     = go to user session dashboard page.
         * 2.) else return to login page 
         */ 
        if(Session::has('email')){
            return redirect()->route("main.home");
        }
        return view("Login::login_page");
    }

    /**
     * Action: when user click "Sign me in"
     */
    public function login_action(Request $request){
        // get request from input form
        $email = $request->email;
        $password = $request->password;

        $otpModel = new OTP;

        $loginModel = new Login;

        // check email if exists
        $check_email = $loginModel->check_email($email);
        // $check_email = Login::where('email', '=', $email)->exists();

        // get user
        $users = $loginModel->get_user($email);
        // $users = DB::select('select * from users where email = ?', [$email]);

        if($check_email == true){
            foreach($users as $user){
                if (Hash::check($password, $user->password)) {
                    /**
                     * Store user datas to session
                     */
                    Session::put('uuid', $user->user_id);
                    Session::put('email', $email);
                    Session::put('first_name', $user->first_name);
                    Session::put('last_name', $user->last_name);
                    Session::put('username', $user->username);

                    // check user_id if exists
                    $check_otp_user_records = $loginModel->check_uuid($user->user_id);
                    // $check_otp_user_records = OTP::where("user_id", '=', $user->user_id)->exists();

                    // get user otp queries
                    $users_otp = $loginModel->get_otp_query($user->user_id);
                    // $users_otp = DB::table("user_otp")->where('user_id','=',$user->user_id)->get();
    
                    /**
                     * check the user_otp table if there's a record of the given user_id
                     * 1.) if true proceed checking the otp date expiration.
                     * 2.) if there is no existing data proceed generating new otp.
                     */
                    if(($check_otp_user_records == true)){
                        foreach($users_otp as $uOTP){
                            //check date expiration
                            if($uOTP->status == "0"){
                                $uuid = $user->user_id;
                                $username = $user->username;
                                $generate_otp = $otpModel->generate_otp($uuid);
                                $otp = $generate_otp['otp'];
                                $date_created = $generate_otp['date_created'];

                                // send otp to email
                                $loginModel->email_otp($uuid, $email, $username, $otp, $date_created);
                                // MailController::send_OTP_mail($uuid, $email, $username, $otp, $date_created);
        
                                $otp_mail_success = ['success'=>true, 'message'=>'OTP has been send through your email', 'auth'=>false];
                                return response()->json($otp_mail_success, 200);
                            }
                            elseif($uOTP->status == "1"){      
                                return view("Login::login_otp");
                            }
                        }
                    }
                    else{
                        $uuid = $user->user_id;
                        $username = $user->username;
                        $generate_otp = $otpModel->generate_otp($uuid);
                        $otp = $generate_otp['otp'];
                        $date_created = $generate_otp['date_created'];

                        // send otp to email
                        $loginModel->email_otp();
                        // MailController::send_OTP_mail($uuid, $email, $username, $otp, $date_created);
    
                        $otp_mail_success = ['success'=>true, 'message'=>'OTP has been send through your email', 'auth'=>false];
                        return response()->json($otp_mail_success, 200);
                    }
                }   
                else{
                    // if the email does not exists = Error_msg: "The email or password is incorrect!"
                    $error_response = ['error'=> true, 'message'=>"The email or password is incorrect!", 'auth'=>false];
                    return response()->json($error_response, 302);
                } 
            }
        }
        else{
            // if the email does not exists = Error_msg: "The Email doesn't exists!"
            $error_response = ['error'=> true, 'message'=>"The Email doesn't exists!", 'auth'=>false];
            return response()->json($error_response, 302);
        } 
    }

    /**
     * View: send_mail.blade.php
     */
    public function show_link_request_form(){
        return view("Login::password.send_email");
    }

    /**
     * Action: when user click "Send Reset Password Link"
     */
    public function send_btn_link_req_form(Request $request){
        $loginModel = new Login;

        // check email if exists
        $check_email = $loginModel->check_email($request->email);

        // get user
        $users = $loginModel->get_user($request->email);

         // check if the user or user email exists
        if($check_email == true){
            foreach($users as $user){
                if($request->email == $user->email){
                    // create token
                    $token = sha1(rand(1, 30));
                    $uuid = $user->user_id;
                    $email = $user->email;
                    $username = $user->username;
                    $firstname = $user->first_name;
                    $lastname = $user->last_name;
                    $date_created = Carbon::now('GMT+8')->toDateTimeString();

                    // Change password_reset_status to "1"
                    $loginModel->reset_status($uuid);

                    // send reset link to email
                    $loginModel->email_reset_link($uuid, $email, $username, $firstname, $lastname, $date_created);
    
                    $success_response = ['success'=> true, 'message' => 'The reset password link is have been send to your email.', 'auth' => false];
                    return response()->json($success_response, 200);
                }
                else{
                    $error_response = ['error'=> true, 'message'=>'The input email is incorrect', 'auth'=>false];
                    return response()->json($error_response, 302);
                }
            }
        }
        else{
            $error_response = ['error'=> true, 'message'=>"The Email doesn't exists!", 'auth'=>false];
            return response()->json($error_response, 302);
        }
    }

    /**
     * View: change_password_page.blade.php
     */
    public function change_password_form($uuid){
        $loginModel = new Login;

        $users = $loginModel->get_user_id($uuid);
        
        /**
         * Check reset password link status = 0 or 1
         * 1.) if the user click the link and the status on DB is set to "0" 
         *     it will direct to "404" because the reset password link is expired.
         * 2.) else if the status on DB is set to "1"
         *     the user can change his/her password.
         */
        foreach($users as $user){
            if($user->password_reset_status == 0){
                abort(404, 'Page not found');
            }elseif($user->password_reset_status == 1){
                return view("Login::password.change_password_page", ['user'=>$user]);
            }
        }
    }

    public function update_password(Request $request, $uuid){
        // get url parameter
        // $request->has('');

        // get request from input form
        $old_pwd = $request->old_password;
        $new_pwd = $request->new_password;

        $loginModel = new Login;

        $users_uuid = $loginModel->get_user_id($uuid);

        /**
         * Validation:
         * 1.) if old password does exists = true
         * 2.) else old password does not exsist = false (Error: The input password does not match!)
         * 3.) If it's success. Pop-message the new password is have been save. (Alert Message)
        */
        foreach($users_uuid as $user_uuid){
            if(Hash::check($old_pwd, $user_uuid->password)){
                // update new user password and reset_password_link_status to "0"
                // $loginModel->update_password($user_uuid->user_id, $new_pwd);
                DB::table('users')->where('user_id', $user_uuid->user_id)->update(['password' => bcrypt($new_pwd), 'password_reset_status' => 0]);

                $uuid = $user_uuid->user_id;
                $email = $user_uuid->email;
                $username = $user_uuid->username;
                $date_created = Carbon::now('GMT+8')->toDateTimeString();

                // send confirmation update password to email
                $loginModel->update_password($uuid, $email, $username, $date_created);

                $success_response = ['success'=> true, 'message' => 'The new password is have been save!', 'auth' => false];
                return response()->json($success_response, 200);
            }
            else{
                $error_response = ['error'=> true, 'message'=>"The input old password does not match!", 'auth'=>false];
                return response()->json($error_response, 302);
            }
        }
    }

    public function session_managment(Request $request){

    }

    public function logout_action(){
        if(Session::has('username')){
            Session::flush();
        }
        return redirect()->route("main.page");
    }
}
