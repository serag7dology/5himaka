<?php

namespace Modules\Withdraw\Entities;
use Modules\Support\Eloquent\Model;
use Modules\Admin\Ui\AdminTable;
use Modules\Withdraw\Admin\WithdrawRequestTable;
use Modules\User\Entities\User;

class WithdrawsRequest extends Model
{

     public $table="withdraw_requests";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable =['id','user_id','withdraw_way_id','withdraw_field_value','withdraw_field_description','amount','confirm'];


      /**
     * Get the withdraw method of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongTo
     */
    public function WithdrawMethod()
    {
        return $this->belongsTo(WithdrawsWay::class, 'withdraw_way_id');
    }
     /**
     * Get the  user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongTo
     */
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getCustomerFullNameAttribute()
    {
        return "{$this->user->first_name} {$this->user->last_name}";
    }
    /**
     * Get table data for the resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function table()
    {
        return new WithdrawRequestTable($this->query());
    }
}

