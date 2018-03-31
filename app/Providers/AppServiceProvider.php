<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['router']->get('triadev/pe/metrics', [
            'uses' =>  \Triadev\PrometheusExporter\Controller\PrometheusExporterController::class . '@metrics'
        ]);
    }
}
