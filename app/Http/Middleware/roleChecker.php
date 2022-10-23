<?php

namespace App\Http\Middleware;

use App\Http\Controllers\api\ApiRespose;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class roleChecker
{
    use ApiRespose;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {


        if (Auth::user()->role_id==2)
        return $next($request);
        else
        return $this->apiResponse('',"this is not in your permission",403);
    }
}
