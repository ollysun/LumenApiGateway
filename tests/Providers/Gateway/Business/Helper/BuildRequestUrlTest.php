<?php

use App\Providers\Service\Contract\Service;
use App\Providers\Gateway\Business\Helper\BuildRequestUrl;

class BuildRequestUrlTest extends TestCase
{
    use BuildRequestUrl;

    /**
     * @test
     */
    public function it_returns_the_request_url()
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

        $result = $this->buildRequestUrl(
            $service,
            'endpoint/{test1}',
            [
                'path' => 'Path',
                'test2' => 'random'
            ],
            [
                'test1' => 123
            ]
        );

        $this->assertEquals(
            'https://host:80/endpoint/123?test2=random',
            $result
        );
    }
}
