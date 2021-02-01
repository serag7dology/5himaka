<?php

namespace Modules\Setting\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setting\Entities\Setting;
use Modules\Core\Http\Traits\GeneralTrait;

use Validator;


class SettingController extends Controller
{
    use GeneralTrait;

    
    public function customer_support(Request $request)
    {

        try {

        $phone = setting('customer_support_phone');
        $mail = setting('customer_support_mail');
        $workHoursAndDays = Setting::where("key","customer_support_work_hours_and_days")->first()->value;

           
        return $this->returnData(['phone'=>$phone,'mail'=>$mail,'workHoursAndDays'=>$workHoursAndDays]); 
        }  
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage(),500);
        }
    }
}
