<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Modules\Plan\Entities\Plan;
use Modules\User\Entities\User;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            $user=User::find(auth()->id());
        
            
            $plan=Plan::first();
            $subscription_cost=$plan->subscription_cost;
            if($user->is_paid==0){
                return redirect()->route('products.index');
                return view('user::admin.payment.create',compact('subscription_cost'));

            }
            return $next($request);
        }

        $url = url()->full();

        if (! $request->isMethod('get')) {
            $url = url()->previous();
        }

        session()->put('url.intended', $url);

        if ($request->ajax()) {
            abort(403, 'Unauthenticated.');
        }

        return redirect()->route('login');
    }
}
