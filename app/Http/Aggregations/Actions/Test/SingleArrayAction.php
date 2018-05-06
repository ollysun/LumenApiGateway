<?php
namespace App\Http\Aggregations\Actions\Test;

use App\Providers\Aggregation\Contract\Action;

/**
 * Class SingleArrayAction
 * @package App\Http\Aggregations\Actions\Test
 */
class SingleArrayAction implements Action
{
    /**
     * Get service
     *
     * @return string
     */
    public function getService(): string
    {
        return 'test';
    }

    /**
     * Get http method
     *
     * @return string
     */
    public function getHttpMethod(): string
    {
        return 'GET';
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath(): string
    {
        return 'array/{arrayId}';
    }

    /**
     * Get scopes
     *
     * @return array
     */
    public function getScopes(): array
    {
        return [
            'gateway'
        ];
    }

    /**
     * Get priority
     * 
     * @return int
     */
    public function getPriority() : int
    {
        return 2;
    }
}
