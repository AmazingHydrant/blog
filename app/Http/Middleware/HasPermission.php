<?php

namespace App\Http\Middleware;

use Closure;

class HasPermission
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
        $perm_url = session()->get('perm_url');
        $route = \Route::current()->getActionName();
        if (in_array($route, $perm_url)) {
            return $next($request);
        } else {
            return $next($request);
            return redirect('noAccess');
        }
    }
}
