<?php

namespace Modules\Withdraw\Entities;
use Modules\Support\Eloquent\Translatable;
use Modules\Support\Eloquent\Model;
use Modules\Admin\Ui\AdminTable;
use Illuminate\Support\Facades\Cache;

class WithdrawsWay extends Model
{

    use Translatable;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable =['id','name','field_name','is_active'];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['name','field_name'];


    public function table()
    {
        return new AdminTable($this->query());
    }

    /**
     * Get tag list.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function list()
    {
        return Cache::tags('withdraws_ways')->rememberForever(md5('withdraws_ways.list:' . locale()), function () {
            return self::all()->sortBy('name')->pluck('name', 'id');
        });
    }
   
}
