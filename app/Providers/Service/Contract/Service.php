<?php
namespace App\Providers\Service\Contract;

/**
 * Interface Service
 * @package App\Providers\Service\Contract
 */
interface Service
{
    /**
     * Get service key
     * 
     * @return string
     */
    public function getServiceKey() : string;

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
     * Get routes
     * 
     * @return array
     */
    public function getRoutes() : array;

    /**
     * Get headers
     *
     * @return array
     */
    public function getHeaders() : array;

    /**
     * Get output key
     * 
     * @return string
     */
    public function getOutputKey() : string;
}
