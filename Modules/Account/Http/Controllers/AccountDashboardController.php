<?php
namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Review\Entities\Review;
use Modules\Product\Entities\Product;
use Modules\Core\Http\Traits\GeneralTrait;
use Modules\User\Entities\User;
use Validator;
use Modules\Product\Entities\ProductTranslation;
use Modules\Media\Entities\File;
use Illuminate\Support\Facades\Storage;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\CategoryTranslation;
use Modules\Setting\Entities\Setting;
use DB;
class AccountDashboardController
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('public.account.dashboard.index', [
            'account' => auth()->user(),
            'recentOrders' => auth()->user()->recentOrders(5),
        ]);
    }
    public function products()
    {
        $category=Category::all();
        $hasDoc=Category::where('has_document',1)->get();
        
        $documents=[];
        $documents_text=[];
        foreach($hasDoc as $arr){
            $documents[]=$arr->id;
            $category_translations=CategoryTranslation::where('category_id',$arr->id)->first();
            $documents_text[$arr->id]=$category_translations->documents;
        }
        $categories=[];
        foreach($category as $arr){
            $categories[$arr->id]=$arr->name;
        }
         return view('public.account.product.index', [
             'categories' => $categories,
             'documents' => $documents,
             'documents_text' => $documents_text,
             'product' => [],
        ]);
    }
   
    public function add(Request $request)
    {

        try {

            $messages = [
                'name.required' => trans("product::validation.name.required"),
                'name.max' => trans("product::validation.name.max"),
                'description.required' => trans("product::validation.description.required"),
                'description.min' => trans("product::validation.description.min"),
                'description.max' => trans("product::validation.description.max"),
                'categories.required' => trans("product::validation.categories.required"),
                'images.required' => trans("product::validation.images.required"),
                'price.required' => trans("product::validation.price.required"),
            ];
            $rules = [
                'name' => 'required|max:255',
                'description' => 'min:5|max:5000|required',
                'categories' => 'required',
                "images"=>"required",
                "price"=>"required",
               
            ];

            $validator = Validator::make($request->all(), $rules,$messages);

            if ($validator->fails()){
                $errors=array();     
               foreach ($validator->errors()->getMessages() as $key => $value) {
                   $errors[]=$value[0];
               }
               $category=Category::all();
               $categories=[];
               foreach($category as $arr){
                   $categories[$arr->id]=$arr->name;
               }
               $request->session()->flash('error', 'All Field Required');
               return back();
              

           }
            //$user=auth()->user();
            $user=User::where("token",$request->token)->first();
            $product=new Product;
            $product->user_id=$request->user_id;
            
            $product->price=$request->price;
            if(isset($request->discount_percent))
            {
            $product->special_price_type="percent";
            $product->special_price=$request->discount_percent / $request->price * 100;
          
            }
            $product->manage_stock=0;
            $product->in_stock=1;
            $product->is_active=0;
            $product->save();
         

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
                    'user_id' => $request->user_id,
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
            foreach ($request->documents as $document) {
                $path = Storage::putFile('media', $document);

                $file=File::create([
                    'user_id' => $request->user_id,
                    'disk' => config('filesystems.default'),
                    'filename' => $document->getClientOriginalName(),
                    'path' => $path,
                    'extension' => $document->guessClientExtension() ?? '',
                    'mime' => $document->getClientMimeType(),
                    'size' => $document->getSize(),
                ]);

                //save entity file
                $entity["file_id"]=$file->id;
                $entity["entity_type"]="Modules\Product\Entities\Product";
                $entity["entity_id"]=$product->id;

                $entity["zone"]="document";
               
                DB::table('entity_files')->insert($entity);
            }
            $delivery_info['5himaka']= Setting::where("key","5himaka")->first()->value;
            $delivery_info['delivery_information']= Setting::where("key","delivery_info")->first()->value;
            $delivery_info['return_policy']= Setting::where("key","return_policy")->first()->value;
            
            $product=Product::with(['attributes','brand','options','tags','reviews'])->where("id",$product->id)->first();
            $request->session()->flash('success', 'Success');
            return back();

        }catch (\Exception $ex){
            $request->session()->flash('error', 'Error');
            return back();
        } 
    }
}