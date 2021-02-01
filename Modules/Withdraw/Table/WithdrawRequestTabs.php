<?php

namespace Modules\Withdraw\Table;

use Modules\Admin\Ui\Tab;
use Modules\Admin\Ui\Tabs;
use Modules\User\Entities\User;
use Modules\Withdraw\Entities\WithdrawsWay;

class WithdrawRequestTabs extends Tabs
{
    public function make()
    {
        $this->group('withdraw_information', trans('withdraw::withdraws.tabs.group.withdraw_request_information'))
            ->active()
            ->add($this->general());
    }

    private function general()
    {
        return tap(new Tab('general', trans('withdraw::withdraws.tabs.general')), function (Tab $tab) {
            $tab->active();
            $tab->weight(5);
            $tab->fields(['name']);
            $tab->view('withdraw::admin.withdraws_requests.tabs.general',[
                'users'=>$this->users(),
                'isCustomer'=>$this->user_type(),
                'user_id'=>auth()->user()->id,
                'withdraw_methods'=>$this->withdraws_methods()
            ]);
        });
    }
    private function users()
    {
        return User::list()->prepend(trans('admin::admin.form.please_select'), '');
    }
    private function user_type()
    {
        $user=auth()->user();
        return $user->isCustomer();
    }
    private function withdraws_methods()
    {
        return WithdrawsWay::list()->prepend(trans('admin::admin.form.please_select'), '');

    }
}
