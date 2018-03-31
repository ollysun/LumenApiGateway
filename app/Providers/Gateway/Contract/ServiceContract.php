<?php
namespace App\Providers\Gateway\Contract;

/**
 * Interface ServiceContract
 * @package App\Providers\Gateway\Contract
 */
interface ServiceContract
{
    /**
     * Get scheme
     *
     * @return string
     */
    public function getScheme() : string;

    /**
     * Get host
     *
     * @return string
     */
    public function getHost() : string;

    /**
     * Get port
     *
     * @return int
     */
    public function getPort() : int;

    /**
     * Get prefix
     *
     * @return null|string
     */
    public function getPrefix() : ?string;

    /**
     * Get timeout
     *
     * @return int
     */
    public function getTimeout() : int;

    /**
     * Get http methods by route
     *
     * @return array
     */
    public function getHttpMethodsByRoute() : array;

    /**
     * Get scopes by route
     *
     * @return array
     */
    public function getScopesByRoute() : array;

    /**
     * Get headers
     *
     * @return array
     */
    public function getHeaders() : array;
}
