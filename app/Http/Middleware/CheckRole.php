<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$role)
    {
        if($request->user() && $request->user()->user_type !== $role){
            return response()->json(["message"=>'Unauthorized action.'],401);
        }
        return $next($request);
    }
}
