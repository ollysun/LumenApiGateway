<?php
namespace App\Providers\Gateway\Business\Helper;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Laravel\Passport\Exceptions\MissingScopeException;

/**
 * Trait CheckScopesByUser
 * @package App\Providers\Gateway\Business\Helper
 */
trait CheckScopesByUser
{
    /**
     * Check scopes by user
     *
     * @param array $scopes
     * @throws AuthenticationException
     * @throws MissingScopeException
     */
    public function checkScopesByUser(array $scopes)
    {
        $user = Auth::user();
        if (!$user || !Auth::user()->token()) {
            throw new AuthenticationException();
        }

        foreach ($scopes as $scope) {
            if (!$user->tokenCan($scope)) {
                throw new MissingScopeException($scope);
            }
        }
    }
}
