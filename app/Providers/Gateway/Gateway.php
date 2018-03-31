<?php
namespace App\Providers\Gateway;

use App\Providers\Gateway\Business\Helper\BuildRequestOptions;
use App\Providers\Gateway\Business\Helper\BuildRequestUrl;
use App\Providers\Gateway\Business\Helper\CheckHttpMethod;
use App\Providers\Gateway\Business\Helper\CheckScopesByUser;
use App\Providers\Gateway\Business\Helper\SearchRouteKeyByEndpoint;
use App\Providers\Gateway\Contract\ActionContract;
use App\Providers\Gateway\Contract\AggregationContract;
use App\Providers\Gateway\Contract\GatewayContract;
use App\Providers\Gateway\Contract\ServiceContract;
use App\Providers\Gateway\Exception\AggregationNotFound;
use App\Providers\Gateway\Exception\InvalidHttpMethodByRoute;
use App\Providers\Gateway\Exception\ServiceNotFound;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\EachPromise;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;
use Laravel\Passport\Exceptions\MissingScopeException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Gateway
 * @package App\Providers\Gateway
 */
class Gateway implements GatewayContract
{
    use BuildRequestUrl,
        SearchRouteKeyByEndpoint,
        CheckScopesByUser,
        CheckHttpMethod,
        BuildRequestOptions;

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
    ) : Response {
        try {
            $service = $this->createService($serviceKey);
        } catch (ServiceNotFound $e) {
            return Response::create([
                'status' => 'ERROR',
                'result' => [
                    'message' => 'Service not found',
                    'service' => $serviceKey
                ]
            ], Response::HTTP_NOT_FOUND);
        }

        $routeKey = $this->searchRouteKeyByEndpoint($endpoint, array_keys($service->getScopesByRoute()));

        $this->checkScopesByUser($service->getScopesByRoute()[$routeKey]);
        $this->checkHttpMethod($httpMethod, $service->getHttpMethodsByRoute()[$routeKey]);

        $guzzle = $this->getGuzzleClient();

        $requestUrl = $this->buildRequestUrl($service, $endpoint, $queryParams);

        try {
            $response = $guzzle->request($httpMethod, $requestUrl, $this->buildRequestOptions(
                $service,
                $payload,
                $headers
            ));

            return response(json_decode($response->getBody()->getContents(), true), $response->getStatusCode());
        } catch (GuzzleException $e) {
            Log::error('Error while dispatching: ' . $e->getMessage(), [
                'url' => $requestUrl,
                'http_method' => $httpMethod
            ]);

            return new Response([
                'status' => 'ERROR',
                'result' => [
                    'message' => $e->getMessage(),
                    'url' => $requestUrl,
                    'http_method' => $httpMethod
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

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
     *
     * @throws InvalidHttpMethodByRoute
     * @throws \Exception
     */
    public function aggregation(
        string $aggregationKey,
        string $endpoint,
        array $queryParams,
        string $httpMethod,
        array $payload = [],
        array $headers = []
    ) : Response {
        try {
            $aggregation = $this->createAggregation($aggregationKey);
        } catch (AggregationNotFound $e) {
            return Response::create([
                'status' => 'ERROR',
                'result' => [
                    'message' => 'Aggregation not found',
                    'aggregation' => $aggregationKey
                ]
            ], Response::HTTP_NOT_FOUND);
        }

        $this->checkHttpMethod($httpMethod, $aggregation->getHttpMethod());

        if (!preg_match(sprintf("/^%s$/", $aggregation->getEndpoint()), $endpoint, $urlParams)) {
            throw new \Exception();
        }

        $guzzle = $this->getGuzzleClient();

        $actionClasses = array_values($aggregation->getActions());

        $requests = (function () use ($guzzle, $actionClasses, $queryParams, $urlParams, $payload, $headers) {
            foreach ($actionClasses as $actionClass) {
                $action = $this->createAction($actionClass);

                $this->checkScopesByUser($action->getScopes());

                try {
                    $service = $this->createService($action->getService());
                } catch (ServiceNotFound $e) {
                    continue;
                }

                yield $guzzle->requestAsync(
                    $action->getHttpMethod(),
                    $this->buildRequestUrl($service, $action->getPath(), $queryParams, $urlParams),
                    $this->buildRequestOptions(
                        $service,
                        $payload,
                        $headers
                    )
                )->then(function (ResponseInterface $response) {
                    return json_decode($response->getBody(), true);
                });
            }
        })();

        $actionKeys = array_keys($aggregation->getActions());

        $result = [];

        (new EachPromise($requests, [
            'concurrency' => count($requests),
            'fulfilled' => function (array $response) use ($actionKeys, &$result) {
                $result[$actionKeys[count($result)]] = $response;
            }
        ]))->promise()->wait();

        return response($result);
    }

    /**
     * Create service
     *
     * @param string $serviceKey
     * @return ServiceContract
     * @throws ServiceNotFound
     */
    private function createService(string $serviceKey) : ServiceContract
    {
        $serviceClass = config(sprintf("gateway.services.%s", $serviceKey));
        if ($serviceClass) {
            $service = new $serviceClass();
            if ($service instanceof ServiceContract) {
                return $service;
            }
        }

        throw new ServiceNotFound();
    }

    /**
     * Create aggregation
     *
     * @param string $aggregationKey
     * @return AggregationContract
     * @throws AggregationNotFound
     */
    private function createAggregation(string $aggregationKey) : AggregationContract
    {
        $aggregationClass = config(sprintf("gateway.aggregations.%s", $aggregationKey));
        if ($aggregationClass) {
            $aggregation = new $aggregationClass();
            if ($aggregation instanceof AggregationContract) {
                return $aggregation;
            }
        }

        throw new AggregationNotFound();
    }

    /**
     * Create action
     *
     * @param string $actionClass
     * @return ActionContract
     *
     * @throws \Exception
     */
    private function createAction(string $actionClass) : ActionContract
    {
        $action = new $actionClass();

        if (!$action) {
            throw new \Exception(sprintf(
                "The action does not exist: %s",
                $actionClass
            ));
        }

        if (!$action instanceof ActionContract) {
            throw new \Exception(sprintf(
                "The action is not an instance of ActionContract: %s",
                $actionClass
            ));
        }

        return $action;
    }

    private function getGuzzleClient() : ClientInterface
    {
        return app(ClientInterface::class);
    }
}
