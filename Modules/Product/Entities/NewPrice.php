<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Support\Money;

class NewPrice extends Model
{

    protected  $table='new_prices';
    public $fillable =['user_id','product_id','status','new_price'];

    protected  $hidden=['updated_at','deleted_at'];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function getNewPriceAttribute($newPrice)
    {
        if (! is_null($newPrice)) {
            return Money::inDefaultCurrency($newPrice);
        }
    }

    
}
