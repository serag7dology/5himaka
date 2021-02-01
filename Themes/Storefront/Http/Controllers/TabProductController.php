<?php

namespace Themes\Storefront\Http\Controllers;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductBanner;

class TabProductController extends ProductIndexController
{
    /**
     * Display a listing of the resource.
     *
     * @param int $sectionNumber
     * @param int $tabNumber
     * @return \Illuminate\Http\Response
     */
    public function index($sectionNumber, $tabNumber)
    {
        return $this->getProducts("storefront_product_tabs_{$sectionNumber}_section_tab_{$tabNumber}");
    }
    public function getProductsBanner($id)
    {
        $ids = ProductBanner::find($id);
        if(count(collect($ids))>0)
        {
            // $product = Product:: with(['attributes','brand','options','tags','reviews'])->find($ids->product_ids);
         $product = Product::list($ids->product_ids);
            }
        
        return view('public.products.index');
    }
}
