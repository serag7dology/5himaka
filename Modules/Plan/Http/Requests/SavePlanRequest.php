<?php

namespace Modules\Plan\Http\Requests;

use Modules\Core\Http\Requests\Request;

class SavePlanRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = 'plan::attributes';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
