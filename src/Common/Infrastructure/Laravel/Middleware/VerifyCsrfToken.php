<?php

namespace Src\Common\Infrastructure\Laravel\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'login',
        'admin/h5p/ajax',
        'admin/h5p/ajax/*',
        'admin/h5p/*',
        'bc/admin/*'
    ];
}
