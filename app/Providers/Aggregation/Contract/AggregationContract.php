<?php
namespace App\Providers\Aggregation\Contract;

use App\Providers\Aggregation\Contract\Aggregation;

interface AggregationContract
{
    public function getAggregation(string $aggregationKey) : Aggregation;

    public function getAction(string $actionClass) : Action;
}
