<?php

namespace Modules\Plan\Entities;

use Modules\Support\Eloquent\TranslationModel;

class PlanTranslation extends TranslationModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['currency','duration','limit','subscription_cost','commission','max_people','min_commission_to_appear'];
    
}
