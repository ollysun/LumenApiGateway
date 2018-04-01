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
     * @param string $endpoint
     */
    public function __construct(string $endpoint)
    {
        parent::__construct(sprintf(
            "There are no scopes defined for endpoint %s",
            $endpoint
        ), 0, null);
    }
}
