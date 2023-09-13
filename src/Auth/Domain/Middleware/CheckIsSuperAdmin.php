<?php

namespace Src\Auth\Domain\Middleware;

use Closure;

class CheckIsSuperAdmin
{
    public function handle($request, Closure $next)
    {
        if (auth()->user()->role->name != 'BC Super Admin') {

            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
