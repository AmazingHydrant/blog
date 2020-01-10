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
        foreach ($perm_url as $v) {
            $action =  explode('@', $v)[1];
            $pre =  explode('@', $v)[0];
            if ($action == 'edit') {
                $perm_url[] = $pre . '@' . 'create';
                $perm_url[] = $pre . '@' . 'store';
                $perm_url[] = $pre . '@' . 'update';
                $perm_url[] = $pre . '@' . 'destroy';
            }
            if ($action == 'auth') {
                $perm_url[] = $pre . '@' . 'doauth';
                $perm_url[] = $pre . '@' . 'edit';
                $perm_url[] = $pre . '@' . 'create';
                $perm_url[] = $pre . '@' . 'store';
                $perm_url[] = $pre . '@' . 'update';
                $perm_url[] = $pre . '@' . 'destroy';
            }
        }
        // dd($perm_url);
        $route = \Route::current()->getActionName();
        // dd($route);
        if (!empty($perm_url) and in_array($route, $perm_url)) {
            return $next($request);
        } else {
            // return $next($request);
            return redirect('noAccess');
        }
    }
}
