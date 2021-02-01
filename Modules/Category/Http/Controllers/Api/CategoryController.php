<?php

namespace Modules\Category\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\User\Entities\User;
use Modules\Setting\Entities\Setting;
use Modules\Product\Entities\Product;

use Modules\Core\Http\Traits\GeneralTrait;
use Validator;
use DB;
class CategoryController extends Controller
{
    use GeneralTrait;

    public function PrepAddProdouctOrService(Request $request)
    {
        $categories=Category::treeList();
        $products=array();
        $services=array();
        foreach ($categories as $key => $value) {
             if($key==1 || $key==2)
             {
                 continue;
             }
             $cat_id=$key;
            while(true)
            {
                $parent=Category::find($cat_id);
                if($parent->parent_id==NULL)
                {
                    if($parent->id==1)
                    {
                        $products[]=array("id"=>$key,"name"=>$value);
                    }
                    elseif($parent->id==2)
                    {
                        $services[]=array("id"=>$key,"name"=>$value);
                    }
                  break;
                }
                $cat_id=$parent->parent_id;
            }   
        }  
         $delivery_info['5himaka']= Setting::where("key","5himaka")->first()->value;
         $delivery_info['delivery_information']= Setting::where("key","delivery_info")->first()->value;
         $delivery_info['return_policy']= Setting::where("key","return_policy")->first()->value;

        return $this->returnData(['products'=>collect($products),'services'=>collect($services),'delivery_info'=>$delivery_info]);

    }
    public function getCategories(Request $request)
    {
        try {

            if(isset($request->token))
            {
                $user = User::where("token",$request->token)->first();
                if($user==NULL)
                {
                    return $this->returnError([trans("product::products.errors.token_not_found")],404);
                }
            }
            $messages = [
                'category_id.required' => trans("category::validation.category_id.required"),

            ];
            $rules = [
                'category_id' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules,$messages);
            if ($validator->fails()) {
                $errors=array();     
               foreach ($validator->errors()->getMessages() as $key => $value) {
                   $errors[]=$value[0];
               }
               return $this->returnError($errors,422);
           }
            $MainCategories = Category::with('files')->where("parent_id",$request->category_id)->get();
            foreach ($MainCategories as $item) {
                $item->sub_categories = Category::with('files')->where("parent_id",$item->id)->get();
            }
            $delivery_info['5himaka']= Setting::where("key","5himaka")->first()->value;
            $delivery_info['delivery_information']= Setting::where("key","delivery_info")->first()->value;
            $delivery_info['return_policy']= Setting::where("key","return_policy")->first()->value;

            return $this->returnData(['MainCategories'=>$MainCategories,'delivery_info'=>$delivery_info]);

        }catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }
    }
    public function getProducts(Request $request)
    {
        try {

            if(isset($request->token))
            {
                $user = User::where("token",$request->token)->first();
                if($user==NULL)
                {
                    return $this->returnError([trans("product::products.errors.token_not_found")],404);
                }
            }
            $messages = [
                'category_id.required' => trans("category::validation.category_id.required"),

            ];
            $rules = [
                'category_id' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules,$messages);

            if ($validator->fails()) {
                $errors=array();     
               foreach ($validator->errors()->getMessages() as $key => $value) {
                   $errors[]=$value[0];
               }
               return $this->returnError($errors,422);

           }

            $skip=0;
            if(isset($request->page))
            {    
                //4*0=0
                //4*1=4
                $skip=10*$request->page;
            }
            
             $ProductsIDs = DB::table('product_categories')
            ->select('product_id')
            ->where('category_id', $request->category_id)
            ->pluck('product_id');

         $products=Product::with(['attributes','brand','options','tags','reviews'])->whereIn('id',$ProductsIDs)->where("is_active",1)->orderBy('id','DESC')->get();

         $count=count($products);
         
         $products=Product::with(['attributes','brand','options','tags','reviews'])->whereIn('id',$ProductsIDs)->where("is_active",1)->orderBy('id','DESC')->skip($skip)->take(10)->get();
         
         
         foreach ($products as $item) {
             if(isset($user))
             {
                $wishlist=$user->wishlistHas($item->id);
                if($wishlist)
                {
                    $item->is_wishlist=true;
                }
                else
                {
                    $item->is_wishlist=false;
                }
             }
            $item->description=strip_tags($item->description);
            $item->old_price=json_decode($item->price);
            $item->new_price=json_decode($item->selling_price);
            $item->main_image=$item->base_image["path"];
            $images=array();
            foreach ($item->files as $image) {
                $images[]=$image["path"];
            }
            $item->images=$images;
         }
                
            
            $delivery_info['5himaka']= Setting::where("key","5himaka")->first()->value;
            $delivery_info['delivery_information']= Setting::where("key","delivery_info")->first()->value;
            $delivery_info['return_policy']= Setting::where("key","return_policy")->first()->value;

            return $this->returnData(['products'=>$products,'total'=>$count,'delivery_info'=>$delivery_info]);

        }catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }
    }
}
