<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class StaffAuthenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('staff.login');
    }

    protected function authenticate($request, array $guards)
    {

  
            if ($this->auth->guard('staff')->check()) {
                return $this->auth->shouldUse('staff');
            }  
            // Log::warning('Admin authentication failed. Redirecting to admin.login route.');

            $this->unauthenticated($request, ['staff']);
    }
}
