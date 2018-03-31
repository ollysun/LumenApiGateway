<?php
namespace App\Providers\Gateway\Business\Helper;

use App\Providers\Gateway\Exception\InvalidHttpMethodByRoute;

/**
 * Trait CheckHttpMethod
 * @package App\Providers\Gateway\Business\Helper
 */
trait CheckHttpMethod
{
    /**
     * Check http method
     *
     * @param string $httpMethod
     * @param array $validHttpMethods
     * @throws InvalidHttpMethodByRoute
     */
    public function checkHttpMethod(string $httpMethod, array $validHttpMethods)
    {
        if (!in_array($httpMethod, $validHttpMethods)) {
            throw new InvalidHttpMethodByRoute($httpMethod);
        }
    }
}
