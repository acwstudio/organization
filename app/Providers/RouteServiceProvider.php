<?php

namespace App\Providers;

use App\Routing\Concerns\MapsRouteRegistrars;
use App\Routing\Registrars\CityRegistar;
use App\Routing\Registrars\DefaultRegistrar;
use App\Routing\Registrars\OrganizationRegistrar;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    use MapsRouteRegistrars;

    protected array $registrars = [
        DefaultRegistrar::class,
        OrganizationRegistrar::class,
        CityRegistar::class,
    ];

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

        $this->routes(function (Registrar $router) {
            $this->mapRoutes($router, $this->registrars);
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
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
