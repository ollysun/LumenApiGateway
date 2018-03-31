<?php

use App\Providers\Gateway\Contract\ServiceContract;
use App\Providers\Gateway\Business\Helper\CheckHttpMethod;

class CheckHttpMethodTest extends TestCase
{
    use CheckHttpMethod;
    
    /**
     * @test
     * @expectedException \App\Providers\Gateway\Exception\InvalidHttpMethodByRoute
     */
    public function it_throws_an_exception_if_http_method_check_fail()
    {
        $this->checkHttpMethod('GET', ['POST']);
    }
}
