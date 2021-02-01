<?php

namespace Modules\Withdraw\Admin;

use Modules\Admin\Ui\AdminTable;

class WithdrawRequestTable extends AdminTable
{
   

    /**
     * Make table response for the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function make()
    {
        return $this->newTable()->addColumn('customer_name', function ($withdraw_request) {
            return $withdraw_request->customer_full_name;
        });
    }
    public function newTable()
    {
        return datatables($this->source->with(['WithdrawMethod','User'])->get())
            ->addColumn('checkbox', function ($entity) {
                return view('admin::partials.table.checkbox', compact('entity'));
            })
            ->editColumn('status', function ($entity) {
                return $entity->confirm
                    ? '<span class="dot green"></span>'
                    : '<span class="dot red"></span>';
            })
            ->editColumn('created', function ($entity) {
                return view('admin::partials.table.date')->with('date', $entity->created_at);
            })
            ->rawColumns(array_merge($this->defaultRawColumns, $this->rawColumns))
            ->removeColumn('translations');
    }
}
