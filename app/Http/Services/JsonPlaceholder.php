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
     * Get routes
     * 
     * @return array
     */
    public function getRoutes() : array
    {
        return [
            'posts' => [
                'methods' => ['GET'],
                'scopes' => ['posts']
            ],
            'posts\/[0-9]+' => [
                'methods' => ['GET'],
                'scopes' => ['posts']
            ]
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
