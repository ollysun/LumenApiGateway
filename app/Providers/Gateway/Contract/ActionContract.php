<?php
namespace App\Providers\Gateway\Contract;

/**
 * Interface ActionContract
 * @package App\Providers\Gateway\Contract
 */
interface ActionContract
{
    /**
     * Get service
     *
     * @return string
     */
    public function getService() : string;

    /**
     * Get http method
     *
     * @return string
     */
    public function getHttpMethod() : string;

    /**
     * Get path
     *
     * @return string
     */
    public function getPath() : string;

    /**
     * Get scopes
     *
     * @return array
     */
    public function getScopes() : array;
}
