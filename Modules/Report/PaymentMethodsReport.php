<?php

namespace Modules\Report;

use Modules\Order\Entities\Order;

class PaymentMethodsReport extends Report
{
    protected function view()
    {
        return 'report::admin.reports.payment_methods_report.index';
    }

    protected function data()
    {

        $paymentMethods=[];
        $paymentMethods["paypal"]=trans('setting::settings.tabs.paypal');
        $paymentMethods["stripe"]=trans('setting::settings.tabs.stripe');
        $paymentMethods["instamojo"]=trans('setting::settings.tabs.instamojo');
        $paymentMethods["cod"]=trans('setting::settings.tabs.cod');
        $paymentMethods["bank_transfer"]=trans('setting::settings.tabs.bank_transfer');
        $paymentMethods["check_payment"]=trans('setting::settings.tabs.check_payment');
              
        return [
            'paymentMethods' => $paymentMethods,
        ];
    }

    public function query()
    {
        return Order::select('payment_method')
            ->selectRaw('MIN(created_at) as start_date')
            ->selectRaw('MAX(created_at) as end_date')
            ->selectRaw('COUNT(*) as total_orders')
            ->selectRaw('SUM(total) as total')
            ->when(request()->has('payment_method'), function ($query) {
                $query->where('payment_method', request('payment_method'));
            })
            ->groupBy('payment_method');
    }
}
