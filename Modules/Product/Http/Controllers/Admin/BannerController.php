<?php

namespace Modules\Product\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductBanner;
use Modules\Product\Entities\ProductBannerTranslation;
use Modules\Product\Entities\ProductTranslation;
use Validator;
use Modules\Core\Http\Traits\GeneralTrait;
class BannerController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('product::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create_banner()
    {
        $product=array();
        $products = ProductTranslation::select('name','product_translations.id')
        ->join('products','products.id','product_translations.product_id')
        ->where('products.deleted_at',null)->get();
        foreach($products as $name){
            $product[$name->id]=$name->name;
        }
        return view('product::admin.products.create_banner', compact('product'));
   
    }
 
    public function getBannerProduct(Request $request){
        $rules = [
            'banner_id' => 'required|exists:product_banner,id'        
        ];
        $messages = [
            'banner_id.required' => trans("product::validation.banner_id.required"),
            'banner_id.exists'   => trans("product::validation.banner_id.exists"),
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
        $result=Product::find(json_decode($ids->product_ids));
        return $this->returnData(['products'=>$result]);
    }
    public function store_banner(Request $request)
    {
        $product=array();
        $products = ProductTranslation::select('name','id')->get();
        foreach($products as $name){
            $product[$name->id]=$name->name;
        }
        $messages = [
            'banner_image.required' => trans("product::validation.banner_image.required"), 
            'banner_image.mimes' => trans("product::validation.banner_image.mimes"),  
        ];
        $rules = [
            'banner_image' =>'required|mimes:gif,jpeg,jpg,png' ,
        ];
        
        $validator = Validator::make($request->all(), $rules,$messages);
        
        if ($validator->fails()) {
        //      dd($request->details);
            $errors=array();     
           foreach ($validator->errors()->getMessages() as $key => $value) {
               $errors[]=$value[0];
           }
          dd($this->returnError($errors,422));
          return view('product::admin.products.create_banner',compact('product'))->with($errors);
        }
        $file_path = $this->saveImage('banner',$request->banner_image); 
        $banner_id=ProductBanner::create(['image'=>$file_path,'product_ids'=>json_encode($request->product_ids)]);

         ProductBannerTranslation::create(['locale'=>'en','details'=>$request->details,'product_banner_id'=>$banner_id->id]);

        ProductBannerTranslation::create(['locale'=>'ar','details'=>$request->details_translation,'product_banner_id'=>$banner_id->id]);
       return view('product::admin.products.create_banner',compact('product'));
    } 
    public function saveImage($folder ,$image)
    {
           $image->store('/',$folder);
           $file_name=$image->hashName();
           $path=$folder.'/'.$file_name;
           return $path;
       }
    public function create()
    {
        return view('product::create');
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
        return view('product::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('product::edit');
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
