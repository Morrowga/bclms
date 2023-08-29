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

    // public const HOME = ""

    /***************************************************************
     *
     *  Maps the web routes for that does not belong to tenant.
     *  This method is responsible for mapping the web routes for the with tenant on the central domains.
     *  It iterates through the central domains and sets up the necessary middleware, domain, and namespace
     *  for each domain. Then it groups the routes and requires the route files for different modules
     *  within the does not belong to tenant.
     *  @return void
     *
     *******/
    protected function mapWebRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::middleware(
                ['web']
            )
                ->domain($domain)
                ->namespace($this->namespace)
                ->group(function () {
                    require base_path('src/Auth/Presentation/HTTP/routes.php');
                    require base_path('src/BlendedConcept/System/Presentation/HTTP/routes.php');
                    require base_path('src/BlendedConcept/Security/Presentation/HTTP/routes.php');
                    require base_path('src/BlendedConcept/Organization/Presentation/HTTP/routes.php');
                    require base_path('src/BlendedConcept/Student/Presentation/HTTP/routes.php');
                    require base_path('src/BlendedConcept/ClassRoom/Presentation/HTTP/routes.php');
                    require base_path('src/BlendedConcept/Teacher/Presentation/HTTP/routes.php');
                    require base_path('src/BlendedConcept/Survey/Presentation/HTTP/routes.php');
                    require base_path('src/BlendedConcept/StoryBook/Presentation/HTTP/routes.php');
                    require base_path('src/BlendedConcept/Library/Presentation/HTTP/routes.php');
                    require base_path('src/BlendedConcept/Finance/Presentation/HTTP/routes.php');
                    require base_path('src/BlendedConcept/Disability/Presentation/HTTP/routes.php');
                });
        }
    }

    /**
     * Maps all API routes to the specified domains.
     *
     * @param  array  $domains An array of domains to map the API routes to.
     */
    protected function mapApiRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            // Create a new route group with the following settings:
            // - Prefix: `api`
            // - Domain: $domain
            // - Middleware: `api`
            // - Namespace: $this->namespace
            // - Group: `base_path('routes/api.php')`
            Route::prefix('api')
                ->domain($domain)
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
        }
    }

    /**
     * Returns an array of central domains.
     */
    protected function centralDomains(): array
    {
        // Get the central domains from the configuration file.
        return config('tenancy.central_domains');
    }

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->mapApiRoutes();
            $this->mapWebRoutes();
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
