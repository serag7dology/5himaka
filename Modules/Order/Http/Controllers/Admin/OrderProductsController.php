<?php

namespace Modules\Order\Http\Controllers\Admin;

use Modules\Order\Entities\Order;
use Modules\User\Entities\User;
use Illuminate\Http\Request;
use Modules\Admin\Traits\HasCrudActions;
use DataTables;

class OrderProductsController
{
    /**
     * Raw columns that will not be escaped.
     *
     * @var array
     */
    protected $rawColumns = [];

    /**
     * Raw columns that will not be escaped.
     *
     * @var array
     */
    protected $defaultRawColumns = [
        'checkbox', 'thumbnail', 'status', 'created',
    ];

 
    /**
     * Update the specified resource in storage.
     *
     * @param \Modules\Order\Entities\Order $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers=User::list();
        $customers_plus=array();
        foreach ($customers as $value =>$key) {
            $customer=User::find($value);
            $orders=$customer->orders;
            $count=0;
            foreach ($orders as $order) {
                $count+=$order->products->count;
                
            }
            if($count>100)
            {
                $customers_plus[]=array("customer_full_name"=>$customer->first_name ." " .$customer->last_name,
                                      "total_product"=>$count,"first_name"=>$first_name);
            }
        }
        
        if($request->has('table')) {
            
            return datatables($customers_plus)->toJson();
        }
        return view('order::admin.orders.customers.plus_100');

    }
}
