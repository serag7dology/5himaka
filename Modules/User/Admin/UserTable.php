<?php

namespace Modules\User\Admin;

use Modules\Admin\Ui\AdminTable;

class UserTable extends AdminTable
{
    /**
     * Raw columns that will not be escaped.
     *
     * @var array
     */
    protected $rawColumns = ['last_login'];

    /**
     * Make table response for the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function make()
    {
        return $this->newTable()
            ->editColumn('last_login', function ($user) {
                return view('admin::partials.table.date')->with('date', $user->last_login);
            });
    }
    public function newTable()
    {
        return datatables($this->source->with('WithdrawMethod')->get())
            ->addColumn('checkbox', function ($entity) {
                return view('admin::partials.table.checkbox', compact('entity'));
            })
            ->editColumn('status', function ($entity) {
                return $entity->is_active
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
