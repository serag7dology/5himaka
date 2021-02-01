<?php

namespace Modules\User\Admin;

use Modules\Admin\Ui\Tab;
use Modules\Admin\Ui\Tabs;
use Modules\User\Entities\User;
use Modules\Plan\Entities\Plan;
class PlanTabs extends Tabs
{
    /**
     * Make new tabs with groups.
     *
     * @return void
     */
    public function make()
    {
        $this->group('plan_information', trans('user::users.tabs.group.plan_information'))
            ->active()
            ->add($this->general());
    }

    private function general()
    {
        return tap(new Tab('general', trans('user::users.plans.userplan')), function (Tab $tab) {
            $tab->active();
            $tab->weight(5);
            $tab->fields(['user_id', 'plan_id', 'start_date','end_date']);
            $tab->view('user::admin.plans.tabs.general',[
                'users' => $this->users(),
                'plans' => $this->plans(),
                'parents'=>$this->parents(),

            ]);
        });
    }

    private function users()
    {
        return User::list()->prepend(trans('admin::admin.form.please_select'), '');
    }
    private function parents()
    {
        return User::parents_list()->prepend(trans('admin::admin.form.please_select'), '');
    }

    private function plans()
    {
        return Plan::list()->prepend(trans('admin::admin.form.please_select'), '');
    }
   
}
