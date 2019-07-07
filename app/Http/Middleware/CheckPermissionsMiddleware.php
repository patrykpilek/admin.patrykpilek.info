<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( ! check_user_permissions($request)) {
//            abort(403, "Forbidden access!");
//            return redirect()->back()->with('error-message', 'This action is unauthorized.');
            return redirect("/")->with('error-message', 'This action is unauthorized.');
        }

        return $next($request);
    }
}
