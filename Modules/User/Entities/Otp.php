<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $table = 'temporary_otp';
    protected $fillable = [
        'email', 'code' ,'receiver_id'
    ];
}
