<?php

namespace App\Http\Middleware;
use PragmaRX\Google2FALaravel\Support\Authenticator;

use App\Support\Google2FAAuthenticator;
use Closure;

class LoginSecurityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authenticator = app(Google2FAAuthenticator::class)->boot($request);
        // dd("ld");
        // $authenticator = app(Authenticator::class)->bootStateless($request);
        if ($authenticator->isAuthenticated()) {
            return $next($request);
        }

        return $authenticator->makeRequestOneTimePasswordResponse();
    }
}
