<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Http\Traits\GeneralTrait;

class WalletHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
     use GeneralTrait;
    public function getProfitWallet(Request $request)
    {      
        try {
                $user=User::where("token",$request->token)->first();
                $data = 
                $data = array();
                foreach($products as $product){
                    $data[] = Product::with(['attributes','brand','options','tags','reviews','user'])->where('user_id',$user->id)->where('id',$product->id)->get();
                    }
                    return $this->returnData(['data'=>$data],trans("product::api.product_added_successfully")); 
            }  
            catch (\Exception $ex){
                return $this->returnError($ex->getMessage(),500);
            }

    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('user::create');
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
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('user::edit');
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
