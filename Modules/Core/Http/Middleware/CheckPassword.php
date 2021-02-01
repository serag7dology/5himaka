<?php

namespace Modules\Core\Http\Middleware;

use Closure;

class CheckPassword
{
       /**
        * Handle an incoming request.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  \Closure  $next
        * @return mixed
        */
 
        public function handle($request, Closure $next)
        {
            // $user = $request->header('php-auth-user');
            // $password = $request->header('php-auth-pw');
            // if($user!=env('Api_User') || $password!=env('Api_Password'))
            // {
            //     if(app()->getLocale()=='ar')
            //         {
            //             $message='انت غير مصرحك بك';
            //         }
            //         else
            //         {
            //             $message='unauthenticated';
            //         }
            //         return response()->json([
            //             'status' => false,
            //             'errors' => [$message]
            //         ],400);
            // }
            
            return $next($request);
        }
    
}
