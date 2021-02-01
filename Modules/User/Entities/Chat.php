<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chats';
    protected $fillable = [
        'sender_id',
        'product_id',
        'message',
        'type',
        'status'
    ];

}
