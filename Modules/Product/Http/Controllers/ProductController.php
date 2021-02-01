<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Review\Entities\Review;
use Modules\Product\Entities\Product;
use Modules\Category\Entities\Category;
use Modules\User\Entities\Chat;
use Modules\User\Entities\User;
use Modules\Product\Events\ProductViewed;
use Modules\Product\Filters\ProductFilter;
use Modules\Product\Http\Middleware\SetProductSortOption;
use Illuminate\Http\Request;
use Modules\Product\Entities\Firestore;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use DB;
use Validator;
use Modules\Core\Http\Traits\GeneralTrait;


class ProductController extends Controller
{
    use ProductSearch;
    use GeneralTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(SetProductSortOption::class)->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Modules\Product\Entities\Product $model
     * @param \Modules\Product\Filters\ProductFilter $productFilter
     * @return \Illuminate\Http\Response
     */
    public function index(Product $model, ProductFilter $productFilter)
    {
        if (request()->expectsJson()) {
            return $this->searchProducts($model, $productFilter);
        }

        return view('public.products.index');
    }

    /**
     * Show the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::findBySlug($slug);

        $services=$this->checkService($product->id);

        $relatedProducts = $product->relatedProducts()->forCard()->get();
        $upSellProducts = $product->upSellProducts()->forCard()->get();
        $review = $this->getReviewData($product);

        event(new ProductViewed($product));

        return view('public.products.show', compact('product', 'relatedProducts', 'upSellProducts', 'review','services'));
    }

    public function checkService($id)
    {
        try {
             $categories=DB::table('product_categories')->select('category_id')->where('product_id',$id)->get()->toArray();
            if(count( $categories)<1){
                return "there is no category";

            }
            foreach ($categories as  $key=>$value) {
                $category=Category::find($value->category_id);
                while ($category->parent_id !=null) {
                    $category=Category::find($category->parent_id);
                }
            }
          if($category){
            if($category->parent_id ==null){
                if($category->id !=2){
                    return false;
                }else{
                    return true;
                }
            }
          }
          return false;
            
        }  
        catch (\Exception $ex){
            return false;
        }
    }
    
    public function chat($id)
    {

        $product = Product::find($id);
        if($product->user_id == auth()->user()->id){
            $product_chats = DB::table('chats')->join('products','products.id','chats.product_id')->where('product_id',$id)->get();
            $own_product = true;
        }else{
            if((Float)auth()->user()->commission_acount < (Float)$product->amount){
                $request->session()->flash('error', "Sorry, your balance is not enough to open chat");
                return back();
            }
            $product_chats = DB::table('chats')->join('products','products.id','chats.product_id')->where('product_id',$id)->where('sender_id',auth()->user()->id)->get();
            $own_product = false;
        }
       // dd($product_chats);
        $ids = DB::table('chats')->join('products','products.id','chats.product_id')->where('sender_id',auth()->user()->id)->orderBy('chats.created_at')->pluck("product_id")->toArray();
        $all_products =Product::with(['attributes','brand','options','tags','reviews'])->where("is_active",1)->whereIn("id",$ids)->get();
        $found=true;
        if(!in_array($id,$ids)){
            $found=false;
        }
       
        $product_id=$id;
        
        return view('public.products.chat', compact('product_chats','product_id','all_products','found','product','own_product'));
    }
 
    public function createchat(Request $request){
        $user = Product::find($request->product_id);
        if($user->user_id != null){
            $admin=DB::table('user_roles')->where('role_id',1)->first();
            $reciver = $admin->user_id;
        }else{
            $owned= false;
            $reciver = $user->user_id;
        }
        $time=strtotime(date('H:m:s'));
        $firestore_data  = [
            "content" => ["stringValue" => $request->message],
            "idFrom" => ["stringValue" => (String)auth()->user()->id],
            "idTo" => ["stringValue" => (String)$reciver],
            "isread" => ["booleanValue" => false],
            "timestamp" => ["integerValue" =>$time],
            "type" => ["stringValue" =>"text"],
        ];
        $sender_reciver=auth()->user()->id.'-'.$reciver;
        $data = ["fields" => (object)$firestore_data];
        $json = json_encode($data);
        $firestore_key = "AIzaSyCERNG7EKI6NHQFJUmLUi2Pqwu5gbwTjr4";
        $project_id = "chat-a378a";  
        $url = "https://firestore.googleapis.com/v1beta1/projects/chat-a378a/databases/(default)/documents/chatroom/".$sender_reciver."/".$sender_reciver."/".$time;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array('Content-Type: application/json',
                'Content-Length: ' . strlen($json),
                'X-HTTP-Method-Override: PATCH'),
            CURLOPT_URL => $url . '?key='.$firestore_key,
            CURLOPT_USERAGENT => 'cURL',
            CURLOPT_POSTFIELDS => $json
        ));
        $response = curl_exec( $curl );
        curl_close( $curl );
        return response()->json($response);
      
    //     $type=1;
    //     $input = $request->all();
    //     $product = Product::find($input['product_id']);
    //     $sender_id=auth()->user()->id;

    //     if($product->user_id == auth()->user()->id){
    //         $type=0;
    //         $sender_id= $input['sender_id'];
    //     }
    //     $message = $input['message'];
    //     $chat = new Chat([
    //         'sender_id' => $sender_id,
    //         'product_id' => $input['product_id'],
    //         'message' => $message,
    //         'type' => $type,
    //     ]);
    //     $chat->save();
    //     $this->broadcastMessage($input['product_id'],$message,$sender_id,$type);
    //     echo json_encode($input);
    //   return response()->json($input);
  }
    private function broadcastMessage($product_id,$message,$sender_id,$type){
      $optionBuilder = new OptionsBuilder();
      $optionBuilder->setTimeToLive(60*20);
      
      $notificationBuilder = new PayloadNotificationBuilder('New Message from '.auth()->user()->name);
      $notificationBuilder->setBody($message)
                          ->setSound('default')
                          ->setClickAction('http://localhost:3000/');
      $dataBuilder = new PayloadDataBuilder();
      $user_id = Product::find($product_id);
      if($user_id->user_id == auth()->user()->id){
        $user = $sender_id;
        $owned= true;
     }else{
          $owned= false;
          $user = $user_id->user_id;
      }
      $dataBuilder->addData([
          'created_at' => date('Y-m-d H:i:s'),
          'message' =>$message,
          'sender_id' =>$sender_id,
          'type' =>$type,
          'owned' =>$owned,
          ]);
      $option = $optionBuilder->build();
      $notification = $notificationBuilder->build();
      $data = $dataBuilder->build();
  
      $tokens = User::find($user)->pluck('fcm_token')->toArray();
      $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
      return $downstreamResponse->numberSuccess();
  }

    public function acceptPrice(Request $request){

         try {
            $messages = [
                'product_id.required' => trans("product::validation.product_id.required"),
                'new_price.required'=>  trans("product::validation.new_price.required"),
            ];
            $rules = [
                'product_id' => 'required',
                'new_price'=>'required',
            ];
            $validator = Validator::make($request->all(), $rules,$messages);
            if ($validator->fails()) {
                $errors=array();     
               foreach ($validator->errors()->getMessages() as $key => $value) {
                   $errors[]=$value[0];
               }
               return $this->returnError($errors,422);

           }
            if(isset($request->token))
            {
               $user = User::where("token",$request->token)->first();
               if($user==NULL)
               {
                   return $this->returnError([trans("product::products.errors.token_not_found")],404);
               }
            }
            $is_found=NewPrice::where('product_id',$request->item_id)->where('user_id', $user->id)->where('status',1)->get();
           if(count($is_found)> 0){
            return $this->returnError([trans("product::products.errors.price_changed")],404);
           }
            $categories=DB::table('product_categories')->select('category_id')->where('product_id',$request->item_id)->get()->toArray();
            if(count( $categories)<1){
                return $this->returnError([trans("product::products.errors.no_category")],404);
            }
          foreach ($categories as  $key=>$value) {
             $category=Category::find($value->category_id);
                while ($category->parent_id !=null) {
                    $category=Category::find($category->parent_id);
                }
          }
          if($category){
            if($category->parent_id ==null){
                if($category->id !=2){
                    return $this->returnError([trans("product::api.price_changed_only_to_services")],404);
                }else{
                    $product=Product::find($request->item_id);
                    $user_wanted_price = $request->new_price * (10/100);
                    $product_limit_price = $product->selling_price->amount() * (10/100);
                       $product->selling_price->amount();
                    $user_commission=$user->commission_acount;
                    if(  !$user_commission >=  $product->selling_price->amount()){
                       return $this->returnError([trans("product::api.commission_account")],404);
                      }
               //    if new price less than item price of 10% price can not be changed
                  if( $user_wanted_price <  $product_limit_price){
                   return $this->returnError([trans("product::products.errors.price_changed")],404);
                  }
                   $new_price=new NewPrice;
                   $new_price->user_id=$user->id;
                   $new_price->product_id=$request->item_id;
                   $new_price->status=1;
                   $new_price->new_price=$request->new_price;
                   $new_price->save();
               return $this->returnData(['user_special_price'=>$new_price],trans("product::api.data_added_successfully")); 
                }
            }
          }else
          return $this->returnError([trans("product::api.price_changed_only_to_services")],404);

            
        }  
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }

    }

    private function getReviewData(Product $product)
    {
        if (! setting('reviews_enabled')) {
            return;
        }

        return Review::countAndAvgRating($product);
    }
}
