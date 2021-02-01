<?php

namespace Modules\Order\Http\Controllers\Api;

use Modules\User\Entities\User;

use Modules\Core\Http\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Order\Entities\Order;
use Modules\Order\Http\Requests\StoreOrderRequest;
use Modules\Support\Country;
use Illuminate\Validation\Rule;
use Modules\Order\Entities\OrderProduct;
use Modules\Payment\Facades\Gateway;
use Modules\Product\Entities\NewPrice;
use Modules\Shipping\Facades\ShippingMethod;
use Modules\Product\Entities\Product;
use Modules\Support\State;
use Modules\User\Entities\WalletHistory;
use Modules\User\Entities\WalletHistoryTranslation;

class OrderController 
{

    use GeneralTrait;
    

    public function order(Request $request)
    {
        try{
        $messages = [
            'customer_email.required' => trans("order::validation.customer_email.required"),
            'customer_email.email' => trans("order::validation.customer_email.email"),
            'billing_first_name.required'=> trans("order::validation.billing_first_name.required"),
            'billing_last_name.required'=> trans("order::validation.billing_last_name.required"),
            'billing_address_1.required'=>  trans("order::validation.billing_address_1.required"),
            'billing_city.required'=> trans("order::validation.billing_city.required"),
            'billing_zip.required'=> trans("order::validation.billing_zip.required"),
            'billing_country.required'=>  trans("order::validation.billing_country.required"),
            'billing_country.in'=>  trans("order::validation.billing_country.in"),
            'billing_state.required'=> trans("order::validation.billing_state.required"),
            'create_an_account.boolean'=>trans("order::validation.create_an_account.boolean"),
            'password.required_if' => trans("order::validation.create_an_account.required_if"),
            'ship_to_different_address.boolean' => trans("order::validation.ship_to_different_address.boolean"),
            'shipping_first_name.required_if'=> trans("order::validation.shipping_first_name.required_if"),
            'shipping_last_name.required_if'=>  trans("order::validation.shipping_last_name.required_if"),
            'shipping_address_1.required_if'=> trans("order::validation.shipping_last_name.required_if"),
            'shipping_city.required_if'=> trans("order::validation.shipping_city.required_if"),
            'shipping_zip.required_if'=>  trans("order::validation.shipping_zip.required_if"),
            'shipping_country.required_if'=> trans("order::validation.shipping_country.required_if"),
            'shipping_state.required_if'=> trans("order::validation.shipping_state.required_if"),
            // 'payment_method.required'=> trans("order::validation.payment_method.required"),
            'shipping_method.required'=> trans("order::validation.shipping_method.required"),
            'terms_and_conditions.accepted'=>trans("order::validation.terms_and_conditions.accepted"),
            'products.required'=> trans("order::validation.products.required"),
            'transaction_id.required'=> trans("order::validation.transaction_id.required"),
        ];
        $rules =[
            'customer_email' => ['required', 'email'],
            'billing_first_name' => 'required',
            'billing_last_name' => 'required',
            'billing_address_1' => 'required',
            'billing_city' => 'required',
            'billing_zip' => 'required',
            'billing_country' => ['required', Rule::in(Country::supportedCodes())],
            'billing_state' => 'required',
            'create_an_account' => 'boolean',
            'password' => 'required_if:create_an_account,1',
            'ship_to_different_address' => 'boolean',
            'shipping_first_name' => 'required_if:ship_to_a_different_address,1',
            'shipping_last_name' => 'required_if:ship_to_a_different_address,1',
            'shipping_address_1' => 'required_if:ship_to_a_different_address,1',
            'shipping_city' => 'required_if:ship_to_a_different_address,1',
            'shipping_zip' => 'required_if:ship_to_a_different_address,1',
            'shipping_country' => ['required_if:ship_to_a_different_address,1', Rule::in(Country::supportedCodes())],
            'shipping_state' => 'required_if:ship_to_a_different_address,1',
            // 'payment_method' => ['required'],
            'shipping_method' => ['required', Rule::in(ShippingMethod::names())],
            'terms_and_conditions' => 'accepted',
            'products'=>'required',
            'transaction_id'=>'required'

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

        $data=$request->except(['token','ship_to_different_address','terms_and_conditions','products','price','price_after_commision','quantity']);
        $data["customer_id"]=$user->id;
        $data['customer_first_name']=$request->billing_first_name;
        $data['customer_last_name']=$request->billing_last_name;
        if(!isset($request->ship_to_different_address) || $request->ship_to_different_address==0)
        {
            $data['shipping_first_name']=$request->billing_first_name;
            $data['shipping_last_name']=$request->billing_last_name;
            $data['shipping_address_1']=$request->billing_address_1;
            if(isset($request->billing_address_2))
            {
                $data['shipping_address_2']=$request->billing_address_2;

            }
            $data['shipping_city']=$request->billing_city;
            $data['shipping_country']=$request->billing_country;
            $data['shipping_zip']=$request->billing_zip;
            $data['shipping_state']=$request->billing_state;
        }
        $sub_total=0;
        $deduct_from_commision=0;
        $products_ids=json_decode($request->products);
        $quantity=json_decode($request->quantity);
        $price=json_decode($request->price);
        $price_after_commision=json_decode($request->price_after_commision);
        $j=0;
        foreach ($price_after_commision as $price_commision) {
            $sub_total+=$price_commision;
            $deduct_from_commision+=($price[$j]-$price_commision);
            $j++;
        }
        $user->commission_acount-=$deduct_from_commision;
        $user->personal_acount+=$deduct_from_commision;
        //$user->save();
        $data['sub_total']=$sub_total;
        $data['shipping_cost']=0;
        $data['discount']=0;
        $data['total']=$sub_total;
        if(!isset($request->currency))
        {
            $data['currency']='USD';
        }
        $data['currency_rate']=1;
        if(isset($request->lang))
        $data['locale']=$request->lang;
        else
        $data['locale']='en';

        $data['status']='pending';
        $i=0;
        $order=Order::create($data);
        foreach ($products_ids as $product) {
            $prod=Product::find($product);
            if($prod){
            if($prod->user_id!=NULL)
                {
                    $product_user=User::find($prod->user_id);
                    $product_user->profit_acount+=($price_after_commision[$i]*$quantity[$i]);
                    $product_user->save();
                }
            }
            OrderProduct::create([
                'order_id'  =>$order->id,
                'product_id' => $product,
                'unit_price' => $price_after_commision[$i],
                'qty' => $quantity[$i],
                'line_total' => $price_after_commision[$i]*$quantity[$i],
            ]);
            $i++;
        }
        // DB::table('transactions')->insert([
        //     'transaction_id' => $request->transaction_id,
        //     'payment_method' => $$request->payment_method,
        //     'order_id'  =>$
        // ]);
        $order->transaction()->create([
            'transaction_id' => $request->transaction_id,
          //  'payment_method' => $request->payment_method,
        ]);
       $order->sub_total_amount= $order->sub_total->amount();
       $order->shipping_cost_amount=$order->shipping_cost->amount();
       $order->discount_amount=$order->discount->amount();
        $order->total_amount=$order->total->amount();
       $order->products=$order->products;
       foreach ($order->products as $product) {
           $product->price=$product->unit_price->amount();
           $product->total_price=$product->line_total->amount();
           $product->name=$product->product->name;
       }
    //    $details = ['user_from'=>$user->id,'user_to'=>$user->id,'operation_type_en'=>'Transfer  from profit account to personal account','operation_type_ar'=>' التحويل من حساب الهدايا الى الحساب الشخصى','wallet_to' =>'personal_acount'];
    //    WalletHistory::create([
    //        'wallet_id'       => $user->id,
    //        'wallet_type'     => 'profit_acount',
    //        'amount_spent'    => $request->amount,
    //        'current_total'   => $user->profit_acount-$request->amount,
    //        'pervious_total'  => $user->profit_acount,
    //        'details'         => json_encode($details),
    //    ]);
     return $this->returnData(['order'=>$order]);
    }catch (\Exception $ex){
        return $this->returnError($ex->getMessage(),500);
    }
    }
    public function details(Request $request)
    {
        $messages = [
            'order_id.required' => trans("order::validation.order_id.required"),
            'order_id.exists' => trans("order::validation.order_id.exists"),
            
        ];
        $rules =[
            
            'order_id' => 'required|exists:orders,id',
            
        ];
        $validator = Validator::make($request->all(), $rules,$messages);

        if ($validator->fails()) {
            $errors=array();     
           foreach ($validator->errors()->getMessages() as $key => $value) {
               $errors[]=$value[0];
           }
           return $this->returnError($errors,422);

       }
       $order=Order::find($request->order_id);
       $order->sub_total_amount= $order->sub_total->amount();
       $order->shipping_cost_amount=$order->shipping_cost->amount();
       $order->discount_amount=$order->discount->amount();
       $order->total_amount=$order->total->amount();
       $order->products=$order->products;
       foreach ($order->products as $product) {
           $product->price=$product->unit_price->amount();
           $product->total_price=$product->line_total->amount();
           $product->name=$product->product->name;
       }
       return $this->returnData(['order'=>$order]);
    }
    public function pre_order(Request $request)
    {

      $user=User::where("token",$request->token)->first();
      if(setting('min_commission_to_purchasing_and_selling')>$user->commission_acount)
      {
          $canPurchasing=false; 
      }
      else
      {
        $canPurchasing=true; 
      }
      $countries= Country::supported();
      $countries_ret=array();
      $states_ret=array();
      $states_key=array() ;
      $shipping_methods=array() ;
      foreach ($countries as $key=>$value) {
        $states_key[]=  $key;
       
         
           $states_key=State::get($key);
           if($states_key){
            foreach ($states_key as $key1=> $value1) {
                $states_ret[]=array("id"=>$key1,"name"=>$value1);
             }
            }
             $countries_ret[]=array("id"=>$key,"name"=>$value ,'states'=>$states_ret);  
             $states_ret=array();
    }
    $shipping = ShippingMethod::names();
    foreach ($shipping as $value) {
        $shipping_methods[]=array("id"=>$value,"name"=>"Free Shipping" ,'cost'=>0);
    }
      $payment_methods=array(array("id"=>'cod',"name"=>"Cash On Delivery"),array("id"=>'faw',"name"=>"Fawry Payment"));
    //  $shipping_methods=array(array("name"=>"Free Shipping",'cost'=>0));
      return $this->returnData(['countries'=>$countries_ret,'payment_methods'=>$payment_methods,"shipping_methods"=>$shipping_methods,'canPurchasing'=>$canPurchasing]);
    }
    public function checkCommissionAmount(Request $request)
    {
        $messages = [
            'price.required' => trans("order::validation.price.required"),
            'price.numeric' => trans("order::validation.price.numeric"),
            
        ];
        $rules =[
            'price' => 'required|numeric',
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
        if($request->price>$user->commission_acount)
        {
            $commission_acount=false; 
        }
        else
        {
            $commission_acount=true; 

        }
        if($request->price>$user->personal_acount)
        {
            $personal_acount=false; 
        }
        else
        {
            $personal_acount=true; 

        }
        $price=null;
        if($request->has('id')){
            $user=User::where('token',$request->token)->first();
          $product=NewPrice::where('product_id',$request->id)->where('user_id',$user->id)->first();
            if($product){
                 if(  $product->new_price!=null){
                    $price= $product->new_price->amount;
                    if($price>$user->commission_acount)
                    {
                        $commission_acount=false; 
                    }
                    else
                    {
                        $commission_acount=true; 
                    }
                        if($price>$user->personal_acount){
                            $personal_acount=false; 
                        } else
                        {
                            $personal_acount=true; 
                
                        }
                 }else{
                     $price=null;
                 }
            }
            else{
                $price=null;
            }
        }
        return $this->returnData(['commission_acount'=>$commission_acount,'personal_acount'=>$personal_acount,'price'=>$price]);
    }
    public function payWithCommission(Request $request)
    {
        $messages = [
            'wallet_id.required' => trans("user::validation.wallet_id.required"),
            'amount.required' => trans("user::validation.amount.required"),
            'real_price.required_if' => trans("user::validation.real_price.required_if"),
        ];
        $rules = [
            "wallet_id"=>"required",
            "amount"=>"required",
            "real_price"=>"required_if:wallet_id,1",
        ];
        $validator = Validator::make($request->all(), $rules,$messages);

        if ($validator->fails()) {
            $errors=array();     
           foreach ($validator->errors()->getMessages() as $key => $value) {
               $errors[]=$value[0];
           }
           return $this->returnError($errors,422);

       }

        try {
           if($request->amount == 0){
                return $this->returnError([trans("user::api.amount_err")],422); 
           }
            $user=User::where("token",$request->token)->first();            
                if($request->amount > $user->commission_acount)
                {
                    return $this->returnError([trans("user::api.amount_limited")],422); 
                }
                if($request->wallet_id==1)
                {
                $real_price= $request->real_price;
                $user->commission_acount-=$request->amount;
                $minus_amount=$real_price-$request->amount;
                $user->commission_acount-=$minus_amount;
                $user->cachback_caccount+= $minus_amount;
                $wallet_history  = WalletHistory::create([
                    'wallet_id'       => $user->id,
                    'wallet_type'     => 'commission_acount',
                    'wallet_type_from'=> 'cachback_caccount',
                    'amount_spent'    => $request->amount,
                    'current_total'   => $user->commission_acount,
                    'pervious_total'  =>  $user->commission_acount-$request->amount,
                    'user_id_from'    => $user->id, 
                    'user_id_to'      => $user->id
                ]);
                WalletHistoryTranslation::create([
                    'wallet_history_id'     => $wallet_history->id,
                    'operation_type'        =>'الدفع لشراء طلب',
                    'locale'                =>'ar'

                ]);
                WalletHistoryTranslation::create([
                    'wallet_history_id' => $wallet_history->id,
                    'operation_type'    =>'Pay for order',
                    'locale'            =>'en'

                ]);
                $user->save();
                return $this->returnData(["user"=>$user],trans('user::api.pay_done_successfully'));
                }
                if($request->wallet_id==2)
                {
                $user->personal_acount-= $request->amount;
                $wallet_history  = WalletHistory::create([
                    'wallet_id'       => $user->id,
                    'wallet_type'     => 'personal_acount',
                    'wallet_type_from'=> 'personal_acount',
                    'amount_spent'    => $request->amount,
                    'current_total'   => $user->personal_acount,
                    'pervious_total'  =>  $user->personal_acount-$request->amount,
                    'user_id_from'    => $user->id, 
                    'user_id_to'      => $user->id
                ]);
                WalletHistoryTranslation::create([
                    'wallet_history_id'     => $wallet_history->id,
                    'operation_type'        =>'الدفع لشراء طلب',
                    'locale'                =>'ar'

                ]);
                WalletHistoryTranslation::create([
                    'wallet_history_id' => $wallet_history->id,
                    'operation_type'    =>'Pay for order',
                    'locale'            =>'en'

                ]);
                $user->save();
                return $this->returnData(["user"=>$user],trans('user::api.pay_done_successfully'));
                }
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        } 
    }
}
