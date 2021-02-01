<?php

namespace Modules\Plan\Table;

use Modules\Admin\Ui\Tab;
use Modules\Admin\Ui\Tabs;

class PlanTabs extends Tabs
{
    public function make()
    {
        $this->group('plan_information', trans('plan::plans.tabs.group.plan_information'))
            ->active()
            ->add($this->general());
    }

    private function general()
    {
        return tap(new Tab('general', trans('plan::plans.tabs.general')), function (Tab $tab) {
            $tab->active();
            $tab->weight(5);
            $tab->fields(['name']);
            $tab->view('plan::admin.plans.tabs.general');
        });
    }
}
