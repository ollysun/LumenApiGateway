<?php
namespace App\Providers\Aggregation;

use App\Providers\Aggregation\Contract\AggregationContract;
use App\Providers\Aggregation\Contract\Aggregation as ConfigAggregation;
use App\Providers\Aggregation\Contract\Action;

class Aggregation implements AggregationContract
{
    public function getAggregation(string $aggregationKey) : ConfigAggregation
    {
        $aggregations = [];

        foreach (new \DirectoryIterator(base_path(config('gateway.aggregation.dir'))) as $fileinfo) {
            if (!$fileinfo->isDot()) {
                if (!$fileinfo->isFile() || substr($fileinfo->getFilename(), 0, 1) == '.') {
                    continue;
                }

                if (preg_match(sprintf("/^(?<class>.*).%s$/", $fileinfo->getExtension()), $fileinfo->getFilename(), $matches)) {
                    $class = sprintf(
                        "%s\%s",
                        config('gateway.aggregation.namespace'),
                        $matches['class']
                    );

                    $aggregation = new $class();

                    if ($aggregation instanceof ConfigAggregation) {
                        if (array_key_exists($aggregation->getAggregationKey(), $aggregations)) {
                            throw new \Exception(sprintf("The aggregation key already exist: %s", $aggregation->getAggregationKey()()));
                        }
        
                        $aggregations[$aggregation->getAggregationKey()] = $aggregation;
                    }
                }
            }
        }

        if (array_key_exists($aggregationKey, $aggregations)) {
            return $aggregations[$aggregationKey];
        }

        throw new AggregationNotFound();
    }

    public function getAction(string $actionClass) : Action
    {
        $action = new $actionClass();

        if (!$action) {
            throw new \Exception(sprintf(
                "The action does not exist: %s",
                $actionClass
            ));
        }

        if (!$action instanceof Action) {
            throw new \Exception(sprintf(
                "The action is not an instance of ActionContract: %s",
                $actionClass
            ));
        }

        return $action;
    }
}
