<?php
namespace App\Providers\Aggregation\Contract;

/**
 * Interface Aggregation
 * @package App\Providers\Aggregation\Contract
 */
interface Aggregation
{
    /**
     * Get aggregation key
     * 
     * @return string
     */
    public function getAggregationKey() : string;

    /**
     * Get http method
     *
     * @return array
     */
    public function getHttpMethod() : array;

    /**
     * Get endpoint
     *
     * @return string
     */
    public function getEndpoint() : string;

    /**
     * Get actions
     *
     * @return array
     */
    public function getActions() : array;
}
