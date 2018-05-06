<?php
namespace App\Http\Aggregations;

use App\Providers\Aggregation\Contract\Aggregation;
use App\Http\Aggregations\Actions\Test\ArrayAction;
use App\Http\Aggregations\Actions\Test\SingleArrayAction;
use App\Http\Aggregations\Actions\Test\SingleArrayOfArrayAction;

/**
 * Class Test
 * @package App\Http\Aggregations
 */
class Test implements Aggregation
{
    /**
     * Get aggregation key
     * 
     * @return string
     */
    public function getAggregationKey() : string
    {
        return 'test';
    }

    /**
     * Get http method
     *
     * @return array
     */
    public function getHttpMethod(): array
    {
        return [
            'GET'
        ];
    }

    /**
     * Get endpoint
     *
     * @return string
     */
    public function getEndpoint(): string
    {
        return 'array\/(?<arrayId>[0-9]+)';
    }

    /**
     * Get actions
     *
     * @return array
     */
    public function getActions(): array
    {
        return [
            'array' => ArrayAction::class,
            'single-array' => SingleArrayAction::class,
            'single-array-of-array' => SingleArrayOfArrayAction::class
        ];
    }
}
