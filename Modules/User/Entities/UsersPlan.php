<?php

namespace Modules\User\Entities;
use Modules\Support\Eloquent\Model;
use Modules\User\Admin\PlanTable;
use Modules\User\Entities\User;
use Modules\Plan\Entities\Plan;
class UsersPlan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable =['id','user_id','plan_id','parent_id','start_date','end_date'];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
    public function parent()
    {
        return $this->belongsTo(User::class,"parent_id","id");
    }
    public function plan()
    {
        return $this->belongsTo(Plan::class)->withDefault();
    }
     
    public function getCustomerFullNameAttribute()
    {
        return "{$this->user->first_name} {$this->user->last_name}";
    }
    public function getParentCustomerFullNameAttribute()
    {
        return "{$this->parent->first_name} {$this->parent->last_name}";
    }
    public function getPlanCostAttribute()
    {
        return "{$this->plan->subscription_cost} {$this->plan->currency}";
    }
    
    /**
     * Get table data for the resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function table()
    {
        return new PlanTable($this->query());
    }
   
}
