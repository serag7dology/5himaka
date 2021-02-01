<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Modules\Core\Http\Traits\GeneralTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use Modules\User\Entities\User;
class CheckUserToken
{
    use GeneralTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!isset($request->token))
        {
            return $this->returnError(['Not_FOUND_TOKEN'],422);
        }
        //$user=auth()->user();
         
       // if (auth()->check()==false)
        //return $this->returnError(trans('Unauthenticated'),400);
        $user=User::where("token",$request->token)->first();
        //if(!isset($request->token) || $user->token!=$request->token)
        if($user==NULL)
        {
            return $this->returnError(['INVALID_TOKEN'],422);
        }
        

        
        return $next($request);
    }
}
