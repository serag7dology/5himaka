<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Http\Traits\GeneralTrait;
use Modules\User\Entities\User;
use Fawry;
use Google\Protobuf\DoubleValue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Support\Money;
use PhpParser\Node\Expr\Cast\Double;
use Ramsey\Uuid\Type\Decimal;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    use GeneralTrait;
    public function getPaymentUrl( Request $request){
         try {

            $messages = [
                'products.required' => trans("user::validation.products.required"),
                'quantity.exists' => trans("user::validation.quantity.exists"),
                'price.required'=> trans("user::validation.price.required"),
                'amount.required'=> trans("user::validation.amount.required"),
            ];
            $rules = [
                'products' => 'required',
                'quantity'=>'required',
                'price' => 'required',
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
           if($request->has('token')){
            $user=User::where("token",$request->token)->first();
                if($user){
                    $user_id=$user->id;
                    $first_name= $user->first_name;
                    $mobile= $user->mobile;
                    $last_name=$user->last_name;
                    $email=$user->email;
                }else{
                    $user_id=1;
                    $first_name='asd';
                    $mobile='asd';
                    $last_name='asd';
                    $email='asd@gmail.com' ;
                   }
               
           }else{
            $user_id=1;
            $first_name='asd';
            $mobile='asd';
            $last_name='asd';
            $email='asd@gmail.com' ;
           }
         
        ini_set('max_execution_time', 900);
        $url = "https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/charge";
        $merchantCode    = '1tSa6uxz2nQvR6pbttqFMg==';
        $merchantRefNum  = '2312465464';
        $merchant_cust_prof_id  = $user_id;
        $payment_method = "PAYATFAWRY";
        $amount=$request->amount;
        if(!str_contains($request->amount,'.')){
           $amount= $request->amount.".".'00';
        }
        $merchant_sec_key =  'c07e5cad64bd4f24ab848ba32901f618'; // For the sake of demonstration
        $signature = hash('sha256' , $merchantCode . $merchantRefNum . $merchant_cust_prof_id . $payment_method . $amount . $merchant_sec_key);
        $products=json_decode($request->products);
        $quantity=json_decode($request->quantity);
        $price=json_decode($request->price);
        $items=array();
        $i=0;
        foreach ($products as $product ) {
            $items[]=[
                "itemId"=>$product,
                "price"=> $price[$i],
                "quantity"=> $quantity[$i]
            ];
            $i++;
        }
        $fields = [
            "merchantCode"=> $merchantCode,
            "customerName"=> $first_name ." ".$last_name,
            "customerMobile"=>  $mobile ,
            "customerEmail"=>  $email ,
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
            return $this->returnData($response['referenceNumber'],"data successfully");
          }
          else{
            return $this->returnError("error while get payment reference number",422);
            }
             }catch (\Exception $ex){
                return $this->returnError($ex,442);
            }
         
    }
    public function card(Request $request)
    {
        $messages = [
            'products.required' => trans("user::validation.products.required"),
            'quantity.exists' => trans("user::validation.quantity.exists"),
            'price.required'=> trans("user::validation.price.required"),
            'amount.required'=> trans("user::validation.amount.required"),
        ];
        $rules = [
            'products' => 'required',
            'quantity'=>'required',
            'price' => 'required',
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
       if($request->has('token')){
        $user=User::where("token",$request->token)->first();
            if($user){
                $user_id=$user->id;
                $first_name= $user->first_name;
                $mobile= $user->mobile;
                $last_name=$user->last_name;
                $email=$user->email;
            }else{
                $user_id=1;
                $first_name='asd';
                $mobile='asd';
                $last_name='asd';
                $email='asd@gmail.com' ;
               }
           
       }else{
        $user_id=1;
        $first_name='asd';
        $mobile='asd';
        $last_name='asd';
        $email='asd@gma';
    }

       $products=json_decode($request->products);
       $quantity=json_decode($request->quantity);
       $price=json_decode($request->price);
       $items=array();
       $i=0;
       foreach ($products as $product ) {
           $items[]=[
               "itemId"=>$product,
               "price"=> $price[$i],
               "quantity"=> $quantity[$i]
           ];
           $i++;
       }
       $items=[];
        ini_set('max_execution_time', 900);
        $Auth_API_url = "https://accept.paymobsolutions.com/api/auth/tokens";
        $register_order_API_url = "https://accept.paymobsolutions.com/api/ecommerce/orders";
        $payment_keys_API_url = "https://accept.paymobsolutions.com/api/acceptance/payment_keys";
        $card_pay_API_url = "https://accept.paymobsolutions.com/api/acceptance/iframes";
        $amount=$request->amount;
        DB::beginTransaction();
        try{
            $auhtrequestdata = ['api_key' => 'ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2libUZ0WlNJNkltbHVhWFJwWVd3aUxDSndjbTltYVd4bFgzQnJJam8wT1RBME5uMC5xcS1RZDhEbXFjaTZidWo5VGdfWnI5eGZhd1g0QmhNNWo5dnRRblNwS3JWeTROWE90dFdkQTFOTDcyRXRlSXktTzBmNjYxWDhrUzBUcjZBVjQxeTJ6UQ=='];
           $authresponse = Http::post($Auth_API_url, $auhtrequestdata);
            if($authresponse->getStatusCode()==201 || $authresponse->getStatusCode()==200){
                $authtoken=$authresponse["token"];
                $registerOrderData = ['auth_token' => $authtoken,'delivery_needed' => "false",'merchant_id' =>'49046','amount_cents' =>$amount*100,'currency' =>"EGP",'items' =>$items
                    ];
                $registerOrderresponse = Http::post($register_order_API_url, $registerOrderData);
            //  $registerOrderresponse->getStatusCode();
                if($registerOrderresponse->getStatusCode()==201 || $registerOrderresponse->getStatusCode()==200){
                     $getorderId=$registerOrderresponse["id"];       
                    $payment_keysData = ['auth_token' => $authtoken,'expiration' => "3600",'integration_id' =>'126404',
                        'amount_cents' =>$amount*100,'currency' =>"EGP",'order_id' => $getorderId ,"lock_order_when_paid" => "false",
                        "billing_data"=> [
                                    "apartment" => "803",
                                    "email"=> $email,
                                    "floor"=> "42",
                                    "first_name"=> $first_name,
                                    "street"=> "Ca",
                                    "building"=>"Ca",
                                    "phone_number"=> $mobile,
                                    "shipping_method"=> "free",
                                    "postal_code"=> "01898",
                                    "city"=> "Ca",
                                    "country"=>"Ca",
                                    "last_name"=> $last_name,
                                    "state"=> "Ca"
                                      ]
                            ];
                    $payment_keysresponse = Http::post($payment_keys_API_url, $payment_keysData);
                    if($payment_keysresponse->getStatusCode()==201 || $payment_keysresponse->getStatusCode()==200){
                        $pay_token=$payment_keysresponse["token"]; //get pay token from pay  request
                    $final_url=$card_pay_API_url.'/'.'128169'.'?payment_token='.$pay_token;
                    return $this->returnData($final_url,"data successfully");
                        }
                        else{
                            return response()->json([
                                'status' => false,
                                'errors' =>"error while get payment token"
                            ],422);
                            }

                    //                ///
                    //                ///
                    //                ///
                    //                /// ///////////////////////////////////////////////////////
                }else{
                    return response()->json([
                        'status' => false,
                        'errors' =>"Register Order Error"
                    ],422);
                }
                ///
                ///
                ///
                ///
                /// ///////////////////////////////////////////////////////
            }else{
                return response()->json([
                    'status' => false,
                    'errors' =>"Cannot Authenticate Error"
                ],422);
            }


                 DB::commit();
                }catch (\Exception $e) {
                    DB::rollback();
                    return response()->json([
                        'status' => false,
                        'errors' =>"Unexpected Error"
                    ],422);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'errors' =>"some Thing  Error"
                    ],422);
                }
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function kiosk(Request $request)
    {
        $messages = [
            'products.required' => trans("user::validation.products.required"),
            'quantity.exists' => trans("user::validation.quantity.exists"),
            'price.required'=> trans("user::validation.price.required"),
            'amount.required'=> trans("user::validation.amount.required"),
        ];
        $rules = [
            'products' => 'required',
            'quantity'=>'required',
            'price' => 'required',
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
       if($request->has('token')){
        $user=User::where("token",$request->token)->first();
            if($user){
                $user_id=$user->id;
                $first_name= $user->first_name;
                $mobile= $user->mobile;
                $last_name=$user->last_name;
                $email=$user->email;
            }else{
                $user_id=1;
                $first_name='asd';
                $mobile='asd';
                $last_name='asd';
                $email='asd@gmail.com' ;
               }
           
       }else{
        $user_id=1;
        $first_name='asd';
        $mobile='asd';
        $last_name='asd';
        $email='asd@gma';
    }

       $products=json_decode($request->products);
       $quantity=json_decode($request->quantity);
       $price=json_decode($request->price);
       $items=array();
       $i=0;
       foreach ($products as $product ) {
           $items[]=[
               "itemId"=>$product,
               "price"=> $price[$i],
               "quantity"=> $quantity[$i]
           ];
           $i++;
       }
       $items=[];
        ini_set('max_execution_time', 900);
        $Auth_url = "https://accept.paymobsolutions.com/api/auth/tokens";
        $register_url = "https://accept.paymobsolutions.com/api/ecommerce/orders";
        $payment_keys_API_url = "https://accept.paymobsolutions.com/api/acceptance/payment_keys";
        $kiosh_pay_API_url = "https://accept.paymobsolutions.com/api/acceptance/payments/pay";
        DB::beginTransaction();
        try{

            $auhtrequest = ['api_key' => 'ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2libUZ0WlNJNkltbHVhWFJwWVd3aUxDSndjbTltYVd4bFgzQnJJam8wT1RBME5uMC5xcS1RZDhEbXFjaTZidWo5VGdfWnI5eGZhd1g0QmhNNWo5dnRRblNwS3JWeTROWE90dFdkQTFOTDcyRXRlSXktTzBmNjYxWDhrUzBUcjZBVjQxeTJ6UQ=='];
            $authresponse = Http::post($Auth_url, $auhtrequest);
            if($authresponse->getStatusCode()==201 || $authresponse->getStatusCode()==200){
                 $authtoken=$authresponse["token"]; 
                $registerOrder = ['auth_token' => $authtoken,'delivery_needed' => "false",'merchant_id' => '49046',
                    'amount_cents' =>'100','currency' =>"EGP",'items' =>$items
                ];
                 $registerOrderresponse = Http::post($register_url, $registerOrder);
                if($registerOrderresponse->getStatusCode()==201 || $registerOrderresponse->getStatusCode()==200){
                     $getorderId=$registerOrderresponse["id"];
                    $payment_keysData = ['auth_token' => $authtoken,'expiration' => "3600",'integration_id' =>'138619',
                        'amount_cents' =>100,'currency' =>"EGP",'order_id' => $getorderId ,"lock_order_when_paid" => "false",
                            "billing_data"=> [
                                "apartment" => "803",
                                "email"=> $email,
                                "floor"=> "42",
                                "first_name"=> $first_name,
                                "street"=> "Ca",
                                "building"=>"Ca",
                                "phone_number"=> $mobile,
                                "shipping_method"=> "free",
                                "postal_code"=> "01898",
                                "city"=> "Ca",
                                "country"=>"Ca",
                                "last_name"=> $last_name,
                                "state"=> "Ca"
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
                            return $this->returnData($kiosk_response['data']['bill_reference']," Data Retrieved  Successfully");
                                    // dd('Pending '.$kiosk_response['pending'].' =================> success '.$kiosk_response['success'].' =================> bill_reference '.$kiosk_response['data']['bill_reference']);
                        }else{
                            return response()->json([
                                'status' => false,
                                'errors' =>"error while kiosh payment"
                            ],422);
                        }
                    }
                    else{
                        return response()->json([
                            'status' => false,
                            'errors' =>"error while get payment token"
                        ],422);
                    }

                    //                ///
                    //                ///
                    //                ///
                    //                /// ///////////////////////////////////////////////////////
                }else{
                    return response()->json([
                        'status' => false,
                        'errors' =>"Register Order Error"
                    ],422);
                    return redirect()->back()->with('danger', "");
                }
                ///
                ///
                ///
                ///
                /// ///////////////////////////////////////////////////////
            }else{
                return response()->json([
                    'status' => false,
                    'errors' =>"Cannot Authenticate Error"
                ],422);
            }


            DB::commit();
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'errors' =>"Unexpected Error"
            ],422);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'errors' =>"some Thing  Error"
            ],422);
        }
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
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('user::edit');
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
}
