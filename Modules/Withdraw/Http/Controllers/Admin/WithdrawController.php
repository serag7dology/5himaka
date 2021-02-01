<?php

namespace Modules\Withdraw\Http\Controllers\Admin;

use Modules\Withdraw\Entities\WithdrawsWay;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Withdraw\Http\Requests\SaveWithdrawMethodRequest;

class WithdrawController
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = WithdrawsWay::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'withdraw::withdraws.withdraw_create';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'withdraw::admin.withdraws';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveWithdrawMethodRequest::class;
}
