<?php

namespace Modules\Withdraw\Http\Controllers\Admin;

use Modules\Withdraw\Entities\WithdrawsRequest;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Withdraw\Http\Requests\SaveWithdrawRequestRequest;

class WithdrawRequestController
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = WithdrawsRequest::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'withdraw::withdraws.withdraw_request';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'withdraw::admin.withdraws_requests';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveWithdrawRequestRequest::class;
}
