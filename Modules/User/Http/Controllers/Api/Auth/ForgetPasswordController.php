<<<<<<< HEAD
<?php

namespace Modules\User\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Modules\Core\Http\Traits\GeneralTrait;
use Modules\User\Emails\SendOtpRestPassword;
use Modules\User\Entities\Otp;
use Modules\User\Entities\User;
use Modules\User\Notifications\SendOtpRestPasswordNotification;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class ForgetPasswordController extends Controller
{
    use GeneralTrait;
      /*
    |--------------------------------------------------------------------------
    |         To Send  OTP Code To Email
    |--------------------------------------------------------------------------
    */
    public function sendOtp(Request $request)
    {
        try{
            $ResetValidate = $this->ResetValidate($request);
            if($ResetValidate){
                return $ResetValidate;
            } 
              $user = Otp::select('email')->where('email', $request->email)->orderBy('id', 'desc')->first();
            if(!$user){
            try{
                 $userInfo  = User::where('email' , $request->email)->first();
                    $userEmail = User::select('email')->where('email', $request->email)->first();
                    $otp       = $this->generateOtp(); 
                    $details   = [
                        'greeting'  => trans('user::response_msg.greeting') . ' '. $userInfo['first_name'],
                        'body'      => trans('user::response_msg.body').' : ' .$otp,
                        'thanks'    => trans('user::response_msg.thanks'),
                    ]; 
                   
                   if($this->sendEmail($request->email,$userInfo['first_name'], $otp)){
                      // Notification::send($userEmail, new SendOtpRestPasswordNotification($details));
                      Otp::create([
                        'email'         => $request->email,
                        'code'          => $otp,
                        'receiver_id'   => $userInfo['id']
                    ]);
                    return $this->returnSuccessMessage(trans('user::response_msg.successOtp'),200);                     
                   }
                   return $this->returnError(trans('user::response_msg.errorSend'),422);                     

                }catch (\Exception $ex){
                    return $this->returnError($ex->getMessage(),500);
                }

            }
            $userDetails  = User::where('email' , $request->email)->first();
            $emailDetails = User::select('email')->where('email', $request->email)->first();
            $old_otp = Otp::select('code')->where('email', $request->email)->orderBy('id', 'desc')->first();
            // $details = [
            //     'greeting'  => trans('user::response_msg.greeting').  ' '.$userDetails['first_name'],
            //     'body'      => trans('user::response_msg.body').' : ' . $old_otp['code'],
            //     'thanks'    => trans('user::response_msg.thanks'),
            // ];
            if($this->sendEmail($request->email,$userDetails['first_name'],$old_otp['code'])){
                // Notification::send($userEmail, new SendOtpRestPasswordNotification($details));
            //     Otp::create([
            //       'email'         => $request->email,
            //       'code'          =>  $old_otp['code'],
            //       'receiver_id'   => $userDetails['id']
            //   ]);
              return $this->returnSuccessMessage(trans('user::response_msg.successOtp'),200);                     
             }
             return $this->returnError(trans('user::response_msg.errorSend'),422);                  
        }catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }

     }

    /*
    |--------------------------------------------------------------------------
    |         To Check OTP Code  
    |--------------------------------------------------------------------------
    */
     public function checkOtp(Request $request)
     {
         try{
                $CheckOTPValidate = $this->CheckOTPValidate($request);
                if($CheckOTPValidate){
                    return $CheckOTPValidate;
                } 
                $otp = Otp::select('code')->where('email',$request->email)->orderBy('id', 'desc')->first();
                if(!$otp){
                    return $this->returnError(trans('user::response_msg.OtpNotFoundInDb'),422);
                }
                if($otp['code'] == $request->code){
                    $otp_id = Otp::select('id')->where('email',$request->email)->first();
                    if(!$otp_id){
                        return $this->returnError(trans('user::response_msg.errorOtp'),422);
                    }
                    $otp_record =   otp::find($otp_id['id']);
                    $user   =   User::where('email',$request->email)->first();
                    $otp_record->delete();  
                    return $this->returnSuccessMessage(trans('user::response_msg.successOtpCheck'),200);                     
                }
                    return $this->returnError(trans('user::response_msg.errorOtpCheck'),422);
             }catch (\Exception $ex){
                return $this->returnError($ex->getMessage(),500);
             }
     }
    
     /*
    |--------------------------------------------------------------------------
    |         To Validate Reset
    |--------------------------------------------------------------------------
    */
    public  function ResetValidate($request)
    {
        $rules = [
            'email'               => 'required|email|exists:users,email'
        ];              
        $messages = [
            'email.required'     =>trans('user::validation.email.required'), 
            'email.email'        =>trans('user::validation.email.email'), 
            'email.exists'       =>trans('user::validation.email.exists'),         ];
        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            $errors=array();     
           foreach ($validator->errors()->getMessages() as $key => $value) {
               $errors[]=$value[0];
           }
           return $this->returnError($errors,422);
       }
    } 
     /*
    |--------------------------------------------------------------------------
    |         To Validate Check OTP
    |--------------------------------------------------------------------------
    */
     public  function CheckOTPValidate($request)
    {
        $rules = [
            'code'         => 'required|numeric',
            'email'        => 'required|email|exists:users,email'
        ];
        $messages = [
           'code.required'      =>trans('user::validation.code.required'),
           'code.numeric'       =>trans('user::validation.code.numeric'),
           'email.required'     =>trans('user::validation.email.required'), 
           'email.email'        =>trans('user::validation.email.email'), 
           'email.exists'       =>trans('user::validation.email.exists'), 
        ];
        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) { 
            $errors=array();     
           foreach ($validator->errors()->getMessages() as $key => $value) {
               $errors[]=$value[0];
           }
           return $this->returnError($errors,422);
       }
    }
    public function sendEmail($email,$username,$otp)
    {
        $app_name = config('app.name');
        $app_url  = config('app.url');
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Mailer = 'smtp';
        $mail->SMTPDebug  = 0;  
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = 'ssl';
        $mail->Port       =  465;
        $mail->Host       = 'smtp.googlemail.com';
        $mail->Username   = 'ahmedalreaty@gmail.com';
        $mail->Password   = 'queerliyhuovnkpt';
        $mail->IsHTML(true);
        $mail->AddAddress($email, $username);
        $mail->SetFrom("5himaka@adology-solutions.com", "5Himaka");
        $mail->AddReplyTo("5himaka@adology-solutions.com", "5Himaka");
        $mail->AddCC("5himaka@adology-solutions.com", "Reset Password Code");
        $mail->Subject = "Hey! Reset Password Notification";
        $content = view("user::admin.auth.email", compact("otp","app_name","app_url"));
        $mail->MsgHTML($content); 
        $mail->Send();
        if($mail->Send()){
            return true;
        }else{
            return false;
        }
    }
}
=======
<?php

