<?php
namespace App\Providers\Gateway\Provider;

use App\Providers\Gateway\Controller\GatewayController;
use App\Providers\Gateway\Contract\GatewayContract;
use App\Providers\Gateway\Gateway;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Laravel\Passport\Passport;

/**
 * Class ServiceProvider
 * @package App\Providers\Gateway\Provider
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $source = realpath(__DIR__ . '/../Config/config.php');

        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('gateway.php'),
        ], 'config');

        $this->mergeConfigFrom($source, 'gateway');

        Passport::tokensCan(config('gateway.scopes'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRoutes();

        $this->app->singleton(GatewayContract::class, function () {
            return new Gateway();
        });

        $this->app->bind(ClientInterface::class, function ($app) {
            return new Client([
                'connect_timeout' => 5,
                'http_errors' => false
            ]);
        });
    }

    private function registerRoutes()
    {
        $this->app['router']->group([
            'prefix' => 'gateway/aggregation/{aggregationKey:[a-zA-Z]+}/{endpoint:.*}',
            'middleware' => [
                'auth:api'
            ]
        ], function () {
            $this->app['router']->get('', [
                'uses' => GatewayController::class . '@aggregation',
                'middleware' => [
                    'anyScope:read'
                ]
            ]);

            $this->app['router']->post('', [
                'uses' => GatewayController::class . '@aggregation',
                'middleware' => [
                    'anyScope:write'
                ]
            ]);

            $this->app['router']->put('', [
                'uses' => GatewayController::class . '@aggregation',
                'middleware' => [
                    'anyScope:write'
                ]
            ]);

            $this->app['router']->delete('', [
                'uses' => GatewayController::class . '@aggregation',
                'middleware' => [
                    'anyScope:write'
                ]
            ]);
        });

        $this->app['router']->group([
            'prefix' => 'gateway/{serviceKey:[a-zA-Z]+}/{endpoint:.*}',
            'middleware' => [
                'auth:api'
            ]
        ], function () {
            $this->app['router']->get('', [
                'uses' => GatewayController::class . '@gateway',
                'middleware' => [
                    'anyScope:read'
                ]
            ]);

            $this->app['router']->post('', [
                'uses' => GatewayController::class . '@gateway',
                'middleware' => [
                    'anyScope:write'
                ]
            ]);

            $this->app['router']->put('', [
                'uses' => GatewayController::class . '@gateway',
                'middleware' => [
                    'anyScope:write'
                ]
            ]);

            $this->app['router']->delete('', [
                'uses' => GatewayController::class . '@gateway',
                'middleware' => [
                    'anyScope:write'
                ]
            ]);
        });
    }
}
