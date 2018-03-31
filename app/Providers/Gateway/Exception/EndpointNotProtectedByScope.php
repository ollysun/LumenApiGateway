<?php
namespace App\Providers\Gateway\Exception;

/**
 * Class EndpointNotProtectedByScope
 * @package App\Providers\Gateway\Exception
 */
class EndpointNotProtectedByScope extends \Exception
{
    /**
     * EndpointNotProtectedByScope constructor.
     * @param string $service
     * @param string $endpoint
     */
    public function __construct(string $service, string $endpoint)
    {
        parent::__construct(sprintf(
            "There are no scopes defined for endpoint %s on service %s",
            $endpoint,
            $service
        ), 0, null);
    }
}
