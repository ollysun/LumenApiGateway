<?php
namespace App\Providers\Gateway\Business\Helper;

use App\Providers\Gateway\Contract\ServiceContract;

/**
 * Trait BuildRequestOptions
 * @package App\Providers\Gateway\Business\Helper
 */
trait BuildRequestOptions
{
    /**
     * Build request options
     *
     * @param ServiceContract $service
     * @param array $payload
     * @param array $headers
     * @return array
     */
    public function buildRequestOptions(ServiceContract $service, array $payload, array $headers) : array
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
