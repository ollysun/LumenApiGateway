<?php
namespace App\Providers\Gateway\Business\Helper;

/**
 * Trait SearchRouteKeyByEndpoint
 * @package App\Providers\Gateway\Business\Helper
 */
trait SearchRouteKeyByEndpoint
{
    /**
     * @var null|string
     */
    private $routeKey;

    /**
     * Search route key by endoint
     *
     * @param string $endpoint
     * @param array $routeKeys
     * @return string
     */
    public function searchRouteKeyByEndpoint(string $endpoint, array $routeKeys) : string
    {
        if ($this->routeKey) {
            return $this->routeKey;
        }

        foreach ($routeKeys as $route) {
            if (preg_match(sprintf("/^%s$/", $route), $endpoint)) {
                $this->routeKey = $route;
                break;
            }
        }

        return $this->routeKey;
    }
}
