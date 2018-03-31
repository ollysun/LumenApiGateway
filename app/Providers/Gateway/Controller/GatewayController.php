<?php
namespace App\Providers\Gateway\Controller;

use App\Providers\Gateway\Contract\GatewayContract;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

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
        return $this->getGatewayService()->gateway(
            $serviceKey,
            $endpoint,
            $request->query(),
            $request->getMethod(),
            $request->request->all(),
            $request->headers->all()
        );
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
        return $this->getGatewayService()->aggregation(
            $aggregationKey,
            $endpoint,
            $request->query(),
            $request->getMethod(),
            $request->request->all(),
            $request->headers->all()
        );
    }

    private function getGatewayService() : GatewayContract
    {
        return app(GatewayContract::class);
    }
}
