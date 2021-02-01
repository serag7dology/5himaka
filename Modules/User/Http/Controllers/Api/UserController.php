<?php

namespace Modules\User\Http\Controllers\Api;

use Modules\User\Entities\User;

use Modules\Core\Http\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Withdraw\Entities\WithdrawsWay;
use Modules\User\Entities\UsersPlan;
use Modules\Plan\Entities\Plan;
use Modules\Withdraw\Entities\WithdrawsRequest;
use Modules\Setting\Entities\Setting;
use Modules\User\Entities\WalletHistory;
use Modules\User\Entities\WalletHistoryTranslation;

class UserController 
{

    use GeneralTrait;
    public function wishlist(Request $request)
    {
        $user=User::where("token",$request->token)->first();
        $wishlist=$user->wishlist;
        foreach ($wishlist as $item) {
            $item->description=strip_tags($item->description);

        }
        return $this->returnData(['wishlist'=>$wishlist]);
    }
    public function favProductOrService(Request $request)
    {
        try {

            $messages = [
                'product_id.required' => trans("user::validation.product.required"),
                'product_id.exists' => trans("user::validation.product.exists"),
                'isFav.required'=> trans("user::validation.isFav.required"),
            ];
            $rules = [
                'product_id' => 'required|exists:products,id',
                'isFav'=>'required'
            ];

            $validator = Validator::make($request->all(), $rules,$messages);

            if ($validator->fails()) {
                $errors=array();     
               foreach ($validator->errors()->getMessages() as $key => $value) {
                   $errors[]=$value[0];
               }
               return $this->returnError($errors,422);

           }
        $user=User::where("token",$request->token)->first();
        if($request->isFav==1)
        {
            if($user->wishlistHas($request->product_id))
            {
                return $this->returnError([trans('user::api.duplicated_product')],422);
            } 
            $user->wishlist()->attach($request->product_id);
            $wishlist=$user->wishlist;
            foreach ($wishlist as $item) {
                $item->description=strip_tags($item->description);
    
            }
            $delivery_info['5himaka']= Setting::where("key","5himaka")->first()->value;
            $delivery_info['delivery_information']= Setting::where("key","delivery_info")->first()->value;
            $delivery_info['return_policy']= Setting::where("key","return_policy")->first()->value;
            
            return $this->returnData(['wishlist'=>$wishlist,'delivery_info'=>$delivery_info],trans('user::api.addedtowishlist'));
        }
        else
        {
            $user->wishlist()->detach($request->product_id);
            $wishlist=$user->wishlist;
            $delivery_info['5himaka']= Setting::where("key","5himaka")->first()->value;
            $delivery_info['delivery_information']= Setting::where("key","delivery_info")->first()->value;
            $delivery_info['return_policy']= Setting::where("key","return_policy")->first()->value;
            return $this->returnData(['wishlist'=>$wishlist,'delivery_info'=>$delivery_info],trans('user::api.removedtowishlist'));
        }
        }catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        } 
    }
    public function getUserProfileDetails(Request $request)
    {
        $user=User::where("token",$request->token)->first();
        $user->register_link = env('APP_URL') .'/en/register?code='.$user->id;
        $user->code= $user->id;
        return $this->returnData(['user'=>$user]);
    }
    public function editUserProfileDetails(Request $request)
    {
        $user=User::where("token",$request->token)->first();
        if(isset($request->first_name))
        $user->first_name=$request->first_name;

        if(isset($request->last_name))
        $user->last_name=$request->last_name;

        if(isset($request->mobile))
        $user->mobile=$request->mobile;

        if(isset($request->withdraw_method))
         $user->withdraw_way_id=$request->withdraw_method;

         if(isset($request->withdraw_main_field_value))
         $user->withdraw_field_value=$request->withdraw_main_field_value;

         if(isset($request->withdraw_description))
         $user->withdraw_field_description=$request->withdraw_description;

         if(isset($request->pin))
         $user->pin=$request->pin;

         if(isset($request->question))
         $user->question=$request->question;

         if(isset($request->answer))
          $user->answer=$request->answer;
          if(isset($request->question_2))
          $user->question_2=$request->question_2;
          if(isset($request->answer_2))
           $user->answer_2=$request->answer_2;
           if($request->hasFile('card_image')){
                $file_path = $this->saveImage('user_cards', $request->card_image);
                $user->card_image=$file_path;
           }
           
        if(isset($request->old_password) && isset($request->new_password))
        {
            $current_password = $user->password;           
            if(Hash::check($request->old_password, $current_password))
            {           
                
                $user->password = Hash::make($request->new_password);
            }
            else
            {           
                return $this->returnError([trans('user::api.old_password')],400);
 
            }
        }
        $user->save();

        return $this->returnData(['user'=>$user],trans('user::api.updated_successfully'));
    }
    public function editUserAddress(Request $request)
    {
        $rules = [
            'address' => 'required|max:255',
            'delivery_address' => 'required|max:255',
        ];
        $messages = [
            'address.required' => trans("user::validation.address.required"),
            'address.max' => trans("user::validation.address.max"),
            'delivery_address.required' => trans("user::validation.delivery_address.required"),
            'delivery_address.max' => trans("user::validation.delivery_address.max"),

        ];

        $validator = Validator::make($request->all(), $rules,$messages);

        if ($validator->fails()) {
            $errors=array();     
           foreach ($validator->errors()->getMessages() as $key => $value) {
               $errors[]=$value[0];
           }
           return $this->returnError($errors,422);

       }
           
        $user=User::where("token",$request->token)->first();
        $user->address=$request->address;
        $user->delivery_address=$request->delivery_address;
        
        $user->save();

        return $this->returnData(['user'=>$user],trans('user::api.address_updated_successfully'));
    }
    public function getMethodsOfCashOut(Request $request)
    {
        $user=User::where("token",$request->token)->first();
        $user_withdraw_method=$user->WithdrawMethod;
        $withdraw_methods=WithdrawsWay::where('is_active',1)->get();

        
        return $this->returnData(['user_withdraw_method'=>$user_withdraw_method,'withdraw_methods'=>$withdraw_methods]);

    }
    public function changeMethodOfCashOut(Request $request)
    {
        try {

            $messages = [
               
                'withdraw_method.required' => trans("user::validation.withdraw_method.required"),
                'withdraw_method.exists' => trans("user::validation.withdraw_method.exists"),
                'withdraw_main_field_value.required' => trans("user::validation.withdraw_main_field_value.required"),
                'withdraw_main_field_value.min' => trans("user::validation.withdraw_main_field_value.min"),
                'withdraw_main_field_value.max' => trans("user::validation.withdraw_main_field_value.max"),
                'withdraw_description.max' => trans("user::validation.withdraw_description.max"),
            ];
            $rules = [
                
                "withdraw_method"=>"required|exists:withdraws_ways,id",
                "withdraw_main_field_value"=>"required|min:8|max:255",
                "withdraw_description"=>"max:1000",
            ];

            $validator = Validator::make($request->all(), $rules,$messages);

            if ($validator->fails()) {
                $errors=array();     
               foreach ($validator->errors()->getMessages() as $key => $value) {
                   $errors[]=$value[0];
               }
               return $this->returnError($errors,422);
           }
            $user=User::where("token",$request->token)->first();
            $user->withdraw_way_id=$request->withdraw_method;
            $user->withdraw_field_value=$request->withdraw_main_field_value;
            $user->withdraw_field_description=$request->withdraw_description;
            $user->save();
            return $this->returnData(["user"=>$user],trans('user::api.cachout_updated_successfully'));
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        } 
    }
    public function orders(Request $request)
    {
        $user=User::where("token",$request->token)->first();
        $orders=$user->orders;

        foreach ($orders as &$order) {
            if($order->shipping_method=="Free Shipping")
            {
                $order->shipping_method_ar="شحن ببلاش";
                $order->shipping_method_en="Free Shipping";
            }
            if($order->payment_method=="Cash On Delivery" )
            {
                $order->payment_method_ar="الدفع عند الاستلام";
                $order->payment_method_en="Cash On Delivery";
            }
        }        
        return $this->returnData(['orders'=>$orders]);

    }
    public function cashback(Request $request)
    {
        $user=User::where("token",$request->token)->first();
        $balance=$user->cachback_caccount;
        $wallet_history =  WalletHistory::where('wallet_id',$user->id)->where('wallet_type','cachback_caccount')->get();          

        return $this->returnData(['balance'=>$balance,'wallet_history'=>$wallet_history]);

    }
    public function transition(Request $request)
    {
        try {

            $messages = [
               
                'wallet_id.required' => trans("user::validation.wallet_id.required"),
                'amount.required' => trans("user::validation.amount.required"),
            ];
            $rules = [
                
                "wallet_id"=>"required",
                "amount"=>"required",
            ];

            $validator = Validator::make($request->all(), $rules,$messages);

            if ($validator->fails()) {
                $errors=array();     
               foreach ($validator->errors()->getMessages() as $key => $value) {
                   $errors[]=$value[0];
               }
               return $this->returnError($errors,422);

           }
           if($request->amount == 0){
                return $this->returnError([trans("user::api.amount_err")],422); 
           }
            $user=User::where("token",$request->token)->first();
            if($request->wallet_id==1)
            {
                if($request->amount > $user->cachback_caccount)
                {
                    return $this->returnError([trans("user::api.amount_limited")],422); 
                }
              $user->personal_acount+=$request->amount;
              $wallet_history  = WalletHistory::create([
                'wallet_id'       => $user->id,
                'wallet_type'     => 'cachback_caccount',
                'wallet_type_from'=> 'personal_acount',
                'amount_spent'    => $request->amount,
                'current_total'   => $user->cachback_caccount-$request->amount,
                'pervious_total'  => $user->cachback_caccount,
                'user_id_from'    => $user->id, 
                'user_id_to'      => $user->id
            ]);
            WalletHistoryTranslation::create([
                'wallet_history_id' => $wallet_history->id,
                'operation_type'    =>' التحويل من حساب الكاش الى الحساب الشخصى',
                'locale'            =>'ar'

            ]);
            WalletHistoryTranslation::create([
                'wallet_history_id' => $wallet_history->id,
                'operation_type'    =>'Transfer  from cache account to personal account',
                'locale'            =>'en'

            ]);
              $user->cachback_caccount-=$request->amount;
            }
            elseif($request->wallet_id==2)
            {
                if($request->amount > $user->commission_acount)
                {
                    return $this->returnError([trans("user::api.amount_limited")],422); 
                }
                $user->personal_acount+=$request->amount;
                $wallet_history  = WalletHistory::create([
                    'wallet_id'       => $user->id,
                    'wallet_type'     => 'commission_acount',
                    'wallet_type_from'=> 'personal_acount',
                    'amount_spent'    => $request->amount,
                    'current_total'   => $user->commission_acount-$request->amount,
                    'pervious_total'  => $user->commission_acount,
                    'user_id_from'    => $user->id, 
                    'user_id_to'      => $user->id
                ]);
                WalletHistoryTranslation::create([
                    'wallet_history_id'     => $wallet_history->id,
                    'operation_type'        =>' التحويل من حساب العمولة الى الحساب الشخصى',
                    'locale'                =>'ar'

                ]);
                WalletHistoryTranslation::create([
                    'wallet_history_id' => $wallet_history->id,
                    'operation_type'    =>'Transfer  from commission account to personal account',
                    'locale'            =>'en'

                ]);
                $user->commission_acount-=$request->amount;
            }
            elseif($request->wallet_id==3)
            {
                if($request->amount > $user->cadeau_acount)
                {
                    return $this->returnError([trans("user::api.amount_limited")],422); 
                }
                $user->personal_acount+=$request->amount;
                $wallet_history  = WalletHistory::create([
                        'wallet_id'       => $user->id,
                        'wallet_type'     => 'cadeau_acount',
                        'wallet_type_from'=> 'personal_acount',
                        'amount_spent'    => $request->amount,
                        'current_total'   => $user->cadeau_acount-$request->amount,
                        'pervious_total'  => $user->cadeau_acount,
                        'user_id_from'    => $user->id, 
                        'user_id_to'      => $user->id
                    ]);
                    WalletHistoryTranslation::create([
                        'wallet_history_id' => $wallet_history->id,
                        'operation_type'    =>' التحويل من حساب الهدايا الى الحساب الشخصى',
                        'locale'            =>'ar'

                    ]);
                    WalletHistoryTranslation::create([
                        'wallet_history_id' => $wallet_history->id,
                        'operation_type'    =>'Transfer  from cadeau account to personal account',
                        'locale'            =>'en'

                    ]);
                    $user->cadeau_acount-=$request->amount;

            }
            elseif($request->wallet_id==4)
            {
                if($request->amount > $user->profit_acount)
                {
                    return $this->returnError([trans("user::api.amount_limited")],422); 
                }
                $user->personal_acount+=$request->amount;
                $wallet_history  = WalletHistory::create([
                    'wallet_id'       => $user->id,
                    'wallet_type'     => 'profit_acount',
                    'wallet_type_from'=> 'personal_acount',
                    'amount_spent'    => $request->amount,
                    'current_total'   => $user->profit_acount-$request->amount,
                    'pervious_total'  => $user->profit_acount,
                    'user_id_from'    => $user->id, 
                    'user_id_to'      => $user->id
                ]);
                WalletHistoryTranslation::create([
                    'wallet_history_id' => $wallet_history->id,
                    'operation_type'    =>' التحويل من حساب الارباح الى الحساب الشخصى',
                    'locale'            =>'ar'

                ]);
                WalletHistoryTranslation::create([
                    'wallet_history_id' => $wallet_history->id,
                    'operation_type'    =>'Transfer  from profit account to personal account',
                    'locale'            =>'en'

                ]);
                $user->profit_acount-=$request->amount;
            }
            $user->save();
            return $this->returnData(["user"=>$user],trans('user::api.transition_done_successfully'));
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        } 
    }
    public function commission_wallet(Request $request)
    {
        try{
            if(isset($request->id))
            {
                $user = User::where("id",$request->id)->first();
                $wallet_history =  WalletHistory::where('wallet_id',$request->id)->where('wallet_type','commission_acount')->get();          
            }
            else
            {
                $user = User::where("token",$request->token)->first();
                $wallet_history = WalletHistory::where('wallet_id',$user->id)->where('wallet_type','commission_acount')->get();
            }
            if(!isset($user) || $user==NULL)
            {
                return $this->returnError([trans('user::api.ivalid_id')],422);
            }
            $balance = $user->commission_acount;
            $points  = $user->points;
            if($user->incremental_points>=setting('min_points_to_convert_to_money'))
            {
                $isPoints=true; 
            }
            else
            {
                $isPoints=false;
            }
            $tree=array();
            $parent_id=$user->id;
            

            $Main_Childs=UsersPlan::where("parent_id",$parent_id)->get();
            foreach ($Main_Childs as $child) {
                $child_user=User::find($child->user_id);

                $tree[]=array("id"=>$child_user->id,"name"=>$child_user->first_name ." ".$child_user->last_name);

            }
            $min_points_to_convert_to_money = setting('min_points_to_convert_to_money');
            return $this->returnData(['points'=> $points,'isPoints'=>$isPoints,"balance"=>$balance,'min_points_to_convert_to_money'=>$min_points_to_convert_to_money,"Main_Childs"=>$tree,"wallet_history"=> $wallet_history ]);
        }  
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }   
    }
    public function convert_points(Request $request)
    {
        try{
            
            $user=User::where("token",$request->token)->first(); 
            if($user->incremental_points<setting('min_points_to_convert_to_money'))
            {
                return $this->returnError([trans('user::api.less_points_to_convert')],422);
            }
            $user->commission_acount+=$user->points*setting('each_point_equal_to_money');
            $user->points=0;
            $user->save();
            
            return $this->returnData(['user'=>$user],trans('user::api.convert_points_to_commission_successfully'));
        }  
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }   
    }
    
    public function reward(Request $request)
    {
        try{
            $user=User::where("token",$request->token)->first();
            $balance=$user->cadeau_acount;
            $wallet_history =  WalletHistory::where('wallet_id',$user->id)->where('wallet_type','cadeau_acount')->get();       
            
            return $this->returnData(['balance'=>$balance,"wallet_history"=> $wallet_history]);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        } 

    }
    public function earning(Request $request)
    {
        try{
            $user=User::where("token",$request->token)->first();
            $balance=$user->profit_acount;
            $wallet_history =  WalletHistory::where('wallet_id',$user->id)->where('wallet_type','profit_acount')->get();  
            
            return $this->returnData(['balance'=>$balance,"wallet_history"=> $wallet_history]);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        } 
    }
    public function pre_upgrade(Request $request)
    {
        try{
            $user=User::where("token",$request->token)->first();
            $user_plan=UsersPlan::where("user_id",$user->id)->first();
            $plan=Plan::find($user_plan->plan_id);
            $cards=array();
            if($plan->duration==1)
            {
                $duration=trans("user::api.yearly");
            }
            elseif($plan->duration==2)
            {
                $duration=trans("user::api.monthly");
            }
            elseif($plan->duration==3)
            {
                $duration=trans("user::api.Weekly");
            }
            elseif($plan->duration==4)
            {
                $duration=trans("user::api.daily");
            }
            $expaned=$user_plan->expand;
            $can_expand=5-$expaned;
            $completed=floor(($user->incremental_points*setting('each_point_equal_to_money'))/$plan->limit);
            $in_progress=$expaned-$completed;
            for($i=0; $i < $in_progress; $i++) { 
                $cards[]=array("duration"=>$duration,"status"=>2,"cost"=>$plan->subscription_cost,"currency"=>$plan->currency);
            }
            for($i=0; $i < $can_expand; $i++) { 
                $cards[]=array("duration"=>$duration,"status"=>3,"cost"=>$plan->subscription_cost,"currency"=>$plan->currency);
            }
            for($i=0; $i < $completed; $i++) { 
                $cards[]=array("duration"=>$duration,"status"=>1,"cost"=>$plan->subscription_cost,"currency"=>$plan->currency);
            }
            return $this->returnData(['cards'=>$cards]);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        } 
    }
    public function upgrade(Request $request)
    {
        try{
            $user=User::where("token",$request->token)->first();
            $user_plan=UsersPlan::where("user_id",$user->id)->first();
            $user_plan->expand+=1;
            $user_plan->save();
            return $this->returnData([],trans('user::api.expand_successfully'));
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        } 
    }
    public function pre_person_wallet_cashout(Request $request)
    {
        try{
            $user=User::where("token",$request->token)->first();
            $user_plan=UsersPlan::where("user_id",$user->id)->orderByDesc('end_date')->first();
            $plan=Plan::find($user_plan->plan_id);
            $user->currency=$plan->currency;
            $withdraw_requests=WithdrawsRequest::where("user_id",$user->id)->get();
            foreach ($withdraw_requests as $item) {
                $withdraw_method=WithdrawsWay::find($item->withdraw_way_id);
                $item->main_filed_name=$withdraw_method->field_name;
            }
            $user_withdraw_method=$user->WithdrawMethod;
            $withdraw_methods=WithdrawsWay::where('is_active',1)->get();
            return $this->returnData(['balance'=>$user->personal_acount,'user'=>$user,
                                      'user_withdraw_method'=>$user_withdraw_method,'withdraw_methods'=>$withdraw_methods,
                                      'withdraw_requests'=>$withdraw_requests]);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }    
    }
    public function person_wallet_cashout(Request $request)
    {
        try{

            $messages = [
                'withdraw_way_id.required' => trans("user::validation.withdraw_way_id.required"),
                'withdraw_way_id.exists' => trans("user::validation.withdraw_way_id.exists"),
                'withdraw_field_value.required'=> trans("user::validation.withdraw_field_value.required"),
                'amount.required'=> trans("user::validation.amount.required"),

            ];
            $rules = [
                'withdraw_way_id' => 'required|exists:withdraws_ways,id',
                'withdraw_field_value'=>'required',
                'amount'=>'required'
            ];

            $validator = Validator::make($request->all(), $rules,$messages);

            if ($validator->fails()) {
                $errors=array();     
               foreach ($validator->errors()->getMessages() as $key => $value) {
                   $errors[]=$value[0];
               }
               return $this->returnError($errors,422);
           }

            $user=User::where("token",$request->token)->first();
            if($user->personal_acount<$request->amount)
            {
                return $this->returnError([trans('user::api.amount_exceed_wallet')],422); 
            }
          
            if($user->card_image ==''|| $user->card_image == null){
                return $this->returnError([trans('user::api.card_image')],422); 

            }
           // $user_withdraw_method=$user->WithdrawMethod;
            //$withdraw_methods=WithdrawsWay::where('is_active',1)->get();
            $withdraw_request=new WithdrawsRequest;
            $withdraw_request->user_id=$user->id;
            $withdraw_request->withdraw_way_id=$request->withdraw_way_id;
            $withdraw_request->withdraw_field_value=$request->withdraw_field_value;
            if(isset($request->withdraw_field_description))
            $withdraw_request->withdraw_field_description=$request->withdraw_field_description;

            $withdraw_request->amount=$request->amount;

            $withdraw_request->save();
            $wallet_history  = WalletHistory::create([
                'wallet_id'       => $user->id,
                'wallet_type'     => 'personal_acount',
                'amount_spent'    => $request->amount,
                'current_total'   => $user->personal_acount-$request->amount,
                'pervious_total'  => $user->personal_acount,
                'user_id_from'    => $user->id, 
                'user_id_to'      => $user->id
            ]);
            WalletHistoryTranslation::create([
                'wallet_history_id' => $wallet_history->id,
                'operation_type'    =>' طلب سحب من المحفظة الشخصية',
                'locale'            =>'ar'

            ]);
            WalletHistoryTranslation::create([
                'wallet_history_id' => $wallet_history->id,
                'operation_type'    =>'Transfer  from personal account  to withdraw request',
                'locale'            =>'en'

            ]);
            return $this->returnData(['withdraw_request'=>$withdraw_request]);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }    
    }
    public function cashout_requests(Request $request)
    {
        try{
            $user=User::where("token",$request->token)->first();
            $withdraw_requests=WithdrawsRequest::where("user_id",$user->id)->get();
            foreach ($withdraw_requests as $item) {
                $withdraw_method=WithdrawsWay::find($item->withdraw_way_id);
                $item->main_filed_name=$withdraw_method->field_name;
            }
            $wallet_history =  WalletHistory::where('wallet_id',$user->id)->where('wallet_type','personal_acount')->get();  

            return $this->returnData(['withdraw_requets'=>$withdraw_requests,'wallet_history' => $wallet_history]);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }    
        
    }
    public function paid(Request $request)
    {
        try{
            $messages = [
                'is_paid.required' => trans("user::validation.is_paid.required"),  
                'is_paid.in' => trans("user::validation.is_paid.in"),  
            ];
            $rules = [
                'is_paid' => 'required|in:0,1',
            ];
            $validator = Validator::make($request->all(), $rules,$messages);
            if ($validator->fails()) {
                $errors=array();     
               foreach ($validator->errors()->getMessages() as $key => $value) {
                   $errors[]=$value[0];
               }
               return $this->returnError($errors,422);
           }
            $user=User::where("token",$request->token)->first();
            $user->update([
                'is_paid'=>$request->is_paid
            ]);

            return $this->returnData($user);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }    
        
    }
}
