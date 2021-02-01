<?php

namespace Modules\User\Http\Controllers\Api;

use Modules\User\Entities\User;
use Modules\User\Entities\Role;
use Modules\Plan\Entities\Plan;
use Modules\Withdraw\Entities\WithdrawsWay;
use Modules\User\Entities\UsersPlan;

use Modules\Core\Http\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use Cartalyst\Sentinel\Laravel\Facades\Activation;

class AuthController 
{

    use GeneralTrait;
    public function login(Request $request)
    {
        try {

            $messages = [
                'email.required'    => trans("user::validation.email.required"),
                'password.required' => trans("user::validation.password.required"),
               
            ];
            $rules = [
                "email" => "required",
                "password" => "required"

            ];

            $validator = Validator::make($request->all(), $rules,$messages);
           
            if ($validator->fails()) {
                 $errors=array();     
                foreach ($validator->errors()->getMessages() as $key => $value) {
                    $errors[]=$value[0];
                }
                return $this->returnError($errors,422);

            }

            //login

           $credentials = $request -> only(['email','password']) ;

        $user =  Auth::attempt($credentials);

           if(!$user)
               return $this->returnError([trans('user::api.wrong_crediations')],404);
             $token = Str::random(250);
             $user->token=$token;
             $user->save();
            //return token
            $plan=Plan::first();
            $subscription_cost=$plan->subscription_cost;
             return $this->returnData(['user'=>$user,'subscription_cost' => $subscription_cost]);
        }catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }
    }
    public function pre_register()
    {
        $admin=User::join('user_roles', 'user_roles.user_id', '=', 'users.id')->where("user_roles.role_id",'!=',setting('customer_role'))->first();
        $currencies=Plan::distinct('currency')->pluck('currency');
        $currencies_plans = array();
        $currencies_plans_1 = array();
        foreach ($currencies as $currency) {
            $currs=Plan::where('currency',$currency)->get();
            $currencies_plans[]=[$currency=>$currs];
            $currencies_plans_1[$currency]=$currs;
            
        }
        $withdraw_methods=WithdrawsWay::where('is_active',1)->get();
        return $this->returnData([
            'default_code'=>$admin->id,
            'currencies'=>$currencies_plans,
            'currencies1'=>$currencies_plans_1,
            'withdraws_methods'=>$withdraw_methods
            ]);
    }
    public function pre_register_page1(Request $request)
    {
       
        $messages = [
            'email.required' => trans("user::validation.email.required"),
            'email.unique' => trans("user::validation.email.unique"),
            'email.max' => trans("user::validation.email.required"),
            'password.min' => trans("user::validation.password.min"),
            'password.max' => trans("user::validation.password.max"),
            'password.required' => trans("user::validation.password.required"),
            'password.same' => trans("user::validation.password.same"),
            'password_confirmation.required' => trans("user::validation.password_confirmation.required"),
            'password_confirmation.min' => trans("user::validation.password_confirmation.min"),
            'password_confirmation.max' => trans("user::validation.password_confirmation.max"),
            'first_name.required' => trans("user::validation.first_name.required"),
            'first_name.min' => trans("user::validation.first_name.min"),
            'first_name.max' => trans("user::validation.first_name.max"),
            'last_name.required' => trans("user::validation.last_name.required"),
            'last_name.min' => trans("user::validation.last_name.min"),
            'last_name.max' => trans("user::validation.last_name.max"),
            'mobile_code.required' => trans("user::validation.mobile_code.required"),
            'mobile_code.min' => trans("user::validation.mobile_code.min"),
            'mobile_code.max' => trans("user::validation.mobile_code.max"),
            'mobile_number.required' => trans("user::validation.mobile_number.required"),
            'mobile_number.min' => trans("user::validation.mobile_number.min"),
            'mobile_number.max' => trans("user::validation.mobile_number.max"),
            'national_id.required' => trans("user::validation.national_id.required"),
            'national_id.min' => trans("user::validation.national_id.min"),
            'national_id.max' => trans("user::validation.national_id.max"),
            'code.required' => trans("user::validation.code.required"),
            'code.min' => trans("user::validation.code.min"),
            'code.max' => trans("user::validation.code.max"),
            'code.exists' => trans("user::validation.code.exists"),
        ];
        $rules = [
            'email' => 'required|unique:users|max:255',
            'password' => 'min:8|max:255|required|same:password_confirmation',
            'password_confirmation' => 'required|min:8|max:255',
            "first_name"=>"required|min:3|max:255",
            "last_name"=>"required|min:3|max:255",
            "mobile_code"=>"required|min:1|max:5",
            "mobile_number"=>"required|min:8|max:255",
            "national_id"=>"required|min:8|max:255",
            "code"=>"required|exists:users,id|min:1|max:255",
        ];
        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            $errors=array();     
           foreach ($validator->errors()->getMessages() as $key => $value) {
               $errors[]=$value[0];
           }
           return $this->returnError($errors,422);

       }
       if($request->code!=1)
            {
                $parent_user_plan=UsersPlan::where("user_id",$request->code)->orderByDesc('end_date')->first();
                $parent_plan=Plan::find($parent_user_plan->plan_id);
                $max_number_invitions=$parent_user_plan->expand*$parent_plan->max_people;//1*5
                $max_limit_in_branch=round($parent_plan->limit/$parent_plan->max_people);//50000/5=10000
                $max_people_in_branch=ceil($max_limit_in_branch/$parent_plan->commission);//10000/5=2000
                $parent_user=User::find($request->code);
                $user_commission=$parent_user->commission_acount+$parent_user->points*setting('each_point_equal_to_money');
                if($user_commission>=($parent_plan->limit*$parent_user_plan->expand))
                {
                    return $this->returnError([trans("user::api.exceed_commission")],422);
                }
                if($parent_plan->end_date>date('Y-m-d'))
                {
                    return $this->returnError([trans("user::api.exceed_end_date")],422);
                }
                $main_childs=UsersPlan::where('parent_id',$request->code)->get();
                if(count($main_childs)>=$max_number_invitions)
                {
                    return $this->returnError([trans("user::api.exceed_number_invitions")],422);
                }
                if($parent_user->incremental_points<setting('max_points'))
                {
                    $parent_user->incremental_points+=setting('each_member_equal_to_points');
                    $parent_user->points+=setting('each_member_equal_to_points');
                }
                else
                {
                    $parent_user->commission_acount+=$parent_plan->commission;
                }
                 
                $parent_user->save();
                while (true) {
                    $false=0;
                    $parent_user_plan=UsersPlan::where("user_id",$parent_user_plan->parent_id)->orderByDesc('end_date')->first();
                    if($parent_user_plan==NULL)
                      {
                        $parent_plan=Plan::first();
                        $parent_user=User::find(1);
                        $parent_user->commission_acount+=$parent_plan->commission;
                        $parent_user->save();
                        break;
                      }
                      $parent_plan=Plan::find($parent_user_plan->plan_id);
                      $max_number_invitions=$parent_user_plan->expand*$parent_plan->max_people;//1*5
                      $max_limit_in_branch=round($parent_plan->limit/$parent_plan->max_people);//50000/5=10000
                      $max_people_in_branch=ceil($max_limit_in_branch/$parent_plan->commission);//10000/5=2000
                      $parent_user=User::find($parent_user_plan->user_id);
                      $user_commission=$parent_user->commission_acount+$parent_user->points*setting('each_point_equal_to_money');
                        
                        if($user_commission>=($parent_plan->limit*$parent_user_plan->expand))
                        {
                            $false=1;
                        }
                        if($parent_plan->end_date>date('Y-m-d'))
                        {
                            $false=1;

                        }
                        $main_childs=UsersPlan::where('parent_id',$parent_user_plan->user_id)->get();
                        if(count($main_childs)>=$max_number_invitions)
                        {
                            $false=1;

                        }
                        if($false==0)
                        {
                            if($parent_user->incremental_points<setting('max_points'))
                            {
                                $parent_user->incremental_points+=setting('each_member_equal_to_points');
                                $parent_user->points+=setting('each_member_equal_to_points');
                            }
                            else
                            {
                                $parent_user->commission_acount+=$parent_plan->commission;
                            }
                        }
                        
                        $parent_user->save();
                }
                
            }
            else
            {
                 $parent_plan=Plan::first();
                 $parent_user=User::find(1);
                 $parent_user->commission_acount+=$parent_plan->commission;
            }
            return  $this->returnSuccessMessage(trans('user::validation.success'), 200);
    }
    public function pre_register_page2(Request $request)
    {
        try {

            $messages = [
                'pin.required' => trans("user::validation.pin.required"),
                'pin.min' => trans("user::validation.pin.min"),
                'pin.max' => trans("user::validation.pin.max"),
                'question.required' => trans("user::validation.question.required"),
                'question.min' => trans("user::validation.question.min"),
                'question.max' => trans("user::validation.question.max"),
                'answer.required' => trans("user::validation.answer.required"),
                'answer.min' => trans("user::validation.answer.min"),
                'answer.max' => trans("user::validation.answer.max"),
            ];
            $rules = [
                
                "pin"=>"required|min:4|max:255",
                "question"=>"required|min:4|max:1000",
                "answer"=>"required|min:4|max:1000",
            ];

            $validator = Validator::make($request->all(), $rules,$messages);

            if ($validator->fails()) {
                $errors=array();     
               foreach ($validator->errors()->getMessages() as $key => $value) {
                   $errors[]=$value[0];
               }
               return $this->returnError($errors,422);

           }
           return  $this->returnSuccessMessage(trans('user::validation.success'), 200);
    

        }catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }   
    }
    public function pre_register_page3(Request $request)
    {
        try {

            $messages = [
                'subscription.required' => trans("user::validation.subscription.required"),
                'subscription.exists'=>trans('user::validation.subscription.exists'),
            ];
            $rules = [
                "subscription"=>"required|exists:plans,id",
            ];

            $validator = Validator::make($request->all(), $rules,$messages);

            if ($validator->fails()) {
                $errors=array();     
               foreach ($validator->errors()->getMessages() as $key => $value) {
                   $errors[]=$value[0];
               }
               return $this->returnError($errors,422);

           }

           return  $this->returnSuccessMessage(trans('user::validation.success'), 200);


        }catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }   
    }
    public function register(Request $request)
    {
        try {
            $messages = [
                'email.required'        => trans("user::validation.email.required"),
                'email.unique'          => trans("user::validation.email.unique"),
                'email.max'             => trans("user::validation.email.required"),
                'password.min'          => trans("user::validation.password.min"),
                'password.max'          => trans("user::validation.password.max"),
                'password.required'     => trans("user::validation.password.required"),
                'password.same'         => trans("user::validation.password.same"),
                'password_confirmation.required' => trans("user::validation.password_confirmation.required"),
                'password_confirmation.min'      => trans("user::validation.password_confirmation.min"),
                'password_confirmation.max'      => trans("user::validation.password_confirmation.max"),
                'first_name.required'            => trans("user::validation.first_name.required"),
                'first_name.min'                 => trans("user::validation.first_name.min"),
                'first_name.max'                 => trans("user::validation.first_name.max"),
                'last_name.required'             => trans("user::validation.last_name.required"),
                'last_name.min'                  => trans("user::validation.last_name.min"),
                'last_name.max'                  => trans("user::validation.last_name.max"),
                'mobile_code.required'           => trans("user::validation.mobile_code.required"),
                'mobile_code.min'                => trans("user::validation.mobile_code.min"),
                'mobile_code.max'                => trans("user::validation.mobile_code.max"),
                'mobile_number.required'         => trans("user::validation.mobile_number.required"),
                'mobile_number.min'              => trans("user::validation.mobile_number.min"),
                'mobile_number.max'              => trans("user::validation.mobile_number.max"),
                'national_id.required'           => trans("user::validation.national_id.required"),
                'national_id.min'                => trans("user::validation.national_id.min"),
                'national_id.max'                => trans("user::validation.national_id.max"),
                'code.required'                  => trans("user::validation.code.required"),
                'code.min'                       => trans("user::validation.code.min"),
                'code.max'                       => trans("user::validation.code.max"),
                'code.exists'                    => trans("user::validation.code.exists"),
                'pin.required'                   => trans("user::validation.pin.required"),
                'pin.min'                        => trans("user::validation.pin.min"),
                'pin.max'                        => trans("user::validation.pin.max"),
                'question.required'              => trans("user::validation.question.required"),
                'question.min'                   => trans("user::validation.question.min"),
                'question.max'                   => trans("user::validation.question.max"),
                'answer.required'                => trans("user::validation.answer.required"),
                'answer.min'                     => trans("user::validation.answer.min"),
                'answer.max'                     => trans("user::validation.answer.max"),
                'subscription.required'          => trans("user::validation.subscription.required"),
                'subscription.exists'            =>trans('user::validation.subscription.exists'),
            ];
            $rules = [
                'email'                 =>'required|unique:users|max:255',
                'password'              =>'min:8|max:255|required|same:password_confirmation',
                'password_confirmation' =>'required|min:8|max:255',
                "first_name"            =>"required|min:3|max:255",
                "last_name"             =>"required|min:3|max:255",
                "mobile_code"           =>"required|min:1|max:5",
                "mobile_number"         =>"required|min:8|max:255",
                "national_id"           =>"required|min:8|max:255",
                "code"                  =>"required|exists:users,id|min:1|max:255",
                "pin"                   =>"required|min:4|max:255",
                "question"              =>"required|min:4|max:1000",
                "answer"                =>"required|min:4|max:1000",
                "subscription"          =>"required|exists:plans,id",
            ];
            $validator = Validator::make($request->all(), $rules,$messages);
            if ($validator->fails()) {
                $errors=array();     
               foreach ($validator->errors()->getMessages() as $key => $value) {
                   $errors[]=$value[0];
               }
               return $this->returnError($errors,422);
           }
           $user_id=User::where('code',$request->code)->first();
           if($request->code!=1)
                {
                    $parent_user_plan=UsersPlan::where("user_id",$user_id->id)->orderByDesc('end_date')->first();
                    $parent_plan=Plan::find($parent_user_plan->plan_id);
                    $max_number_invitions=$parent_user_plan->expand*$parent_plan->max_people;//1*5
                    $max_limit_in_branch=round($parent_plan->limit/$parent_plan->max_people);//50000/5=10000
                    $max_people_in_branch=ceil($max_limit_in_branch/$parent_plan->commission);//10000/5=2000
                    $parent_user=User::find($user_id->id);
                    $user_commission=$parent_user->commission_acount+$parent_user->points*setting('each_point_equal_to_money');
                    if($user_commission>=($parent_plan->limit*$parent_user_plan->expand))
                    {
                        return $this->returnError([trans("user::api.exceed_commission")],422);
                    }
                    if($parent_plan->end_date>date('Y-m-d'))
                    {
                        return $this->returnError([trans("user::api.exceed_end_date")],422);
                    }
                    $main_childs=UsersPlan::where('parent_id',$user_id->id)->get();
                    if(count($main_childs)>=$max_number_invitions)
                    {
                        return $this->returnError([trans("user::api.exceed_number_invitions")],422);
                    }
                    if($parent_user->incremental_points<setting('max_points'))
                    {
                        $parent_user->incremental_points+=setting('each_member_equal_to_points');
                        $parent_user->points+=setting('each_member_equal_to_points');
                    }
                    else
                    {
                        $parent_user->commission_acount+=$parent_plan->commission;
                    }
                     
                    $parent_user->save();
                    while (true) {
                        $false=0;
                        $parent_user_plan=UsersPlan::where("user_id",$parent_user_plan->parent_id)->orderByDesc('end_date')->first();
                        if($parent_user_plan==NULL)
                          {
                            $parent_plan=Plan::first();
                            $parent_user=User::find(1);
                            $parent_user->commission_acount+=$parent_plan->commission;
                            $parent_user->save();
                            break;
                          }
                          $parent_plan=Plan::find($parent_user_plan->plan_id);
                          $max_number_invitions=$parent_user_plan->expand*$parent_plan->max_people;//1*5
                          $max_limit_in_branch=round($parent_plan->limit/$parent_plan->max_people);//50000/5=10000
                          $max_people_in_branch=ceil($max_limit_in_branch/$parent_plan->commission);//10000/5=2000
                          $parent_user=User::find($parent_user_plan->user_id);
                          $user_commission=$parent_user->commission_acount+$parent_user->points*setting('each_point_equal_to_money');
                            
                            if($user_commission>=($parent_plan->limit*$parent_user_plan->expand))
                            {
                                $false=1;
                            }
                            if($parent_plan->end_date>date('Y-m-d'))
                            {
                                $false=1;
    
                            }
                            $main_childs=UsersPlan::where('parent_id',$parent_user_plan->user_id)->get();
                            if(count($main_childs)>=$max_number_invitions)
                            {
                                $false=1;
    
                            }
                            if($false==0)
                            {
                                if($parent_user->incremental_points<setting('max_points'))
                                {
                                    $parent_user->incremental_points+=setting('each_member_equal_to_points');
                                    $parent_user->points+=setting('each_member_equal_to_points');
                                }
                                else
                                {
                                    $parent_user->commission_acount+=$parent_plan->commission;
                                }
                            }
                            
                            $parent_user->save();
                    }
                    
                }
                else
                {
                     $parent_plan=Plan::first();
                     $parent_user=User::find(1);
                     $parent_user->commission_acount+=$parent_plan->commission;
                }

            //register
            $user=new User;
            $last_user =User::orderBy('id', 'desc')->first();
            $user->code=rand(0,10000).$last_user->id+1;
            $user->first_name=$request->first_name;
            $user->last_name=$request->last_name;
            $user->email=$request->email;
            $user->national_id=$request->national_id;

            $user->password=Hash::make($request->password);  
            $user->pin=$request->pin;
            $user->question=$request->question;
            $user->answer=$request->answer;
            $user->mobile=$request->mobile_code.$request->mobile_number;
            // $user->withdraw_way_id=$request->withdraw_method;
            // $user->withdraw_field_value=$request->withdraw_main_field_value;
            // $user->withdraw_field_description=$request->withdraw_description;
            $token = Str::random(250);
            $user->token=$token;
            $user->save();   
            $plan=Plan::find($request->subscription);
            
            $user_plan=new UsersPlan;
            $user_plan->user_id=$user->id;
            $user_plan->plan_id=$request->subscription;
            $user_plan->parent_id=$user_id->id;
            $user_plan->start_date=date('Y-m-d');

            if($plan->duration==1)
            {
                $user_plan->end_date=date('Y-m-d', strtotime('+1 years'));//plus 1 year
            }
            else if($plan->duration==2)
            {
                $user_plan->end_date=date('Y-m-d', strtotime('+1 months'));//plus 1 month
            }
            else if($plan->duration==3)
            {
                $user_plan->end_date=date('Y-m-d', strtotime('+1 weeks'));;//plus 1 week
            }
            else if($plan->duration==4)
            {
                $user_plan->end_date=date('Y-m-d', strtotime('+1 days'));//plus 1 day
            }

            $user_plan->save();
            $activation = Activation::create($user);
            Activation::complete($user, $activation->code);
            Auth::loginUsingId($user->id);

            $user->roles()->attach(setting('customer_role'));
            $plan=Plan::first();

            $subscription_cost=$plan->subscription_cost;

            return $this->returnData(['user'=>$user,'subscription_cost'=> $subscription_cost]);

        }catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }   
    }
     /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
         //$user=auth()->user();
         $user=User::where("token",$request->token)->first();
        Auth::logout();
        return $this->returnData(['user'=>$user],trans('user::api.logout'));
    }
    
}
