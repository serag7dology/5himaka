<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Mail\Welcome;
use Modules\Plan\Entities\Plan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Withdraw\Entities\WithdrawsWay;
use Modules\User\Entities\UsersPlan;
use Modules\User\Entities\Role;
use Modules\User\Entities\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\User\Mail\ResetPasswordEmail;
use Modules\User\Contracts\Authentication;
use Modules\User\Http\Requests\LoginRequest;
use Modules\User\Http\Requests\RegisterRequest;
use Modules\User\Http\Requests\PasswordResetRequest;
use Modules\User\Http\Requests\ResetCompleteRequest;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Auth;

abstract class BaseAuthController extends Controller
{
    /**
     * The Authentication instance.
     *
     * @var \Modules\User\Contracts\Authentication
     */
    protected $auth;

    /**
     * @param \Modules\User\Contracts\Authentication $auth
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;

        $this->middleware('guest')->except('getLogout');
    }

    /**
     * Where to redirect users after login..
     *
     * @return string
     */
    abstract protected function redirectTo();

    /**
     * The login route.
     *
     * @return string
     */
    abstract protected function loginUrl();

    /**
     * Show login form.
     *
     * @return \Illuminate\Http\Response
     */
    abstract public function getLogin();

    /**
     * Show reset password form.
     *
     * @return \Illuminate\Http\Response
     */
    abstract public function getReset();

    /**
     * Login a user.
     *
     * @param \Modules\User\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(LoginRequest $request)
    {
        try {
            $loggedIn = $this->auth->login([
                'email' => $request->email,
                'password' => $request->password,
            ], (bool) $request->get('remember_me', false));

            if (! $loggedIn) {
                return back()->withInput()
                    ->withError(trans('user::messages.users.invalid_credentials'));
            }

            return redirect()->intended($this->redirectTo());
        } catch (NotActivatedException $e) {
            return back()->withInput()
                ->withError(trans('user::messages.users.account_not_activated'));
        } catch (ThrottlingException $e) {
            return back()->withInput()
                ->withError(trans('user::messages.users.account_is_blocked', ['delay' => $e->getDelay()]));
        }
    }

    /**
     * Logout current user.
     *
     * @return void
     */
    public function getLogout()
    {
        $this->auth->logout();

        return redirect($this->loginUrl());
    }

    /**
     * Register a user.
     *
     * @param \Modules\User\Http\Requests\RegisterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(RegisterRequest $request)
    {
        //die();
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
        $user->mobile=$request->mobile_number;
        $user->withdraw_way_id=$request->withdraw_method;
        $user->withdraw_field_value=$request->withdraw_main_field_value;
        $user->withdraw_field_description=$request->withdraw_description;
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
        
        // $user = $this->auth->registerAndActivate($request->only([
        //     'first_name',
        //     'last_name',
        //     'email',
        //     'password',
        //     'national_id',
        // ]));

        // $this->assignCustomerRole($user);

        // if (setting('welcome_email')) {
        //     Mail::to($request->email)
        //         ->send(new Welcome($request->first_name));
        // }

        return redirect($this->loginUrl())
            ->withSuccess(trans('user::messages.users.account_created'));
    }

    protected function assignCustomerRole($user)
    {
        $role = Role::findOrNew(setting('customer_role'));

        if ($role->exists) {
            $this->auth->assignRole($user, $role);
        }
    }

    /**
     * Start the reset password process.
     *
     * @param \Modules\User\Http\Requests\PasswordResetRequest $request
     * @return \Illuminate\Http\Response
     */
    public function postReset(PasswordResetRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (is_null($user)) {
            return back()->withInput()
                ->withError(trans('user::messages.users.no_user_found'));
        }

        $code = $this->auth->createReminderCode($user);

        Mail::to($user)
            ->send(new ResetPasswordEmail($user, $this->resetCompleteRoute($user, $code)));

        return back()->withSuccess(trans('user::messages.users.check_email_to_reset_password'));
    }

    /**
     * Reset complete form route.
     *
     * @param \Modules\User\Entities\User $user
     * @param string $code
     * @return string
     */
    abstract protected function resetCompleteRoute($user, $code);

    /**
     * Password reset complete view.
     *
     * @return string
     */
    abstract protected function resetCompleteView();

    /**
     * Show reset password complete form.
     *
     * @param string $email
     * @param string $code
     * @return \Illuminate\Http\Response
     */
    public function getResetComplete($email, $code)
    {
        $user = User::where('email', $email)->firstOrFail();

        if ($this->invalidResetCode($user, $code)) {
            return redirect()->route('reset')
                ->withError(trans('user::messages.users.invalid_reset_code'));
        }

        return $this->resetCompleteView()->with(compact('user', 'code'));
    }

    /**
     * Determine the given reset code is invalid.
     *
     * @param \Modules\User\Entities\User $user
     * @param string $code
     * @return bool
     */
    private function invalidResetCode($user, $code)
    {
        return $user->reminders()->where('code', $code)->doesntExist();
    }

    /**
     * Complete the reset password process.
     *
     * @param string $email
     * @param string $code
     * @param \Modules\User\Http\Requests\ResetCompleteRequest $request
     * @return \Illuminate\Http\Response
     */
    public function postResetComplete($email, $code, ResetCompleteRequest $request)
    {
        $user = User::where('email', $email)->firstOrFail();

        $completed = $this->auth->completeResetPassword($user, $code, $request->new_password);

        if (! $completed) {
            return back()->withInput()
                ->withError(trans('user::messages.users.invalid_reset_code'));
        }

        return redirect($this->loginUrl())
            ->withSuccess(trans('user::messages.users.password_has_been_reset'));
    }
}
