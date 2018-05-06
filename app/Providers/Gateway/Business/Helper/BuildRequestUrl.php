<?php
namespace App\Providers\Gateway\Business\Helper;

use App\Providers\Service\Contract\Service;

/**
 * Trait BuildRequestUrl
 * @package App\Providers\Gateway\Business\Helper
 */
trait BuildRequestUrl
{
    /**
     * Build request url
     *
     * @param Service $service
     * @param string $endpoint
     * @param array $queryParams
     * @param array $urlParams
     * @return string
     */
    public function buildRequestUrl(
        Service $service,
        string $endpoint,
        array $queryParams = [],
        array $urlParams = []
    ) : string {
        $url = '';

        // Scheme
        if (in_array(strtolower($service->getScheme()), ['http', 'https'])) {
            $url .= sprintf("%s://", $service->getScheme());
        }

        // Host
        $url .= $service->getHost();

        // Port
        $url .= sprintf(":%s", $service->getPort());

        // Endpoint
        if (substr($url, -1) != '/') {
            $url .= '/';
        }
        $url .= $endpoint;

        // Url-Params
        if (preg_match_all('/{(?<urlParam>[a-zA-Z0-9]+)}/', $url, $matches)) {
            foreach ($matches['urlParam'] as $urlParam) {
                if (array_key_exists($urlParam, $urlParams)) {
                    $url = str_replace(
                        sprintf("{%s}", $urlParam),
                        $urlParams[$urlParam],
                        $url
                    );
                }
            }
        }

        // Query
        if (array_key_exists('path', $queryParams)) {
            unset($queryParams['path']);
        }

        if (!empty($queryParams)) {
            $query = [];

            foreach ($queryParams as $key => $value) {
                $query[] = sprintf("%s=%s", $key, $value);
            }

            $url .= '?' . implode('&', $query);
        }

        return $url;
    }
}
