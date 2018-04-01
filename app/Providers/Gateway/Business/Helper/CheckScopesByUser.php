<?php
namespace App\Providers\Gateway\Business\Helper;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Laravel\Passport\Exceptions\MissingScopeException;
use App\Providers\Gateway\Model\Route;

/**
 * Trait CheckScopesByUser
 * @package App\Providers\Gateway\Business\Helper
 */
trait CheckScopesByUser
{
    /**
     * Check scopes by user
     *
     * @param Route $route
     * @throws AuthenticationException
     * @throws MissingScopeException
     * @throws \Exception
     */
    public function checkScopesByUser(Route $route)
    {
        if (empty($route->getScopes())) {
            throw new \Exception("There are no scopes defined");
        }

        $user = Auth::user();
        if (!$user || !Auth::user()->token()) {
            throw new AuthenticationException();
        }

        foreach ($route->getScopes() as $scope) {
            if (!$user->tokenCan($scope)) {
                throw new MissingScopeException($scope);
            }
        }
    }
}
