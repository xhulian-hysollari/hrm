<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class RedirectIfNotReception
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
        if ($request->user()->role != User::USER_ROLE_RECEPTION) {
            return redirect()->back();
        }

        return $next($request);
    }
}
