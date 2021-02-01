<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Debug option
    |--------------------------------------------------------------------------
    | Accept boolean value , and toggle between the production endpoint and sandbox
    */

    'debug' => env('FAWRY_DEBUG', true),

    /*
    |--------------------------------------------------------------------------
    | Fawry Keys
    |--------------------------------------------------------------------------
    |
    | The Fawry publishable key and secret key give you access to Fawry's
    | API.
    */

    'merchant_code' => '1tSa6uxz2nQvR6pbttqFMg==',

    'security_key' => 'c07e5cad64bd4f24ab848ba32901f618',

    'users_table' => 'users',

    'user_model' => Modules\User\Entities\User::class

];
