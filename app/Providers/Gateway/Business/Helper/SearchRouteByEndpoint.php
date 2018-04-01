<?php
namespace App\Providers\Gateway\Business\Helper;

use App\Providers\Gateway\Model\Route;

/**
 * Trait SearchRouteByEndpoint
 * @package App\Providers\Gateway\Business\Helper
 */
trait SearchRouteByEndpoint
{
    /**
     * Search route by endoint
     *
     * @param string $endpoint
     * @param array $routes
     * @return Route|null
     */
    public function searchRouteByEndpoint(string $endpoint, array $routes) : ?Route
    {
        foreach ($routes as $routeKey => $route) {
            if (preg_match(sprintf("/^%s$/", $routeKey), $endpoint)) {
                return new Route(
                    $route['methods'],
                    $route['scopes']
                );
            }
        }

        return null;
    }
}
