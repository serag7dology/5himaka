<?php

namespace Modules\Core\Http\Traits;

trait GeneralTrait
{
    public function saveImage($folder ,$image)
    {
           $image->store('/',$folder);
           $file_name=$image->hashName();
           $path=$folder.'/'.$file_name;
           return $path;
       }

    public function getCurrentLang()
    {
        return app()->getLocale();
    }
    public function generateOtp(){
        $fourDigitRandom = rand(1000,9999); 
        return $fourDigitRandom; 
    }

    public function returnError($errors, $code)
    {
        return response()->json([
            'status' => false,
            'errors' => $errors
        ],$code);
    }


    public function returnSuccessMessage($msg = "", $errNum = "200")
    {
        return [
            'status' => true,
            'msg' => $msg
        ];
    }

    public function returnData($data, $msg = "")
    {
        return response()->json([
            'status' => true,
            'msg' => $msg,
            'data' => $data
        ]);
    }


    //////////////////
    public function returnValidationError($code = "E001", $validator)
    {
        return $this->returnError($code, $validator->errors()->first());
    }


    


}
