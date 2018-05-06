<?php
namespace App\Providers\Aggregation\Provider;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Providers\Aggregation\Contract\AggregationContract;
use App\Providers\Aggregation\Aggregation;

/**
 * Class ServiceProvider
 * @package App\Providers\Aggregation\Provider
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
        $this->app->singleton(AggregationContract::class, function () {
            return new Aggregation();
        });
    }
}
