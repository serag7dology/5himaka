<?php

namespace Modules\Withdraw\Providers;

use Modules\Withdraw\Table\WithdrawRequestTabs;
use Modules\Withdraw\Table\WithdrawTabs;
use Modules\Support\Traits\AddsAsset;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\Ui\Facades\TabManager;



class WithdrawServiceProvider extends ServiceProvider
{
    use AddsAsset;
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        TabManager::register('withdraws_ways', WithdrawTabs::class);
        TabManager::register('withdraw_requests', WithdrawRequestTabs::class);

        //$this->addAdminAssets('admin.withdraw_requests.(create|edit)', ['admin.withdraw.js']);

    }

    
}
