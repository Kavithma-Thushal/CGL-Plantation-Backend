<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BasicApplicationTest extends TestCase
{
    private $routePrefix = 'api';

    public function test_test_route_is_working(): void
    {
        $response = $this->get($this->routePrefix.'/test');
        $response->assertStatus(200)
            ->assertSee('CGLP is working');
    }
}
