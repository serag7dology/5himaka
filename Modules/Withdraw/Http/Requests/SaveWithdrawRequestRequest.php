<?php

namespace Modules\Withdraw\Http\Requests;

use Modules\Core\Http\Requests\Request;

class SaveWithdrawRequestRequest extends Request
{
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            'withdraw_way_id' => 'required',
            'amount'=>'required',
            'withdraw_field_description'=>'max:500',
            'withdraw_field_value'=>'required'
        ];
    }
}
