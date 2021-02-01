<?php

namespace Modules\Plan\Http\Controllers\Admin;

use Modules\Plan\Entities\Plan;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Plan\Http\Requests\SavePlanRequest;

class PlanController
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Plan::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'plan::plans.plan';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'plan::admin.plans';

    /**
     * Form requests for the resource.
     *
     * @var array
     */
    protected $validation = SavePlanRequest::class;
}
