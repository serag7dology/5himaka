<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Core\Http\Traits\GeneralTrait;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderProduct;
use Modules\Product\Entities\Product;
use Modules\User\Entities\Complaint;
use Modules\User\Entities\User;

class ComplaintController extends Controller
{
    use GeneralTrait;
  
     public function getUserOrders(Request $request)
    {
        if(isset($request->token)){
            $user = User::where("token",$request->token)->first();
            if($user==NULL){
                    return $this->returnError([trans("product::products.errors.token_not_found")],404);
                }else{
                    $request->request->add(['user_id' => $user->id]);
                }
        }
        $orders = Order::with(['product'])
        ->where('customer_id',$request->user_id)->where('status','completed')->get();
        if(count( $orders)< 1){
            return $this->returnSuccessMessage(trans("user::api.orders_not_found"), $errNum = "200");
        }
        return $this->returnData(['orders'=>$orders],trans("user::api.orders_saved"));
    }
    // public function getOrdersProducts(Request $request)
    // {
    //     $rules = [
    //         'order_id'      => 'required|exists:orders,id'        ];
    //     $messages = [
    //         'order_id.required'     => trans("user::validation.order_id.required"),
    //         'order_id.exists'       => trans("user::validation.order_id.exists"),
    //     ];
    //     $validator = Validator::make($request->all(), $rules,$messages);
    //     if ($validator->fails()) {
    //         $errors=array();     
    //     foreach ($validator->errors()->getMessages() as $key => $value) {
    //         $errors[]=$value[0];
    //     }
    //     return $this->returnError($errors,422);
    //     }
    //     if(isset($request->token)){
    //         $user = User::where("token",$request->token)->first();
    //         if($user==NULL){
    //                 return $this->returnError([trans("product::products.errors.token_not_found")],404);
    //             }else{
    //                 $request->request->add(['user_id' => $user->id]);
    //             }
    //     }
    //     $orders = Order::with('products')->where('id',$request->order_id)->get();
    //     if(count( $orders)< 1){
    //         return $this->returnSuccessMessage(trans("user::api.orders_not_found"), $errNum = "200");
    //     }
    //     $products_ids= array();
    //     foreach ($orders as $order) {
    //             $product_id=OrderProduct::select('product_id')->where('order_id',$order->id)->get();
    //             array_push($products_ids,$product_id->product_id);
    //     }
    //    $products= Product::find($products_ids);
    //     return $this->returnData(['products'=>$products],trans("user::api.orders_saved"));
    // }
    public function getUserComplaint(Request $request)
    {
        if(isset($request->token)){
            $user = User::where("token",$request->token)->first();
            if($user==NULL){
                    return $this->returnError([trans("product::products.errors.token_not_found")],404);
                }else{
                    $request->request->add(['user_id' => $user->id]);
                }
        }
        $complaints = Complaint::where('user_id',$request->user_id)->get();
        if(count( $complaints)< 1){
            return $this->returnSuccessMessage(trans("user::api.orders_not_found"), $errNum = "200");
        }
        return $this->returnData(['complaints'=>$complaints],trans("user::api.data"));
    }
    public function store(Request $request)
    {
        try {
                $rules = [
                    'product_id'    => 'required|exists:products,id',
                    'order_id'      => 'required|exists:orders,id',
                    'details'       =>'required'
                ];
                $messages = [
                    'product_id.required'   => trans("user::validation.product.required"),
                    'product_id.exists'     => trans("user::validation.product.exists"),
                    'order_id.required'     => trans("user::validation.order_id.required"),
                    'order_id.exists'       => trans("user::validation.order_id.exists"),
                    'details.required'      => trans("user::validation.details.required"),
                ];
                $validator = Validator::make($request->all(), $rules,$messages);
                if ($validator->fails()) {
                    $errors=array();     
                foreach ($validator->errors()->getMessages() as $key => $value) {
                    $errors[]=$value[0];
                }
                return $this->returnError($errors,422);
                }
                if(isset($request->token)){
                        $user = User::where("token",$request->token)->first();
                        if($user==NULL)
                        {
                            return $this->returnError([trans("product::products.errors.token_not_found")],404);
                        }
                        else{
                            $request->request->add(['user_id' => $user->id]);
                        }
                }
                $complaint=Complaint::create($request->all());
                return $this->returnData(['complaint'=>$complaint],trans("user::api.complaint_saved"));

            }catch (\Exception $ex){
                return $this->returnError($ex->getMessage(),500);
            } 
    }
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
