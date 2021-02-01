<?php

namespace Modules\Product\Entities;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductBannerTranslation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['locale', 'details','product_banner_id'];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saved(function ($translationTranslation) {
            $translationTranslation->clearCache();
        });
    }

    /**
     * Clear translations cache.
     *
     * @return bool
     */
    public static function clearCache()
    {
        Cache::tags('translations')->flush();
    }
}
