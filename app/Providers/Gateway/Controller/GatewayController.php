<?php
namespace App\Providers\Gateway\Controller;

use App\Providers\Gateway\Contract\GatewayContract;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Triadev\PrometheusExporter\Contract\PrometheusExporterContract;

/**
 * Class GatewayController
 * @package App\Providers\Gateway\Controller
 */
class GatewayController extends Controller
{
    /**
     * Gateway
     *
     * @param Request $request
     * @param string $serviceKey
     * @param string $endpoint
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     *
     * @throws \App\Providers\Gateway\Exception\EndpointNotProtectedByScope
     * @throws \App\Providers\Gateway\Exception\InvalidHttpMethodByRoute
     * @throws \Illuminate\Auth\AuthenticationException
     * @throws \Laravel\Passport\Exceptions\MissingScopeException
     */
    public function gateway(Request $request, string $serviceKey, string $endpoint)
    {
        $start = microtime(true);

        $response = $this->getGatewayService()->gateway(
            $serviceKey,
            $endpoint,
            $request->query(),
            $request->getMethod(),
            $request->request->all(),
            $request->headers->all()
        );

        $this->getPrometheusExporter()->setHistogram(
            'request_duration_milliseconds',
            'gateway request duration in milliseconds',
            round((microtime(true) - $start) * 1000.0),
            'http',
            [
                'status',
                'handler'
            ],
            [
                $response->getStatusCode(),
                'gateway'
            ],
            [
                5, 10, 25, 50, 75, 100, 250, 500, 750, 1000, 2500, 5000, 7500, 10000, 15000, 25000, 50000
            ]
        );

        return $response;
    }

    /**
     * Aggregation
     *
     * @param Request $request
     * @param string $aggregationKey
     * @param string $endpoint
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function aggregation(Request $request, string $aggregationKey, string $endpoint)
    {
        $start = microtime(true);

        $response = $this->getGatewayService()->aggregation(
            $aggregationKey,
            $endpoint,
            $request->query(),
            $request->getMethod(),
            $request->request->all(),
            $request->headers->all()
        );

        $this->getPrometheusExporter()->setHistogram(
            'request_duration_milliseconds',
            'gateway aggregation request duration in milliseconds',
            round((microtime(true) - $start) * 1000.0),
            'http',
            [
                'status',
                'handler'
            ],
            [
                $response->getStatusCode(),
                'gateway_aggregation'
            ],
            [
                5, 10, 25, 50, 75, 100, 250, 500, 750, 1000, 2500, 5000, 7500, 10000, 15000, 25000, 50000
            ]
        );

        return $response;
    }

    private function getGatewayService() : GatewayContract
    {
        return app(GatewayContract::class);
    }

    private function getPrometheusExporter() : PrometheusExporterContract
    {
        return app(PrometheusExporterContract::class);
    }
}
