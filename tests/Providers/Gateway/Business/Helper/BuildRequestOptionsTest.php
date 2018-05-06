<?php

use App\Providers\Gateway\Business\Helper\BuildRequestOptions;
use App\Providers\Service\Contract\Service;

class BuildRequestOptionsTest extends TestCase
{
    use BuildRequestOptions;

    /**
     * @test
     */
    public function it_returns_the_request_options()
    {
        $service = new class () implements Service {
            public function getServiceKey() : string
            {
                return 'serviceKey';
            }
            
            public function getScheme() : string
            {
                return 'https';
            }

            public function getHost() : string
            {
                return 'host';
            }
            
            public function getPort() : int
            {
                return 80;
            }

            public function getPrefix() : ?string
            {
                return null;
            }

            public function getTimeout() : int
            {
                return 10;
            }

            public function getRoutes() : array
            {
                return [];
            }
            
            public function getHeaders() : array
            {
                return [
                    'Accept'
                ];
            }

            public function getOutputKey() : string
            {
                return 'outputKey';
            }
        };

        $result = $this->buildRequestOptions($service, [
            'key' => 'value'
        ], [
            'accept' => [
                'application/json'
            ]
        ]);

        $this->assertEquals(
            [
                'headers' => [
                    'expect' => '',
                    'accept' => 'application/json'
                ],
                'timeout' => 10,
                'http_errors' => false,
                'json' => [
                    'key' => 'value'
                ]
            ],
            $result
        );
    }
}
