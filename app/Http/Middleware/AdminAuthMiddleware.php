<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('admin/login');
            }
        }

        /*if (Auth::guard($guard)->check()) {
            // 根据不同 guard 跳转到不同的页面
            $url = $guard ? 'admin/login':'/';
            return redirect($url);
        }*/
        return $next($request);
    }
}