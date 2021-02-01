<?php

namespace Modules\User\Http\Requests;

use Modules\Core\Http\Requests\Request;

class RegisterRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = 'user::attributes.users';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8|max:255',
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number'=>'required|min:8|max:255',
            'national_id'=>'required|min:8|max:255',
            'code'=>'required|exists:users,id|min:1|max:255',
            'pin'=>'required|min:4|max:255',
            'question'=>'required|min:4|max:1000',
            'answer'=>'required|min:4|max:1000',
            'subscription'=>'required|exists:plans,id',
            // 'withdraw_method'=>'required|exists:withdraws_ways,id',
            // 'withdraw_main_field_value'=>'required|min:8|max:255',
            // 'withdraw_description'=>'max:1000',
            'privacy_policy' => 'accepted',
        ];
    }
}