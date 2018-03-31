<?php
namespace App\Providers\Gateway\Contract;

use App\Providers\Gateway\Exception\EndpointNotProtectedByScope;
use App\Providers\Gateway\Exception\InvalidHttpMethodByRoute;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
use Laravel\Passport\Exceptions\MissingScopeException;

/**
 * Interface GatewayContract
 * @package App\Providers\Gateway\Contract
 */
interface GatewayContract
{
    /**
     * Gateway
     *
     * @param string $serviceKey
     * @param string $endpoint
     * @param array $queryParams
     * @param string $httpMethod
     * @param array $payload
     * @param array $headers
     * @return Response
     *
     * @throws AuthenticationException
     * @throws EndpointNotProtectedByScope
     * @throws MissingScopeException
     * @throws InvalidHttpMethodByRoute
     */
    public function gateway(
        string $serviceKey,
        string $endpoint,
        array $queryParams,
        string $httpMethod,
        array $payload = [],
        array $headers = []
    ) : Response;

    /**
     * Aggregation
     *
     * @param string $aggregationKey
     * @param string $endpoint
     * @param array $queryParams
     * @param string $httpMethod
     * @param array $payload
     * @param array $headers
     * @return Response
     */
    public function aggregation(
        string $aggregationKey,
        string $endpoint,
        array $queryParams,
        string $httpMethod,
        array $payload = [],
        array $headers = []
    ) : Response;
}
