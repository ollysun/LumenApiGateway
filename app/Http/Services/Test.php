<?php
namespace App\Http\Services;

use App\Providers\Service\Contract\Service;

/**
 * Class Test
 * @package App\Http\Services
 */
class Test implements Service
{
    /**
     * Get service key
     * 
     * @return string
     */
    public function getServiceKey() : string
    {
        return 'test';
    }

    /**
     * Get scheme
     *
     * @return string
     */
    public function getScheme(): string
    {
        return 'http';
    }

    /**
     * Get host
     *
     * @return string
     */
    public function getHost(): string
    {
        return '172.20.0.1';
    }

    /**
     * Get port
     *
     * @return int
     */
    public function getPort(): int
    {
        return 80;
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
        return 5;
    }
    
    /**
     * Get routes
     * 
     * @return array
     */
    public function getRoutes() : array
    {
        return [
            'array' => [
                'methods' => ['GET'],
                'scopes' => ['gateway']
            ],
            'array\/[0-9]+' => [
                'methods' => ['GET'],
                'scopes' => ['gateway']
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

    /**
     * Get output key
     * 
     * @return string
     */
    public function getOutputKey() : string
    {
        return 'test';
    }
}
