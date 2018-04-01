<?php
namespace App\Providers\Gateway\Model;

class Route
{
    /** @var array */
    private $methods;

    /** @var array */
    private $scopes;

    public function __construct(array $methods, array $scopes)
    {
        $this->methods = $methods;
        $this->scopes = $scopes;
    }

    public function getMethods()
    {
        return $this->methods;
    }
    
    public function getScopes()
    {
        return $this->scopes;
    }
}
