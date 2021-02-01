<?php

namespace Modules\Withdraw\Entities;

use Modules\Support\Eloquent\TranslationModel;

class WithdrawsWayTranslation extends TranslationModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'field_name'];
}
