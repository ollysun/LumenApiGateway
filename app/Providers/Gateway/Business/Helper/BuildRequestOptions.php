<?php
namespace App\Providers\Gateway\Business\Helper;

use App\Providers\Service\Contract\Service;

/**
 * Trait BuildRequestOptions
 * @package App\Providers\Gateway\Business\Helper
 */
trait BuildRequestOptions
{
    /**
     * Build request options
     *
     * @param Service $service
     * @param array $payload
     * @param array $headers
     * @return array
     */
    public function buildRequestOptions(Service $service, array $payload, array $headers) : array
    {
        $optionHeaders = [
            'expect' => ''
        ];

        foreach ($service->getHeaders() as $headerKey) {
            $headerKey = strtolower($headerKey);
            if (array_has($headers, $headerKey)) {
                $optionHeaders[$headerKey] = $headers[$headerKey][0];
            }
        }

        $options = [
            'headers' => $optionHeaders,
            'timeout' => $service->getTimeout(),
            'http_errors' => false
        ];

        if (!empty($payload)) {
            $options['json'] = $payload;
        }

        return $options;
    }
}
