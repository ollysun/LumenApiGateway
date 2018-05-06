<?php
namespace App\Providers\Service\Provider;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Providers\Service\Contract\ServiceContract;
use App\Providers\Service\Service;

/**
 * Class ServiceProvider
 * @package App\Providers\Service\Provider
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
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ServiceContract::class, function () {
            return new Service();
        });
    }
}
