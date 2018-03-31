<?php
namespace App\Http\Aggregations;

use App\Http\Aggregations\Actions\JsonPlaceholder\PostList;
use App\Http\Aggregations\Actions\JsonPlaceholder\PostSingle;
use App\Providers\Gateway\Contract\AggregationContract;

/**
 * Class JsonPlaceholder
 * @package App\Http\Aggregations
 */
class JsonPlaceholder implements AggregationContract
{
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
        return 'posts\/(?<postId>[0-9]+)';
    }

    /**
     * Get actions
     *
     * @return array
     */
    public function getActions(): array
    {
        return [
            'post-single' => PostSingle::class,
            'post-list' => PostList::class
        ];
    }
}
