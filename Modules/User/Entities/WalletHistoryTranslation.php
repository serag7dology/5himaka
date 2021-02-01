<?php

namespace Modules\User\Entities;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class WalletHistoryTranslation extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['locale', 'operation_type','wallet_history_id'];

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
