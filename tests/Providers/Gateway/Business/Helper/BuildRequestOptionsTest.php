<?php

use App\Providers\Gateway\Business\Helper\BuildRequestOptions;
use App\Providers\Gateway\Contract\ServiceContract;

class BuildRequestOptionsTest extends TestCase
{
    use BuildRequestOptions;

    /**
     * @test
     */
    public function it_returns_the_request_options()
    {
        $service = new class () implements ServiceContract {
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

            public function getHttpMethodsByRoute() : array
            {
                return [];
            }

            public function getScopesByRoute() : array
            {
                return [];
            }
            
            public function getHeaders() : array
            {
                return [
                    'Accept'
                ];
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
