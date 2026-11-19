<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Session\Middleware\AuthenticateSession;

class AuthenticateContentSession extends AuthenticateSession
{
    protected function redirectTo(Request $request)
    {
        return route('admin.login');
    }
}
