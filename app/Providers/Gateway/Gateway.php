<?php
namespace App\Providers\Gateway;

use App\Providers\Gateway\Business\Helper\BuildRequestOptions;
use App\Providers\Gateway\Business\Helper\BuildRequestUrl;
use App\Providers\Gateway\Business\Helper\CheckHttpMethod;
use App\Providers\Gateway\Business\Helper\CheckScopesByUser;
use App\Providers\Gateway\Business\Helper\SearchRouteByEndpoint;
use App\Providers\Gateway\Contract\GatewayContract;
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
use PHPUnit\Util\Printer;
use App\Providers\Gateway\Model\Route;
use Illuminate\Support\Facades\Cache;
use App\Providers\Service\Contract\ServiceContract;
use App\Providers\Aggregation\Contract\AggregationContract;
use App\Providers\Aggregation\Contract\Action;

/**
 * Class Gateway
 * @package App\Providers\Gateway
 */
class Gateway implements GatewayContract
{
    use BuildRequestUrl,
        SearchRouteByEndpoint,
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
            $service = $this->getServicesService()->getService($serviceKey);
        } catch (ServiceNotFound $e) {
            return Response::create([
                'status' => 'ERROR',
                'result' => [
                    'message' => 'Service not found',
                    'service' => $serviceKey
                ]
            ], Response::HTTP_NOT_FOUND);
        }

        $route = $this->searchRouteByEndpoint($endpoint, $service->getRoutes());

        $this->checkScopesByUser($route);
        $this->checkHttpMethod($httpMethod, $route->getMethods());

        $guzzle = $this->getGuzzleClient();

        $requests = (function () use ($guzzle, $service, $httpMethod, $endpoint, $queryParams, $payload, $headers) {
            yield $service->getOutputKey() => $guzzle->requestAsync(
                $httpMethod,
                $this->buildRequestUrl($service, $endpoint, $queryParams),
                $this->buildRequestOptions(
                    $service,
                    $payload,
                    $headers
                )
            )->then(function (ResponseInterface $response) {
                return json_decode($response->getBody(), true);
            });
        })();

        return new Response(
            $this->dispatch($requests)
        );
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
            $aggregation = $this->getAggregationService()->getAggregation($aggregationKey);
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

        $priorityActions = [];

        foreach ($aggregation->getActions() as $actionKey => $actionClass) {
            $action = $this->getAggregationService()->getAction($actionClass);

            if (!array_key_exists($action->getPriority(), $priorityActions)) {
                $priorityActions[$action->getPriority()] = [];
            }

            $priorityActions[$action->getPriority()][$actionKey] = $action;
        }

        ksort($priorityActions, SORT_NUMERIC);

        $guzzle = $this->getGuzzleClient();

        $result = [];

        foreach ($priorityActions as $actions) {
            $requests = (function () use ($guzzle, $actions, $queryParams, $urlParams, $payload, $headers) {
                /** @var ServiceContract $services */
                $services = app(ServiceContract::class);

                foreach ($actions as $actionKey => $action) {
                    $route = new Route([
                        $action->getHttpMethod()
                    ], $action->getScopes());
    
                    $this->checkScopesByUser($route);
    
                    try {
                        $service = $services->getService($action->getService());
                    } catch (ServiceNotFound $e) {
                        continue;
                    }
    
                    yield $actionKey => $guzzle->requestAsync(
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

            $result = array_merge($result, $this->dispatch($requests));
        }

        return new Response($result);
    }
    
    private function dispatch(\Generator $requests) : array
    {
        $result = [];

        (new EachPromise($requests, [
            'concurrency' => 4,
            'fulfilled' => function (array $response, $key) use ($requests, &$result) {
                $result[$key] = $response;
            }
        ]))->promise()->wait();

        return $result;
    }

    private function getGuzzleClient() : ClientInterface
    {
        return app(ClientInterface::class);
    }

    private function getServicesService() : ServiceContract
    {
        return app(ServiceContract::class);
    }

    private function getAggregationService() : AggregationContract
    {
        return app(AggregationContract::class);
    }
}
