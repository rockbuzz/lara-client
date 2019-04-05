<?php

namespace Rockbuzz\LaraClient;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Rockbuzz\LaraClient\Models\Client;

class Identifier
{
    public function handle(Request $request, \Closure $next)
    {
        if (
            ! $publicKey = $request->header('X-API-KEY') OR
            ! $apiToken = $request->header('X-API-TOKEN')
        ) {
            return $this->responseUnauthorized();
        }

        if (! $client = Client::where('public_key', $publicKey)->first()) {
            return $this->responseUnauthorized();
        }
        if ($apiToken !== hash_hmac('sha256', $publicKey, $client->secret_key)) {
            return $this->responseUnauthorized();
        }

        if (! $client->canAccess()) {
            return $this->responseUnauthorized();
        }

        $client->accesses()->create([
            'ip' => $this->getClientIp($request),
            'host' => $request->getHost(),
        ]);

        return $next($request);
    }

    private function getClientIp($request)
    {
        if (isset($_SERVER[config('client.server_key_client_ip')])) {
            return $_SERVER[config('client.server_key_client_ip')];
        }
        return $request->getClientIp();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    private function responseUnauthorized(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'errors' => [
                'code'   => Response::HTTP_UNAUTHORIZED,
                'detail' => 'Unauthorized'
            ]
        ], Response::HTTP_UNAUTHORIZED);
    }
}
