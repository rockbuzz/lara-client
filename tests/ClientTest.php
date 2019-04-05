<?php

namespace Tests;

use Rockbuzz\LaraClient\Models\Client;
use Rockbuzz\LaraClient\Models\ClientAccess;

class ClientTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__ . '/factories');
    }

    /**
     * @test
     */
    public function itClientHasDatesCarbon()
    {
        $client = factory(Client::class)->create();

        $this->assertInstanceOf(\Carbon\Carbon::class, $client->created_at);
        $this->assertInstanceOf(\Carbon\Carbon::class, $client->updated_at);
        $this->assertInstanceOf(\Carbon\Carbon::class, $client->start_access);
        $this->assertInstanceOf(\Carbon\Carbon::class, $client->end_access);
    }

    /**
     * @test
     */
    public function aClientCanCheckIsActive()
    {
        $client = factory(Client::class)->create([
            'start_access' => now()->subDay(),
            'end_access' => now()->addDay(),
            'active' => true
        ]);
        $this->assertTrue($client->canAccess());

        $client = factory(Client::class)->create([
            'start_access' => now()->subDay(),
            'end_access' => null,
            'active' => true
        ]);
        $this->assertTrue($client->canAccess());

        $client = factory(Client::class)->create([
            'start_access' => now()->subDay(),
            'end_access' => now()->addDay(),
            'active' => false
        ]);
        $this->assertFalse($client->canAccess());

        $client = factory(Client::class)->create([
            'start_access' => now()->addDay(),
            'end_access' => now()->addDay(),
            'active' => true
        ]);
        $this->assertFalse($client->canAccess());

        $client = factory(Client::class)->create([
            'start_access' => now()->subDay(),
            'end_access' => now()->subDay(),
            'active' => true
        ]);
        $this->assertFalse($client->canAccess());

        $client = factory(Client::class)->create([
            'start_access' => now()->subDay(),
            'end_access' => now()->addDay(),
            'active' => true,
            'limit_access' => 100
        ]);

        factory(ClientAccess::class, 100)->create([
            'client_id' => $client->id
        ]);
        $this->assertTrue($client->canAccess());

        factory(ClientAccess::class)->create([
            'client_id' => $client->id
        ]);
        $this->assertFalse($client->canAccess());
    }
}
