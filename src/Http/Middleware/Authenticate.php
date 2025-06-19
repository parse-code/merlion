<?php

namespace Merlion\Http\Middleware;

use Illuminate\Http\Request;

class Authenticate extends \Illuminate\Auth\Middleware\Authenticate
{
    protected function authenticate($request, array $guards): void
    {
        $guard = panel()->getGuard();
        if ($this->auth->guard($guard)->check()) {
            $this->auth->shouldUse($guard);
            if (!panel()->canAccess($this->auth->user())) {
                $this->auth->logout();
            } else {
                return;
            }
        }
        $this->unauthenticated($request, [$guard]);
    }

    public function redirectTo(Request $request)
    {
        return panel()->getLoginUrl();
    }
}
