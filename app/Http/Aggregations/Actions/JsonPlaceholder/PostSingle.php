<?php
namespace App\Http\Aggregations\Actions\JsonPlaceholder;

use App\Providers\Gateway\Contract\ActionContract;

/**
 * Class PostSingle
 * @package App\Http\Aggregations\Actions\JsonPlaceholder
 */
class PostSingle implements ActionContract
{
    /**
     * Get service
     *
     * @return string
     */
    public function getService(): string
    {
        return 'jsonplaceholder';
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
        return 'posts/{postId}';
    }

    /**
     * Get scopes
     *
     * @return array
     */
    public function getScopes(): array
    {
        return [
            'posts'
        ];
    }
}
