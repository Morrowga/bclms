<?php

namespace Src\Auth\Domain\Middleware;

use Closure;

class isSuperAdminnBcStaff
{
    public function handle($request, Closure $next)
    {
        if (auth()->user()->role->name == 'BC Staff' || auth()->user()->role->name == 'BC Super Admin') {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
