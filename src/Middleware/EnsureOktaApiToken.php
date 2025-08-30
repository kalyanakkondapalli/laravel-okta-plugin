<?php

namespace KalyanaKrishnaKondapalli\LaravelOkta\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use KalyanaKrishnaKondapalli\LaravelOkta\Services\OktaClient;

class EnsureOktaApiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $auth = $request->bearerToken();
        if (!$auth) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $claims = app(OktaClient::class)->validateIdToken($auth);
            $request->attributes->set('okta_claims', $claims);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        return $next($request);
    }
}
