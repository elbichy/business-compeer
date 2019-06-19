<?php

namespace App\Http\Middleware;

use Closure;

class BusinessExists
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
        if(auth()->user()->business_id == 0){
            return redirect(route('businessSettings'))->with('noBusinessRecord', 'You need to Setup a Business first');
        }else if(auth()->user()->branch_id == 0){
            return redirect(route('branchSettings'))->with('noBusinessRecord', 'You have Setup Main Branch atleast');
        }
        return $next($request);
    }
}
