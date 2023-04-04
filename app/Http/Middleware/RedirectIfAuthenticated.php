<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                if (Auth::check() && Auth::user()->role_id == 5 && Auth::user()->status == 1){
                    return redirect()->route('user.dashboard');
                }
                elseif (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role_id == 1){
                    return redirect()->route('superadmin.dashboard');
                }
                elseif (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role_id == 2){
                    return redirect()->route('admin.dashboard');
                }
                elseif (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role_id == 3){
                    return redirect()->route('moderator.dashboard');
                }
            }
        }
        return $next($request);
    }
}
