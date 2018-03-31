<?php

use App\Providers\Gateway\Contract\ServiceContract;
use App\Providers\Gateway\Business\Helper\SearchRouteKeyByEndpoint;

class SearchRouteKeyByEndpointTest extends TestCase
{
    use SearchRouteKeyByEndpoint;
    
    /**
     * @test
     */
    public function it_returns_the_find_route_key()
    {
        $this->assertEquals(
            'test\/[0-9]+',
            $this->searchRouteKeyByEndpoint(
                'test/123',
                [
                    'test',
                    'test\/[0-9]+'
                ]
            )
        );

        // Cache
        $this->assertEquals(
            'test\/[0-9]+',
            $this->searchRouteKeyByEndpoint(
                'test',
                [
                    'test',
                    'test\/[0-9]+'
                ]
            )
        );
    }
}
