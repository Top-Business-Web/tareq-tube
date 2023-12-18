<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckClientAuthenticateApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $auth = Auth::guard('user-api')->user();

        if($auth->type == 'driver'){
            return response()->json(['data' => null,'message' => 'The Client only Access this link, The driver not access this link','code' => 403]);

        }else{
            return $next($request);

        }
    }
}
