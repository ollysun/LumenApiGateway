<?php
namespace App\Providers\Gateway\Exception;

/**
 * Class InvalidHttpMethodByRoute
 * @package App\Providers\Gateway\Exception
 */
class InvalidHttpMethodByRoute extends \Exception
{
    /**
     * InvalidHttpMethodByRoute constructor.
     * @param string $httpMethod
     */
    public function __construct(string $httpMethod)
    {
        parent::__construct(sprintf(
            "The http method %s is not accepted on route.",
            $httpMethod
        ), 0, null);
    }
}
