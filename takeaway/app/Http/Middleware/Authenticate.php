<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    private function redirectToShop($request) {
        if (! $request->expectsJson()) {
            return route('admin.login');
        }
    }

    private function redirectToSite($request) {
        if (! $request->expectsJson()) {
            return route('manage.login');
        }
    }

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        if (in_array('admin', $guards)) {
            throw new AuthenticationException(
                'Unauthenticated.', $guards, $this->redirectToShop($request)
            );
        } elseif (in_array('manage', $guards)) {
            throw new AuthenticationException(
                'Unauthenticated.', $guards, $this->redirectToSite($request)
            );
        } else {
            throw new AuthenticationException(
                'Unauthenticated.', $guards, $this->redirectTo($request)
            );
        }
    }
}
