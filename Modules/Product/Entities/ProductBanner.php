<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Support\Eloquent\Translatable;

use Illuminate\Database\Eloquent\SoftDeletes;
class ProductBanner extends Model
{
    use softDeletes , Translatable;   
    protected $timestamp =false;
    protected $with = ['translations'];
    protected $translatedAttributes = ['details'];
    protected  $table='product_banner';
    public $fillable =['id','product_ids','image'];

    protected  $hidden=['updated_at','deleted_at'];
    public function getImageAttribute($val )
    {
        return ($val !== null) ? asset('storage/media/' . $val) : "";
    }
    public function getProductIdsAttribute($val )
    {
        return ($val !== null) ? json_decode($val) : "";
    }
    
  
}
