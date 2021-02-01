<?php

namespace Modules\User\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Order\Entities\Order;
use Modules\Product\Entities\Product;

class Complaint extends Model
{
    use  SoftDeletes;
    protected $table ='complaint';	
    protected $fillable = ['status','order_id','product_id','details','user_id'];
    protected $hidden =['deleted_at','updated_at'];	

    public  function user ()
    {
       return $this->belongsTo(User::class,'user_id');
    }
    public  function order ()
    {
       return $this->belongsTo(Order::class,'order_id');
    }
    public  function product ()
    {
       return $this->belongsTo(Product::class,'product_id');
    }
    public function getCreatedAtAttribute($val )
    {
        return ($val !== null) ? Carbon::parse($val)->format('Y m d h:i a'): "";
    }
}
