<?php

use App\Providers\Gateway\Contract\ServiceContract;
use App\Providers\Gateway\Business\Helper\SearchRouteByEndpoint;
use App\Providers\Gateway\Model\Route;

class SearchRouteByEndpointTest extends TestCase
{
    use SearchRouteByEndpoint;
    
    /**
     * @test
     */
    public function it_returns_the_found_route()
    {
        $route = new Route(
            [
                'GET'
            ],
            [
                'test'
            ]
        );

        $this->assertEquals(
            $route,
            $this->searchRouteByEndpoint(
                'test/123',
                [
                    'test' => [
                        'methods' => ['GET'],
                        'scopes' => ['test']
                    ],
                    'test\/[0-9]+' => [
                        'methods' => ['GET'],
                        'scopes' => ['test']
                    ]
                ]
            )
        );
    }
}
