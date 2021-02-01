<?php

namespace Modules\Withdraw\Sidebar;

use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\Group;
use Modules\Admin\Sidebar\BaseSidebarExtender;

class SidebarExtender extends BaseSidebarExtender
{
    public function extend(Menu $menu)
    {
        $menu->group(trans('admin::sidebar.system'), function (Group $group) {
            $group->item(trans('withdraw::sidebar.withdraw'), function (Item $item) {
                $item->weight(5);
                $item->icon('fa fa-money');
                $item->route('admin.withdraws_ways.index');
                $item->authorize(
                    $this->auth->hasAccess('admin.withdraws.index') || $this->auth->hasAccess('roles.index')
                );

                // withdraws methods
                $item->item(trans('withdraw::sidebar.withdraw_methods'), function (Item $item) {
                    $item->weight(5);
                    $item->route('admin.withdraws_ways.index');
                    $item->authorize(
                        $this->auth->hasAccess('admin.withdraws.index')
                    );
                });

                // withdraws requests
                $item->item(trans('withdraw::sidebar.withdraw_requests'), function (Item $item) {
                    $item->weight(5);
                    $item->route('admin.withdraw_requests.index');
                    $item->authorize(
                        $this->auth->hasAccess('admin.withdraw_requests.index')
                    );
                });

              
            });
        });
    }
}
