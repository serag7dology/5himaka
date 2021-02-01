<?php

namespace Modules\Product\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Review\Entities\Review;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductBanner;
use Modules\Product\Events\ProductViewed;
use Modules\Core\Http\Traits\GeneralTrait;
use Modules\Product\Filters\ProductFilter;
use Modules\Product\Http\Middleware\SetProductSortOption;
use Modules\User\Entities\User;
use Validator;
use Modules\Product\Entities\ProductTranslation;
use Modules\Media\Entities\File;
use Illuminate\Support\Facades\Storage;
use Modules\Category\Entities\Category;
use Modules\Setting\Entities\Setting;

use DB;
use Modules\Category\Http\Controllers\CategoryProductController;
use Modules\Category\Http\Responses\CategoryTreeResponse;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderProduct;
use Modules\Product\Entities\NewPrice;

class ProductController extends Controller
{
    use GeneralTrait;

    public function home(Request $request)
    {
        
        if(isset($request->token))
         {

            $user = User::where("token",$request->token)->first();
            if($user==NULL)
            {
                return $this->returnError([trans("product::products.errors.token_not_found")],404);
            }
         }
        // $register_link = env('APP_URL') .'/en/register?code='.$user->id;
         $delivery_info['5himaka']= Setting::where("key","5himaka")->first()->value;
         $delivery_info['delivery_information']= Setting::where("key","delivery_info")->first()->value;
         $delivery_info['return_policy']= Setting::where("key","return_policy")->first()->value;

         $offers=ProductBanner::all();
        //  foreach ($offers as $item) {
        //     $item->old_price=json_decode($item->price);
        //     $item->new_price=json_decode($item->selling_price);
        //     $item->main_image=$item->base_image["path"];
        //     $images=array();
        //     foreach ($item->files as $image) {
        //         $images[]=$image["path"];
        //     }
        //     $item->images=$images;
        //  }
         $skip=0;
         if(isset($request->page))
         {    
             //4*0=0
             //4*1=4
             $skip=10*$request->page;
         }
         $count=Product::where("is_active",1)->where('show_on_home',"1")->orderBy('id','DESC')->count();
         $products=Product::with(['attributes','brand','options','tags','reviews'])->where("is_active",1)->where('show_on_home',"1")->orderBy('id','DESC')->skip($skip)->take(10)->get();
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
        return $this->returnData(['offers'=>$offers,'products'=>$products,'delivery_info'=>$delivery_info,'total'=>$count]);

    }
    public function getBannerProduct(Request $request){
        $rules = [
            'banner_id'      => 'required|exists:product_banner,id'        ];
        $messages = [
            'banner_id.required'     => trans("product::validation.banner_id.required"),
            'banner_id.exists'       => trans("product::validation.banner_id.exists"),
        ];
        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            $errors=array();     
        foreach ($validator->errors()->getMessages() as $key => $value) {
            $errors[]=$value[0];
        }
        return $this->returnError($errors,422);
        }
         $ids = ProductBanner::find($request->banner_id);
        $result=[];
        $result=Product::find( $ids->product_ids);
            return $this->returnData(['products'=>$result]);

    }
    // public function home(Request $request)
    // {
    //     if(isset($request->token))
    //      {
    //         $user = User::where("token",$request->token)->first();
    //         if($user==NULL)
    //         {
    //             return $this->returnError([trans("product::products.errors.token_not_found")],404);
    //         }
    //      }
    //      $register_link = env('APP_URL') .'/en/register?code='.$user->id;
    //      $delivery_info['5himaka']= Setting::where("key","5himaka")->first()->value;
    //      $delivery_info['delivery_information']= Setting::where("key","delivery_info")->first()->value;
    //      $delivery_info['return_policy']= Setting::where("key","return_policy")->first()->value;

    //      $offers=Product::with(['attributes','brand','options','tags','reviews'])->where("is_active",1)->where("special_price","!=",NULL)->where('offer_order','!=',NULL)->orderBy('offer_order')->limit(5)->get();
    //      foreach ($offers as $item) {
    //         $item->old_price=json_decode($item->price);
    //         $item->new_price=json_decode($item->selling_price);
    //         $item->main_image=$item->base_image["path"];
    //         $images=array();
    //         foreach ($item->files as $image) {
    //             $images[]=$image["path"];
    //         }
    //         $item->images=$images;
    //      }
    //      $skip=0;
    //      if(isset($request->page))
    //      {    
    //          //4*0=0
    //          //4*1=4
    //          $skip=10*$request->page;
    //      }
    //      $count=Product::where("is_active",1)->where('show_on_home',"1")->orderBy('id','DESC')->count();
    //      $products=Product::with(['attributes','brand','options','tags','reviews'])->where("is_active",1)->where('show_on_home',"1")->orderBy('id','DESC')->skip($skip)->take(10)->get();
    //      foreach ($products as $item) {
    //          if(isset($user))
    //          {
    //             $wishlist=$user->wishlistHas($item->id);
    //             if($wishlist)
    //             {
    //                 $item->is_wishlist=true;
    //             }
    //             else
    //             {
    //                 $item->is_wishlist=false;
    //             }
    //          }
    //         $item->description=strip_tags($item->description);
    //         $item->old_price=json_decode($item->price);
    //         $item->new_price=json_decode($item->selling_price);
    //         $item->main_image=$item->base_image["path"];
    //         $images=array();
    //         foreach ($item->files as $image) {
    //             $images[]=$image["path"];
    //         }
    //         $item->images=$images;
    //      }
    //     return $this->returnData(['register_link'=>$register_link,'offers'=>$offers,'products'=>$products,'delivery_info'=>$delivery_info,'total'=>$count]);

    // }
    public function add(Request $request)
    {

        try {

            $messages = [
                'name.required' => trans("product::validation.name.required"),
                'name.required' => trans("product::validation.name.required"),
                'name.max' => trans("product::validation.name.max"),
                'description.required' => trans("product::validation.description.required"),
                'description.min' => trans("product::validation.description.min"),
                'description.max' => trans("product::validation.description.max"),
                'categories.required' => trans("product::validation.categories.required"),
                'images.required' => trans("product::validation.images.required"),
                'price.required' => trans("product::validation.price.required"),
                'used.required' => trans("product::validation.used.required"),
                'used.in' => trans("product::validation.used.in"),


            ];
            $rules = [
                'name' => 'required|max:255',
                'description' => 'min:5|max:5000|required',
                'categories' => 'required',
                "images"=>"required",
                "price"=>"required",
                'used' => 'required|in:0,1',
               
            ];

            $validator = Validator::make($request->all(), $rules,$messages);

            if ($validator->fails()){
                $errors=array();     
               foreach ($validator->errors()->getMessages() as $key => $value) {
                   $errors[]=$value[0];
               }
               return $this->returnError($errors,422);

           }
            //$user=auth()->user();
            $user=User::where("token",$request->token)->first();
            $product=new Product;
            $product->user_id=$user->id;
            $product->used=$request->used;
            
             $product->price=$request->price;
            if(isset($request->discount_percent))
            {
            $product->special_price_type="percent";
            $product->special_price=$request->price-($request->price /  100)*$request->discount_percent ;
            $product->selling_price=$request->price-($request->price /  100)*$request->discount_percent ;

            }
            $product->manage_stock=0;
            $product->in_stock=1;
            $product->is_active=0;
             $product->save();
            return $product;
            $product_trans=new ProductTranslation;
            $product_trans->product_id=$product->id;
            $product_trans->locale="en";
            if(isset($request->lang) && $request->lang=="ar")
            {
                $product_trans->locale="ar";
            }
            $product_trans->name=$request->name;
            $product_trans->description=$request->description;
            $product_trans->save();
            $product->slug=str_slug($request->name , "-");
            $checkSlug=Product::where("slug",$product->slug)->first();
            if($checkSlug!=NULL)
            {
                return $this->returnError(['name is exists before'],422); 
            }
            $product->save();
            $index=0;
            foreach ($request->images as $image) {
                $path = Storage::putFile('media', $image);

                $file=File::create([
                    'user_id' => $user->id,
                    'disk' => config('filesystems.default'),
                    'filename' => $image->getClientOriginalName(),
                    'path' => $path,
                    'extension' => $image->guessClientExtension() ?? '',
                    'mime' => $image->getClientMimeType(),
                    'size' => $image->getSize(),
                ]);

                //save entity file
                $entity["file_id"]=$file->id;
                $entity["entity_type"]="Modules\Product\Entities\Product";
                $entity["entity_id"]=$product->id;

                if($index==0)
                $entity["zone"]="base_image";
                else
                $entity["zone"]="additional_images";

                DB::table('entity_files')->insert($entity);
                $index++;

            }
            $delivery_info['5himaka']= Setting::where("key","5himaka")->first()->value;
            $delivery_info['delivery_information']= Setting::where("key","delivery_info")->first()->value;
            $delivery_info['return_policy']= Setting::where("key","return_policy")->first()->value;
           // $product=Product::with(['attributes','brand','options','tags','reviews'])->where("id",$product->id)->first();
            return $this->returnData(['product'=>$product,'delivery_info'=>$delivery_info]);

        }catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        } 
    }

    
    public function search(Request $request)
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
                'keyword.required' => trans("product::validation.keyword.required"),  
            ];
            $rules = [
                'keyword' => 'required',
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
            $ids=ProductTranslation::where("name",'like', '%' . $request->keyword . '%')->orWhere("description",'like', '%' . $request->keyword . '%')->pluck("product_id")->toArray();
            $products=Product::with(['attributes','brand','options','tags','reviews'])->where("is_active",1)->whereIn("id",$ids)->get();
            
            foreach ($products as $item) {
                if($item->user_id==NULL)
                {
                    $item->user_name="5Himaka";
                }
                else
                {
                    $item_user=User::find($item->user_id);
                    $item->user_name=$item_user->first_name." ".$item_user->last_name;
                }
                if(isset($request->type))
                {
                       if(isset($item->categories[0]))
                       {
                        $cat_id=$item->categories[0]->id;
                        
                        while(true)
                        {
                            $parent=Category::find($cat_id);
                            if($parent->parent_id==NULL)
                            {
                                if($request->type!=1 && $request->type!=2) 
                                {
                                    $item->returned=true;
                                }
                                elseif($parent->id==1 && $request->type==1)
                                {
                                    $item->returned=true;
                                }
                                elseif($parent->id==2 && $request->type==2)
                                {
                                    $item->returned=true;
                                }
                                else
                                {
                                    $item->returned=false;
                                }
                                break;
                            }
                            else
                            {
                                $cat_id=$parent->parent_id;
                            }
                        }
                       }
                       else
                       {
                           $item->returned=false;
                       }
                   
                }
                else
                {
                    $item->returned=true;
                }
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
               $item->user_name="5HHimaka";

               
            }
            $filtered = $products->reject(function ($product, $key) use ($request){
                return $product->returned==false;
            });
            $count=count($filtered);

            $products=Product::with(['attributes','brand','options','tags','reviews'])->where("is_active",1)->whereIn("id",$ids)->skip($skip)->take(10)->get();
            
            foreach ($products as $item) {

                if($item->user_id==NULL)
                {
                    $item->user_name="5Himaka";
                }
                else
                {
                    $item_user=User::find($item->user_id);
                    $item->user_name=$item_user->first_name." ".$item_user->last_name;
                }
                if(isset($request->type))
                {
                       if(count($item->categories)>0)
                        $cat_id=$item->categories[0]->id;
                        else
                        $cat_id=1;
                        while(true)
                        {
                            $parent=Category::find($cat_id);
                            if($parent->parent_id==NULL)
                            {
                                if($request->type!=1 && $request->type!=2) 
                                {
                                    $item->returned=true;
                                }
                                elseif($parent->id==1 && $request->type==1)
                                {
                                    $item->returned=true;
                                }
                                elseif($parent->id==2 && $request->type==2)
                                {
                                    $item->returned=true;
                                }
                                else
                                {
                                    $item->returned=false;
                                }
                                break;
                            }
                            else
                            {
                                $cat_id=$parent->parent_id;
                            }
                        }
                       
                   
                }
                else
                {
                    $item->returned=true;
                }
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
            $filtered = $products->reject(function ($product, $key) use ($request){
                return $product->returned==false;
            });
            
            $products=$filtered->all();

            $delivery_info['5himaka']= Setting::where("key","5himaka")->first()->value;
            $delivery_info['delivery_information']= Setting::where("key","delivery_info")->first()->value;
            $delivery_info['return_policy']= Setting::where("key","return_policy")->first()->value;
           return $this->returnData(['items'=>$products,'total'=>$count,'delivery_info'=>$delivery_info]); 
        }  
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        } 
    }
    public function prepFilter(Request $request)
    {
        try {
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
            if($request->category_id==1 || $request->category_id==2)
            {
            $MainCategories=Category::where("parent_id",$request->category_id)->get();
            }
            else
            {
            $MainCategories=Category::whereIn("parent_id",[1,2])->get();
            }
            $max_price=0;
            $min_price=10000000000000;
            foreach ($MainCategories as $item) {
                $sub_categories=Category::where("parent_id",$item->id)->get();
                foreach($sub_categories as $sub)
                {
                    foreach($sub->products as $product)
                    {
                        $price=json_decode($product->price);
                        if($max_price<$price)
                        {
                        $max_price=$price;
                        }
                        if($min_price>$price)
                        {
                            $min_price=$price;
                        }
                    }
                }
            }
            if($min_price==10000000000000)
            {
                $min_price=0;
                $max_price=0;
            }
        return $this->returnData(['MainCategories'=>$MainCategories,'min_price'=>$min_price,'max_price'=>$max_price]); 
        }  
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }
    }
    public function filter(Request $request)
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
           
            $skip=0;
            if(isset($request->page))
            {    
                //4*0=0
                //4*1=4
                $skip=10*$request->page;
            }
            $ids=array();
            if(isset($request->keyword))
            {
            $key_ids=ProductTranslation::where("name",'like', '%' . $request->keyword . '%')->orWhere("description",'like', '%' . $request->keyword . '%')->pluck("product_id")->toArray();
            $ids=$key_ids;
            }
            
            if(isset($request->price_from) && isset($request->price_to))
            {
            
            $price_ids=Product::whereBetween("selling_price",[$request->price_from,$request->price_to])->pluck("id")->toArray();
            if(count($ids) == 0)
            $ids=$price_ids;
            $ids=array_intersect($ids,$price_ids);
            }
            //is used 
            if(isset($request->is_used) )
            {
                $products=Product::with(['attributes','brand','options','tags','reviews'])->where("is_active",1)->where("used",$request->is_used)->pluck("id")->toArray();
                if(count($ids) == 0)
                $ids=$products;
                $ids=array_intersect($ids,$products);
            }
            
            if(isset($request->rating))
            {
                $rating_ids=array();
                foreach ($request->rating as $rat) {
                    $rat_ids = Review::groupBy('product_id')
                ->havingRaw('AVG(rating) > ?',[$rat])
                ->havingRaw('AVG(rating) < ?',[$rat+1])->pluck("product_id")->toArray();
                $rating_ids=array_merge($rating_ids,$rat_ids);
                }
                $rating_ids=array_unique($rating_ids);
                if(count($ids) == 0)
                $ids=$rating_ids;
                $ids=array_intersect($ids,$rating_ids);

            }
            
            if(isset($request->catid))
            {
                $category=Category::find($request->catid);
              
                if($category){
                    $cats_products=$category->products;
                    $cats_ids=array();
                    foreach($cats_products as $item)
                    {
                    $cats_ids[]=$item->id;
                    }
                    if(count($ids) == 0)
                    $ids=$cats_ids;
                    $ids=array_intersect($ids,$cats_ids);
                }
                
            }
            
            $products=Product::with(['attributes','brand','options','tags','reviews'])->where("is_active",1)->whereIn("id",$ids)->get();
            
            foreach ($products as $item) {
                if(isset($request->type))
                {
                   
                       $cat_id=$item->categories[0]->id;
                       while(true)
                       {
                           $parent=Category::find($cat_id);
                           if($parent->parent_id==NULL)
                           {
                             if($parent->id==1 && $request->type==1)
                             {
                                 $item->returned=true;
                             }
                             elseif($parent->id==2 && $request->type==2)
                             {
                                $item->returned=true;
                             }
                             else
                             {
                                $item->returned=false;
                             }
                            break;
                           }
                           else
                           {
                            $cat_id=$parent->parent_id;
                           }
                       }
                   
                }
                else
                {
                    $item->returned=true;
                }
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
            $filtered = $products->reject(function ($product, $key) use ($request){
                return $product->returned==false;
            });
            $count=count($filtered);
            $products=Product::with(['attributes','brand','options','tags','reviews'])->where("is_active",1)->whereIn("id",$ids)->skip($skip)->take(10)->get();
            
            foreach ($products as $item) {
                if(isset($request->type))
                {
                   
                       $cat_id=$item->categories[0]->id;
                       while(true)
                       {
                           $parent=Category::find($cat_id);
                           if($parent->parent_id==NULL)
                           {
                             if($parent->id==1 && $request->type==1)
                             {
                                 $item->returned=true;
                             }
                             elseif($parent->id==2 && $request->type==2)
                             {
                                $item->returned=true;
                             }
                             else
                             {
                                $item->returned=false;
                             }
                            break;
                           }
                           else
                           {
                            $cat_id=$parent->parent_id;
                           }
                       }
                   
                }
                else
                {
                    $item->returned=true;
                }
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

            $filtered = $products->reject(function ($product, $key) use ($request){
                return $product->returned==false;
            });

            $products=$filtered->all();
            $delivery_info['5himaka']= Setting::where("key","5himaka")->first()->value;
            $delivery_info['delivery_information']= Setting::where("key","delivery_info")->first()->value;
            $delivery_info['return_policy']= Setting::where("key","return_policy")->first()->value;

        return $this->returnData(['items'=>$products,'total'=>$count,'delivery_info'=>$delivery_info]); 
        }  
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        } 
    }
    public function ProductOrServiceDetails(Request $request)
    {
        try {
            $messages = [


                'item_id.required' => trans("product::validation.item_id.required"),  
                'item_id.exists' => trans("product::validation.item_id.exists"),  

            ];
            $rules = [
                'item_id' => 'required|exists:products,id',
            ];
            $validator = Validator::make($request->all(), $rules,$messages);
            if ($validator->fails()) {
                $errors=array();     
               foreach ($validator->errors()->getMessages() as $key => $value) {
                   $errors[]=$value[0];
               }
               return $this->returnError($errors,422);
           }
             $item=Product::find($request->item_id);
             if(!$item){
                return $this->returnError(trans('product::api.product_not_found'),422); 
             }
            if($item->user_id==NULL)
            {
                $item->user_name="5Himaka";
            }
            else
            {
                $item_user=User::find($item->user_id);
                $item->user_name=$item_user->first_name." ".$item_user->last_name;
            }
            $user=User::where("token",$request->token)->first();
            $wishlist=$user->wishlistHas($item->id);
            if($wishlist)
            {
                $item->is_wishlist=true;
            }
            else
            {
                $item->is_wishlist=false;
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
            $item->reviews=$item->reviews;
            $item->related_items=$item->relatedProducts;
            if($item->user_id==$user->id){
                $canPurchasing=true; 
            }
            else{
                if(setting('min_commission_to_purchasing_and_selling')>$user->commission_acount)
                {
                    $canPurchasing=false; 
                }
                else
                {
                  $canPurchasing=true; 
                }
            }
            
            $delivery_info['5himaka']= Setting::where("key","5himaka")->first()->value;
            $delivery_info['delivery_information']= Setting::where("key","delivery_info")->first()->value;
            $delivery_info['return_policy']= Setting::where("key","return_policy")->first()->value;

        return $this->returnData(['item'=>$item,'delivery_info'=>$delivery_info,'canPurchasing'=>$canPurchasing]); 
        }  
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }
    } 
    public function addReview(Request $request)
    {
        try {
            $messages = [
                'item_id.required' => trans("product::validation.item_id.required"),
                'comment.required'=>  trans("product::validation.comment.required"),
                'rating.required'=>trans("product::validation.rating.required"),
                'rating.numeric'=>trans("product::validation.rating.numeric"),
                'rating.min'=>trans("product::validation.rating.min"),
                'rating.max'=>trans("product::validation.rating.max"),
            ];
            $rules = [
                'item_id' => 'required',
                'comment'=>'required',
                'rating'=>'required|numeric|min:0|max:5',
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
            $is_reviewed = Review::where('reviewer_id',$user->id)->where('product_id',$request->item_id)->get();
            if(count($is_reviewed) > 0){
                return $this->returnError([trans('product::api.is_reviewed_err')],400);
            }
            $review=new Review;
            $review->reviewer_id=$user->id;
            $review->product_id=$request->item_id;
            $review->rating=$request->rating;
            $review->comment=$request->comment;
            $review->reviewer_name=$user->first_name." ".$user->last_name;
            $review->is_approved=1;
            $review->save();
           
        return $this->returnData(['review'=>$review],trans("product::api.review_added_successfully")); 
        }  
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }
    }
    public function productsSavedInCard(Request $request)
    {
        try {
            $user=User::where("token",$request->token)->first();
           $products = DB::table('order_products')
           ->join('orders', 'orders.id', '=', 'order_products.order_id')
           ->join('products', 'products.id', '=', 'order_products.product_id')
           ->where('orders.status','pending')
           ->where('orders.customer_id',$user->id)
           ->select('products.id')
           ->get();

           $data = array();

           foreach($products as $product){
               $data[] = Product::where('id',$product->id)->first();
            }
            return $this->returnData($data,trans("product::api.product_added_successfully")); 
            }  
            catch (\Exception $ex){
                return $this->returnError($ex->getMessage(),500);
            }
    }
    public function productsPurchased(Request $request)
    {
        try {
            $user=User::where("token",$request->token)->first();
           $products = DB::table('order_products')
           ->join('orders', 'orders.id', '=', 'order_products.order_id')
           ->join('products', 'products.id', '=', 'order_products.product_id')
           ->where('orders.status','pending')
           ->where('orders.customer_id',$user->id)
           ->select('products.id')
           ->get();

           $data = array();

           foreach($products as $product){
               $data[] = Product::where('id',$product->id)->first();
            }
            return $this->returnData($data,trans("product::api.product_added_successfully")); 
            }  
            catch (\Exception $ex){
                return $this->returnError($ex->getMessage(),500);
            }
    }
    public function productSold(Request $request)
    {
        try {
            $user=User::where("token",$request->token)->first();
            $products = DB::table('order_products')
            ->join('orders', 'orders.id', '=', 'order_products.order_id')
            ->join('products', 'products.id', '=', 'order_products.product_id')
            ->where('orders.status','pending')
            ->where('products.user_id',$user->id) 
            ->select('products.id')
            ->get();

            $data = array();

            foreach($products as $product){
                $data[] = Product::where('user_id',$user->id)->where('id',$product->id)->first();
                }
                return $this->returnData($data,trans("product::api.product_added_successfully")); 
                }  
                catch (\Exception $ex){
                    return $this->returnError($ex->getMessage(),500);
                }
    }
    public function NewPrice(Request $request)
    {
        try {
            $messages = [
                'item_id.required' => trans("product::validation.item_id.required"),
                'new_price.required'=>  trans("product::validation.new_price.required"),
            ];
            $rules = [
                'item_id' => 'required',
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
            if(isset($request->user_id))
            {
               $user = User::where("id",$request->user_id)->first();
               if($user==NULL)
               {
                   return $this->returnError([trans("product::products.errors.token_not_found")],404);
               }
            }
            //$is_found=NewPrice::where('product_id',$request->item_id)->where('user_id', $user->id)->where('status',1)->get();
        //    if(count($is_found)> 0){
        //     return $this->returnError([trans("product::products.errors.price_changed")],404);
        //    }
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
                   // $user_wanted_price = $request->new_price * (10/100);
                    //$product_limit_price = $product->selling_price->amount() * (10/100);
                       //$product->selling_price->amount();
                   // $user_commission=$user->commission_acount;
                    // if(  !$user_commission >=  $product->selling_price->amount()){
                    //    return $this->returnError([trans("product::api.commission_account")],404);
                    //   }
               //    if new price less than item price of 10% price can not be changed
                //   if( $user_wanted_price <  $product_limit_price){
                //    return $this->returnError([trans("product::products.errors.price_changed")],404);
                //   }
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
    public function check(Request $request)
    {
        try {
             $categories=DB::table('product_categories')->select('category_id')->where('product_id',$request->item_id)->get()->toArray();
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
                    return "product";
                }else{
                    return "services";
                }
            }
          }else
          return $this->returnError([trans("product::api.price_changed_only_to_services")],404);

            
        }  
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }
    }
}
