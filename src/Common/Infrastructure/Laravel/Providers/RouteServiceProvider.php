<?php

namespace Src\Common\Infrastructure\Laravel\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {


            // for web route
            Route::middleware(['web'])
                ->group(function () {
                    require base_path('src/Auth/Presentation/HTTP/routes.php');
                    require base_path('src/BlendedConcept/System/Presentation/HTTP/routes.php');
                    require base_path('src/BlendedConcept/Security/Presentation/HTTP/routes.php');
                    require base_path('src/BlendedConcept/Organization/Presentation/HTTP/routes.php');
                    require base_path('src/BlendedConcept/Student/Presentation/HTTP/routes.php');
                    require base_path('src/BlendedConcept/ClassRoom/Presentation/HTTP/routes.php');
                    require base_path('src/BlendedConcept/Teacher/Presentation/HTTP/routes.php');
                });

            // for api route
            Route::middleware('api')
                ->group(base_path('routes/api.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });
    }
}
