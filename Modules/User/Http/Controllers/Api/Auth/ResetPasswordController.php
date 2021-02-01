<?php

namespace Modules\User\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Core\Http\Traits\GeneralTrait;
use Modules\User\Entities\User;

class ResetPasswordController extends Controller
{
    use GeneralTrait;
    /*
    |--------------------------------------------------------------------------
    |         To Store New Password
    |--------------------------------------------------------------------------
    */
    public function resetPassword(Request $request)
    { 
        try{
            $NewPasswordValidate =$this->NewPasswordValidate($request);
            if( $NewPasswordValidate){
                return $NewPasswordValidate;
            } 
            $user_id =  User::select('id')->where('email',$request->email)->first();
            $user = User::find($user_id['id']);
            if(!$user){
                return $this->returnError('001',trans('user::response_msg.user_id_err'));
            }
            if($request->password!==$request->password_confirmation){
                return $this->returnError('001',trans('user::response_msg.password_confirm_err'));
            }
            $user->update([
             'password' => bcrypt($request->password),
            ]);
            return $this->returnData($user,trans('user::response_msg.change_password'));
        }catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }

    }
    /*
    |--------------------------------------------------------------------------
    |         To Validate New Password
    |--------------------------------------------------------------------------
    */
    public  function NewPasswordValidate($request)
    {
        $rules = [
            'email'         => 'required|email|exists:users,email',
            'password'      => 'required|confirmed|min:8',
        ];
         $messages = [
                'email'     =>trans('user::validationCustom.email'),
                'password'  => trans('user::validationCustom.password')
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
}
