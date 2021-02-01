<?php

namespace Modules\User\Admin;

use Modules\Admin\Ui\AdminTable;

class PlanTable extends AdminTable
{
   

    /**
     * Make table response for the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /*public function make()
    {
        return $this->newTable()
        ->addColumn('customer_name', function ($user_plan) {
            return $user_plan->customer_full_name;
        })->addColumn('plan_cost', function ($user_plan) {
            return $user_plan->plan_cost;
        })->addColumn('parent_name', function ($user_plan) {
            return $user_plan->parent_customer_full_name;
        });
    }*/

    /**
     * Make table response for the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function make()
    {
        return $this->newTable()->addColumn('customer_name', function ($user_plan) {
            return $user_plan->customer_full_name;
        })->addColumn('plan_cost', function ($user_plan) {
            return $user_plan->plan_cost;
        })->addColumn('parent_name', function ($user_plan) {
            return $user_plan->parent_customer_full_name;
        });
    }
    public function newTable()
    {
        return datatables($this->source->with(['Plan','User'])->get())
            ->addColumn('checkbox', function ($entity) {
                return view('admin::partials.table.checkbox', compact('entity'));
            })
            ->editColumn('created', function ($entity) {
                return view('admin::partials.table.date')->with('date', $entity->created_at);
            })
            ->rawColumns(array_merge($this->defaultRawColumns, $this->rawColumns))
            ->removeColumn('translations');
    }
}
