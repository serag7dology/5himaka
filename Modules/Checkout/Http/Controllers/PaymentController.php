<?php

namespace Modules\Checkout\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Modules\User\Entities\User;
use Validator;
use Modules\User\Entities\WalletHistory;
use Modules\User\Entities\WalletHistoryTranslation;
class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('checkout::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
     public function card(Request $request)
    {
        $amount=$request->amount;
        ini_set('max_execution_time', 900);
        $Auth_API_url = "https://accept.paymobsolutions.com/api/auth/tokens";
        $register_order_API_url = "https://accept.paymobsolutions.com/api/ecommerce/orders";
        $payment_keys_API_url = "https://accept.paymobsolutions.com/api/acceptance/payment_keys";
        $card_pay_API_url = "https://accept.paymobsolutions.com/api/acceptance/iframes";
        DB::beginTransaction();
        try{
            $auhtrequestdata = ['api_key' => 'ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2libUZ0WlNJNkltbHVhWFJwWVd3aUxDSndjbTltYVd4bFgzQnJJam8wT1RBME5uMC5xcS1RZDhEbXFjaTZidWo5VGdfWnI5eGZhd1g0QmhNNWo5dnRRblNwS3JWeTROWE90dFdkQTFOTDcyRXRlSXktTzBmNjYxWDhrUzBUcjZBVjQxeTJ6UQ=='];
            $authresponse = Http::post($Auth_API_url, $auhtrequestdata);
            if($authresponse->getStatusCode()==201 || $authresponse->getStatusCode()==200){
                $authtoken=$authresponse["token"]; //get auth token from authentication request
                ////////////////////////////////////////////////////// register order
                ///{
                //  "auth_token":{{from previus step}}",
                //  "delivery_needed": "false",
                //  "merchant_id": "49046",
                //  "amount_cents": "100",
                //  "currency": "EGP",
                //  "items": []
                //}
                ///
                ///
                $registerOrderData = ['auth_token' => $authtoken,'delivery_needed' => "false",'merchant_id' =>'49046','amount_cents' =>$amount*100,'currency' =>"EGP",'items' =>[]
                                            ];
                $registerOrderresponse = Http::post($register_order_API_url, $registerOrderData);

                if($registerOrderresponse->getStatusCode()==201 || $registerOrderresponse->getStatusCode()==200){
                    $getorderId=$registerOrderresponse["id"]; //get order id from order request
                    ////////////////////////////////////////////////////// payment_keys
                    ///{{
                    //  "auth_token":{{from step one}}",
                    //  "amount_cents": "100",
                    //  "expiration": 3600,
                    //  "order_id": {{from previus step}},
                    //  "currency": "EGP",
                    //  "integration_id": {{ from dashboard }},
                    //  "lock_order_when_paid": "false"
                    //}
                    ///
                    $payment_keysData = ['auth_token' => $authtoken,'expiration' => "3600",'integration_id' =>'126404',
                        'amount_cents' =>$amount*100,'currency' =>"EGP",'order_id' => $getorderId ,"lock_order_when_paid" => "false",
                        "billing_data"=> [
                                        "apartment" => "803",
                                        "email"=> "claudette09@exa.com",
                                        "floor"=> "42",
                                        "first_name"=> "Clifford",
                                        "street"=> "Ethan Land",
                                        "building"=> "8028",
                                        "phone_number"=> "+86(8)9135210487",
                                        "shipping_method"=> "PKG",
                                        "postal_code"=> "01898",
                                        "city"=> "Jaskolskiburgh",
                                        "country"=> "CR",
                                        "last_name"=> "Nicolas",
                                        "state"=> "Utah"
                                      ]
                                        ];

                    $payment_keysresponse = Http::post($payment_keys_API_url, $payment_keysData);

                    if($payment_keysresponse->getStatusCode()==201 || $payment_keysresponse->getStatusCode()==200){
                        $pay_token=$payment_keysresponse["token"]; //get pay token from pay  request
//
                        $final_url=$card_pay_API_url.'/'.'128169'.'?payment_token='.$pay_token;
                        return redirect()->away($final_url);
                        }
                        else{
                            return redirect()->back()->with('danger',"error while get payment token");
                            }

                    //                ///
                    //                ///
                    //                ///
                    //                /// ///////////////////////////////////////////////////////
                }else{
                    return redirect()->back()->with('danger', "Register Order Error");
                }
                ///
                ///
                ///
                ///
                /// ///////////////////////////////////////////////////////
            }else{
                return redirect()->back()->with('danger', "Cannot Authenticate Error");
            }


                 DB::commit();
                }catch (\Exception $e) {
                    DB::rollback();
                    return redirect()->back()->with('danger', "Unexpected Error");
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return redirect()->back()->with('danger', "some Thing  Error");
                }
        return view('welcome');
    }
    public function fawry(Request $request){
        try {
       $user =User::find(auth()->id());
       ini_set('max_execution_time', 900);
       $url = "https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/charge";
       $merchantCode    = '1tSa6uxz2nQvR6pbttqFMg==';
       $merchantRefNum  = '2312465464';
       $merchant_cust_prof_id  = $user->id;
       $payment_method = "PAYATFAWRY";
       $amount=$request->amount;
       if(!str_contains($request->amount,'.')){
          $amount= $request->amount.".".'00';
       }
       $merchant_sec_key =  'c07e5cad64bd4f24ab848ba32901f618'; // For the sake of demonstration
        $signature = hash('sha256' , $merchantCode . $merchantRefNum . $merchant_cust_prof_id . $payment_method . $amount . $merchant_sec_key);
    //    $products=json_decode($request->products);
    //    $quantity=json_decode($request->quantity);
    //    $price=json_decode($request->price);
       $items=array();
       $i=0;
    //    foreach ($products as $product ) {
           $items[]=[
               "itemId"=>'1',
               "price"=>'299',
               "quantity"=> '1'
           ];
           $i++;
    //    }
    $mobile='31097643153';
    if($user->mobile!=null){
        $mobile=$user->mobile;
    }
        $fields = [
           "merchantCode"=> $merchantCode,
           "customerName"=> $user->first_name ." ".$user->last_name,
           "customerMobile"=>  $mobile ,
           "customerEmail"=>  $user->email ,
           "customerProfileId"=> $merchant_cust_prof_id,
           "merchantRefNum"=> "2312465464",
           "amount"=>$amount,
           "paymentExpiry" => "1631138400000",
           "currencyCode"=> "EGP",
           "language" => "en-gb",
           "chargeItems"=> $items,
           "signature"=> $signature,
           "paymentMethod"=>  $payment_method,
       ];
          $response = Http::post($url, $fields);
         if($response['statusCode']==201 || $response['statusCode']==200){
             $referenceNumber = $response['referenceNumber'];
            //  return view('checkout::reference',compact('referenceNumber'));
            $request->session()->flash('referenceNumber', $referenceNumber);
            return back();
        //  echo '<div class="row"'.$response['referenceNumber']."  data successfully";
        //  die;
         }
         else{
            return redirect()->back()->with('danger',"error while get payment reference number");

           }
            }catch (\Exception $ex){
                return redirect()->back()->with('danger',$ex);
           }
        
   }
   public function kiosk( Request $request)
    {
        ini_set('max_execution_time', 900);
        $Auth_API_url = "https://accept.paymobsolutions.com/api/auth/tokens";
        $register_order_API_url = "https://accept.paymobsolutions.com/api/ecommerce/orders";
        $payment_keys_API_url = "https://accept.paymobsolutions.com/api/acceptance/payment_keys";
        $kiosh_pay_API_url = "https://accept.paymobsolutions.com/api/acceptance/payments/pay";
        DB::beginTransaction();
        try{

            $auhtrequestdata = ['api_key' =>'ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2libUZ0WlNJNkltbHVhWFJwWVd3aUxDSndjbTltYVd4bFgzQnJJam8wT1RBME5uMC5xcS1RZDhEbXFjaTZidWo5VGdfWnI5eGZhd1g0QmhNNWo5dnRRblNwS3JWeTROWE90dFdkQTFOTDcyRXRlSXktTzBmNjYxWDhrUzBUcjZBVjQxeTJ6UQ=='];
           
            $authresponse = Http::post($Auth_API_url, $auhtrequestdata);
            if($authresponse->getStatusCode()==201 || $authresponse->getStatusCode()==200){
                $authtoken=$authresponse["token"];
                $registerOrderData = ['auth_token' => $authtoken,'delivery_needed' => "false",'merchant_id' =>'49046','amount_cents' =>$request->amount*100,'currency' =>"EGP",'items' =>[]
                ];
                $registerOrderresponse = Http::post($register_order_API_url, $registerOrderData);

                if($registerOrderresponse->getStatusCode()==201 || $registerOrderresponse->getStatusCode()==200){
                    $getorderId=$registerOrderresponse["id"]; 
                    $payment_keysData = ['auth_token' => $authtoken,'expiration' => "3600",'integration_id' =>'138619',
                        'amount_cents' =>$request->amount*100,'currency' =>"EGP",'order_id' => $getorderId ,"lock_order_when_paid" => "false",
                        "billing_data"=> [
                            "apartment" => "803",
                            "email"=> "claudette09@exa.com",
                            "floor"=> "42",
                            "first_name"=> "Clifford",
                            "street"=> "Ethan Land",
                            "building"=> "8028",
                            "phone_number"=> "+86(8)9135210487",
                            "shipping_method"=> "PKG",
                            "postal_code"=> "01898",
                            "city"=> "Jaskolskiburgh",
                            "country"=> "CR",
                            "last_name"=> "Nicolas",
                            "state"=> "Utah"
                        ]
                    ];

                    $payment_keysresponse = Http::post($payment_keys_API_url, $payment_keysData);

                    if($payment_keysresponse->getStatusCode()==201 || $payment_keysresponse->getStatusCode()==200){
                        $pay_token=$payment_keysresponse["token"]; //get pay token from pay  request

                        $kioshData = ['payment_token' => $pay_token,'source' =>[
                            'identifier' => "AGGREGATOR",
                            'subtype' => "AGGREGATOR",
                            ]
                        ];
                        $kiosk_response = Http::post($kiosh_pay_API_url, $kioshData);
                        if($kiosk_response->getStatusCode()==201 || $kiosk_response->getStatusCode()==200){
                            $referenceNumber=$kiosk_response['data']['bill_reference'];
                            $request->session()->flash('referenceNumber', $referenceNumber);
                             return back();
                        }else{

                            return redirect()->back()->with('danger',"error while kiosh payment");
                        }
                    }
                    else{
                        return redirect()->back()->with('danger',"error while get payment token");
                    }
                }else{
                    return redirect()->back()->with('danger', "Register Order Error");
                }
                
            }else{
                return redirect()->back()->with('danger', "Cannot Authenticate Error");
            }


            DB::commit();
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', "Unexpected Error");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('danger', "some Thing  Error");
        }
        return view('welcome');
   
    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('checkout::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('checkout::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function payWithCommission(Request $request)
    {
       $input['amount']=$request->amount;
       $input['wallet_id']=$request->wallet_id;
        $messages = [
            'wallet_id.required' => trans("user::validation.wallet_id.required"),
            'amount.required' => trans("user::validation.amount.required"),
        ];
        $rules = [
            "wallet_id"=>"required",
            "amount"=>"required",
            "real_price"=>"required_if:wallet_id,1",
        ];
        $validator = Validator::make($input, $rules,$messages);

        if ($validator->fails()) {
            $errors=array();     
           foreach ($validator->errors()->getMessages() as $key => $value) {
               $errors[]=$value[0];
           }
        }
        
       // try {
            if($request->amount == 0){
                 $request->session()->flash('error', trans("user::api.amount_err"));
                return back();
           }
           $user=User::where("token",$request->token)->first();            
                if($request->amount > $user->commission_acount)
                {
                    $request->session()->flash('error', trans("user::api.amount_limited"));
                   return back();
                 
                }
                if($request->wallet_id==1)
                {
                $user->commission_acount-=$request->amount;
                $minus_amount=$request->amount;

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
        
               $request->session()->flash('success', trans("user::api.pay_done_successfully"));
               return back();
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
           
               $request->session()->flash('success', trans("user::api.pay_done_successfully"));
               return back();
                }
        // }
        // catch (\Exception $ex){
        //     return $this->returnError($ex->getMessage(),500);
        //    $request->session()->flash('error', $ex->getMessage());
        //    return back();
        // } 
    }
}