namespace Modules\User\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Modules\Core\Http\Traits\GeneralTrait;
use Modules\User\Emails\SendOtpRestPassword;
use Modules\User\Entities\Otp;
use Modules\User\Entities\User;
use Modules\User\Notifications\SendOtpRestPasswordNotification;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class ForgetPasswordController extends Controller
{
    use GeneralTrait;
      /*
    |--------------------------------------------------------------------------
    |         To Send  OTP Code To Email
    |--------------------------------------------------------------------------
    */
    public function sendOtp(Request $request)
    {
        try{
            $ResetValidate = $this->ResetValidate($request);
            if($ResetValidate){
                return $ResetValidate;
            } 
              $user = Otp::select('email')->where('email', $request->email)->orderBy('id', 'desc')->first();
            if(!$user){
            try{
                 $userInfo  = User::where('email' , $request->email)->first();
                    $userEmail = User::select('email')->where('email', $request->email)->first();
                    $otp       = $this->generateOtp(); 
                    $details   = [
                        'greeting'  => trans('user::response_msg.greeting') . ' '. $userInfo['first_name'],
                        'body'      => trans('user::response_msg.body').' : ' .$otp,
                        'thanks'    => trans('user::response_msg.thanks'),
                    ]; 
                   
                   if($this->sendEmail($request->email,$userInfo['first_name'], $otp)){
                      // Notification::send($userEmail, new SendOtpRestPasswordNotification($details));
                      Otp::create([
                        'email'         => $request->email,
                        'code'          => $otp,
                        'receiver_id'   => $userInfo['id']
                    ]);
                    return $this->returnSuccessMessage(trans('user::response_msg.successOtp'),200);                     
                   }
                   return $this->returnError(trans('user::response_msg.errorSend'),422);                     

                }catch (\Exception $ex){
                    return $this->returnError($ex->getMessage(),500);
                }

            }
            $userDetails  = User::where('email' , $request->email)->first();
            $emailDetails = User::select('email')->where('email', $request->email)->first();
            $old_otp = Otp::select('code')->where('email', $request->email)->orderBy('id', 'desc')->first();
            // $details = [
            //     'greeting'  => trans('user::response_msg.greeting').  ' '.$userDetails['first_name'],
            //     'body'      => trans('user::response_msg.body').' : ' . $old_otp['code'],
            //     'thanks'    => trans('user::response_msg.thanks'),
            // ];
            if($this->sendEmail($request->email,$userDetails['first_name'],$old_otp['code'])){
                // Notification::send($userEmail, new SendOtpRestPasswordNotification($details));
            //     Otp::create([
            //       'email'         => $request->email,
            //       'code'          =>  $old_otp['code'],
            //       'receiver_id'   => $userDetails['id']
            //   ]);
              return $this->returnSuccessMessage(trans('user::response_msg.successOtp'),200);                     
             }
             return $this->returnError(trans('user::response_msg.errorSend'),422);                  
        }catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }

     }

    /*
    |--------------------------------------------------------------------------
    |         To Check OTP Code  
    |--------------------------------------------------------------------------
    */
     public function checkOtp(Request $request)
     {
         try{
                $CheckOTPValidate = $this->CheckOTPValidate($request);
                if($CheckOTPValidate){
                    return $CheckOTPValidate;
                } 
                $otp = Otp::select('code')->where('email',$request->email)->orderBy('id', 'desc')->first();
                if(!$otp){
                    return $this->returnError(trans('user::response_msg.OtpNotFoundInDb'),422);
                }
                if($otp['code'] == $request->code){
                    $otp_id = Otp::select('id')->where('email',$request->email)->first();
                    if(!$otp_id){
                        return $this->returnError(trans('user::response_msg.errorOtp'),422);
                    }
                    $otp_record =   otp::find($otp_id['id']);
                    $user   =   User::where('email',$request->email)->first();
                    $otp_record->delete();  
                    return $this->returnSuccessMessage(trans('user::response_msg.successOtpCheck'),200);                     
                }
                    return $this->returnError(trans('user::response_msg.errorOtpCheck'),422);
             }catch (\Exception $ex){
                return $this->returnError($ex->getMessage(),500);
             }
     }
    
     /*
    |--------------------------------------------------------------------------
    |         To Validate Reset
    |--------------------------------------------------------------------------
    */
    public  function ResetValidate($request)
    {
        $rules = [
            'email'               => 'required|email|exists:users,email'
        ];              
        $messages = [
            'email.required'     =>trans('user::validation.email.required'), 
            'email.email'        =>trans('user::validation.email.email'), 
            'email.exists'       =>trans('user::validation.email.exists'),         ];
        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            $errors=array();     
           foreach ($validator->errors()->getMessages() as $key => $value) {
               $errors[]=$value[0];
           }
           return $this->returnError($errors,422);
       }
    } 
     /*
    |--------------------------------------------------------------------------
    |         To Validate Check OTP
    |--------------------------------------------------------------------------
    */
     public  function CheckOTPValidate($request)
    {
        $rules = [
            'code'         => 'required|numeric',
            'email'        => 'required|email|exists:users,email'
        ];
        $messages = [
           'code.required'      =>trans('user::validation.code.required'),
           'code.numeric'       =>trans('user::validation.code.numeric'),
           'email.required'     =>trans('user::validation.email.required'), 
           'email.email'        =>trans('user::validation.email.email'), 
           'email.exists'       =>trans('user::validation.email.exists'), 
        ];
        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) { 
            $errors=array();     
           foreach ($validator->errors()->getMessages() as $key => $value) {
               $errors[]=$value[0];
           }
           return $this->returnError($errors,422);
       }
    }
    public function sendEmail($email,$username,$otp)
    {
        $app_name = config('app.name');
        $app_url  = config('app.url');
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Mailer = 'smtp';
        $mail->SMTPDebug  = 0;  
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = 'ssl';
        $mail->Port       =  465;
        $mail->Host       = 'smtp.googlemail.com';
        $mail->Username   = 'ahmedalreaty@gmail.com';
        $mail->Password   = 'queerliyhuovnkpt';
        $mail->IsHTML(true);
        $mail->AddAddress($email, $username);
        $mail->SetFrom("5himaka@adology-solutions.com", "5Himaka");
        $mail->AddReplyTo("5himaka@adology-solutions.com", "5Himaka");
        $mail->AddCC("5himaka@adology-solutions.com", "Reset Password Code");
        $mail->Subject = "Hey! Reset Password Notification";
        $content = view("user::admin.auth.email", compact("otp","app_name","app_url"));
        $mail->MsgHTML($content); 
        $mail->Send();
        if($mail->Send()){
            return true;
        }else{
            return false;
        }
    }
}
>>>>>>> a0742e146695c20142eae4b146d3d134a15283c9
