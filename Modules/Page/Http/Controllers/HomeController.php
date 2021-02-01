<?php

namespace Modules\Page\Http\Controllers;
use Modules\Product\Entities\ProductBanner;
use Auth;
use Modules\Plan\Entities\Plan;
class HomeController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  
    public function index()
    {
        return redirect('products');
        //   return view('public.home.index');
    }
    public function pay(){
        if(Auth::user()->is_paid==0){
            $subscription_cost = Plan::first();
            $amount=$subscription_cost->subscription_cost;
            return view('public.home.pay',compact('amount'));
        }
    }
    public function getBannerProduct(){
        
        return ProductBanner::select('*','product_banner.id as banner_id')
        ->join('product_banner_translations','product_banner_translations.product_banner_id','product_banner.id')
        ->where('product_banner.deleted_at',null)->get();
        
    }
    
}