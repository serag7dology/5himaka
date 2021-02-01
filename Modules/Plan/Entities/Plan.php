<?php

namespace Modules\Plan\Entities;
use Modules\Support\Eloquent\Model;
use Modules\Admin\Ui\AdminTable;
use Illuminate\Support\Facades\Cache;
class Plan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable =['currency','duration','limit','subscription_cost','commission','max_people','min_commission_to_appear'];
     
    
    /**
     * Get table data for the resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function table()
    {
        return new AdminTable($this->query());
    }

    /**
     * Get the cost.
     *
     * @return string
     */
    public function getCostAttribute()
    {
        return "{$this->subscription_cost} {$this->currency}";
    }

    /**
     * Get tag list.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function list()
    {
        return Cache::tags('plans')->rememberForever(md5('plans.list:' . locale()), function () {
            return self::all()->sortBy('cost')->pluck('cost', 'id');
        });
    }
   
}
