<?php

namespace Modules\Checkout\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
     public function card(Request $request)
    {
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
                $registerOrderData = ['auth_token' => $authtoken,'delivery_needed' => "false",'merchant_id' =>'49046','amount_cents' =>$amount*100,'currency' =>"EGP",'items' =>[]];
                $registerOrderresponse = Http::post($register_order_API_url, $registerOrderData);
                if($registerOrderresponse->getStatusCode()==201 || $registerOrderresponse->getStatusCode()==200){
                    $getorderId=$registerOrderresponse["id"];
                    $payment_keysData = ['auth_token' => $authtoken,'expiration' => "3600",'integration_id' =>'126404',
                        'amount_cents' =>"100",'currency' =>"EGP",'order_id' => $getorderId ,"lock_order_when_paid" => "false",
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
                        $final_url=$card_pay_API_url.'/'.'128169'.'?payment_token='.$pay_token;
                        return redirect()->away($final_url);
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
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('checkout::create');
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
}
