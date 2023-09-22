<?php

namespace Src\Common\Infrastructure\Laravel\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Src\Common\Infrastructure\Laravel\Providers\RouteServiceProvider;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {

        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                if (auth()->user()->organization_idd) {

                    $organization = auth()->user()->load('organization');

                    return redirect('http://'.$organization->organization->name.'.'.request()->getHost().'/c/');

                }

                return redirect(RouteServiceProvider::HOME);
            }

        }

        return $next($request);
    }
}
