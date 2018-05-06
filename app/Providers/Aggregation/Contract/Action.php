<?php
namespace App\Providers\Aggregation\Contract;

/**
 * Interface Action
 * @package App\Providers\Aggregation\Contract
 */
interface Action
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

    /**
     * Get priority
     * 
     * @return int
     */
    public function getPriority() : int;
}
