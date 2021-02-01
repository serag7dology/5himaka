<?php

namespace Modules\User\Http\Controllers\Admin;

use Modules\User\Entities\UsersPlan;
use Modules\Admin\Traits\HasCrudActions;
use Modules\User\Http\Requests\SaveUserPlanRequest;

class PlanController
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = UsersPlan::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'user::plans.plan';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'user::admin.plans';

    /**
     * Form requests for the resource.
     *
     * @var array
     */
    protected $validation = SaveUserPlanRequest::class;
}
