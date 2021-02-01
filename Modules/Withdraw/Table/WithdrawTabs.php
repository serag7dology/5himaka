<?php

namespace Modules\Withdraw\Table;

use Modules\Admin\Ui\Tab;
use Modules\Admin\Ui\Tabs;

class WithdrawTabs extends Tabs
{
    public function make()
    {
        $this->group('withdraw_information', trans('withdraw::withdraws.tabs.group.withdraw_information'))
            ->active()
            ->add($this->general());
    }

    private function general()
    {
        return tap(new Tab('general', trans('withdraw::withdraws.tabs.general')), function (Tab $tab) {
            $tab->active();
            $tab->weight(5);
            $tab->fields(['name']);
            $tab->view('withdraw::admin.withdraws.tabs.general');
        });
    }
}
