<?php

namespace Tests;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Rockbuzz\LaraClient\Identifier;
use Rockbuzz\LaraClient\Models\Client;
use Rockbuzz\LaraClient\StrGenerate;

class IdentifierTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldUnauthorizedForLackOfKeys()
    {
        $request = new Request;

        $middleware = new Identifier();

        $response = $middleware->handle($request, function () {});

        $this->assertEquals($response->getStatusCode(), Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function itShouldUnauthorizedForInvalidKeys()
    {
        $request = new Request();
        $request->headers->add([
            'X-API-KEY' => StrGenerate::publicKey(),
            'X-API-TOKEN: ' => 'token'
        ]);

        $middleware = new Identifier();

        $response = $middleware->handle($request, function () {});

        $this->assertEquals($response->getStatusCode(), Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function itShouldNull()
    {
        $publicKey = StrGenerate::publicKey();
        $secretKey = StrGenerate::secretKey();
        $client = Client::create([
            'name' => 'Client Name',
            'public_key' => $publicKey,
            'secret_key' => $secretKey
        ]);

        $request = new Request();
        $request->headers->add([
            'X-API-KEY' => $publicKey,
            'X-API-TOKEN' => $client->token
        ]);

        $_SERVER['X-KEY-CUSTOM'] = '127.0.0.1';

        $middleware = new Identifier();

        $response = $middleware->handle($request, function () {});

        $this->assertNull($response);
    }
}
