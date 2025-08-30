<?php

namespace KalyanaKrishnaKondapalli\LaravelOkta\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\JWK;
use Illuminate\Support\Facades\Http;

class OktaClient
{
    public function validateIdToken(string $token)
    {
        $issuer = config('okta.base_url') . '/oauth2/default';
        $jwksUri = $issuer . '/v1/keys';

        $jwks = cache()->remember('okta_jwks', 3600, function () use ($jwksUri) {
            return Http::get($jwksUri)->json();
        });

        $decoded = JWT::decode($token, JWK::parseKeySet($jwks));

        if ($decoded->iss !== $issuer) {
            throw new \Exception('Invalid issuer');
        }

        return (array) $decoded;
    }
}
