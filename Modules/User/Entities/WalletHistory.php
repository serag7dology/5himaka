<?php

namespace Modules\User\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Order\Entities\Order;
use Modules\Product\Entities\Product;
use Modules\Support\Eloquent\Translatable;

class WalletHistory extends Model
{
    use softDeletes , Translatable;   
    protected $with = ['translations'];
    protected $translatedAttributes = ['operation_type'];
    protected  $table='wallet_history';
    public $fillable =['id','wallet_id','wallet_type','wallet_type_from','order_id','product_id','current_total','pervious_total','amount_spent','user_id_from','user_id_to'];

    protected  $hidden=['updated_at','deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class,'wallet_id');
    }
    public function user_from()
    {
        return $this->belongsTo(User::class,'user_id_from');
    }
    public function user_to()
    {
        return $this->belongsTo(User::class,'user_id_to');
    }
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function getDetailsAttribute($val )
    {
        return ($val !== null) ? json_decode($val) : "";
    }
    public function getCreatedAtAttribute($val )
    {
        return ($val !== null) ? Carbon::parse($val)->format('Y m d h:i a'): "";
    }
}
