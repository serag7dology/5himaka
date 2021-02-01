<?php

namespace Modules\User\Http\Requests;

use Modules\Core\Http\Requests\Request;

class SaveUserPlanRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = 'user::attributes.plans';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            'plan_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',

        ];
    }
}
