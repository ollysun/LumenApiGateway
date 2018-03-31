<?php
namespace App\Http\Services;

use App\Providers\Gateway\Contract\ServiceContract;

/**
 * Class JsonPlaceholder
 * @package App\Http\Services
 */
class JsonPlaceholder implements ServiceContract
{
    /**
     * Get scheme
     *
     * @return string
     */
    public function getScheme(): string
    {
        return 'https';
    }

    /**
     * Get host
     *
     * @return string
     */
    public function getHost(): string
    {
        return 'jsonplaceholder.typicode.com';
    }

    /**
     * Get port
     *
     * @return int
     */
    public function getPort(): int
    {
        return 443;
    }

    /**
     * Get prefix
     *
     * @return null|string
     */
    public function getPrefix(): ?string
    {
        return null;
    }

    /**
     * Get timeout
     *
     * @return int
     */
    public function getTimeout(): int
    {
        return 10;
    }

    /**
     * Get http methods by route
     *
     * @return array
     */
    public function getHttpMethodsByRoute(): array
    {
        return [
            'posts' => ['GET'],
            'posts\/[0-9]+' => ['GET']
        ];
    }

    /**
     * Get scopes by route
     *
     * @return array
     */
    public function getScopesByRoute(): array
    {
        return [
            'posts' => ['posts'],
            'posts\/[0-9]+' => ['posts']
        ];
    }

    /**
     * Get headers
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return [];
    }
}
