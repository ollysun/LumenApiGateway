<?php
namespace App\Providers\Gateway\Contract;

/**
 * Interface AggregationContract
 * @package App\Providers\Gateway\Contract
 */
interface AggregationContract
{
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
