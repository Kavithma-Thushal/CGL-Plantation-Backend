<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

class MasterDataTest extends TestCase
{
    use RefreshDatabase;

    private $routePrefix = 'api/admin/master-data';

    protected function setUp(): void
    {
        parent::setUp();

        $clientRepository = new ClientRepository();
        $clientRepository->createPersonalAccessClient(
            null,
            'Test Personal Access Client',
            'http://localhost'
        );

        Artisan::call('db:seed');
    }

    public function test_block_unauthenticated_accesses(): void
    {
        $routes = [
            '/titles',
            '/banks',
            '/branches',
            '/roles',
            '/races',
            '/nationalities',
            '/occupations',
            '/countries',
            '/tree-brands',
        ];

        foreach ($routes as $route) {
            $response = $this->get($this->routePrefix . $route);
            $response->assertStatus(401)->assertJson([
                'error' => [
                    config('common.generic_error') => 'Unauthenticated'
                ]
            ]);
        }
    }

    public function test_get_titles(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $response = $this->actingAs($user, 'api')->get($this->routePrefix . '/titles');
        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
    }

    public function test_get_banks(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $response = $this->actingAs($user, 'api')->get($this->routePrefix . '/banks');
        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
    }

    public function test_get_branches(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $response = $this->actingAs($user, 'api')->get($this->routePrefix . '/branches');
        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
    }

    public function test_get_roles(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $response = $this->actingAs($user, 'api')->get($this->routePrefix . '/roles');
        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
    }

    public function test_get_races(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $response = $this->actingAs($user, 'api')->get($this->routePrefix . '/races');
        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
    }

    public function test_get_nationalities(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $response = $this->actingAs($user, 'api')->get($this->routePrefix . '/nationalities');
        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
    }

    public function test_get_occupations(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $response = $this->actingAs($user, 'api')->get($this->routePrefix . '/occupations');
        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
    }

    public function test_get_countries(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $response = $this->actingAs($user, 'api')->get($this->routePrefix . '/countries');
        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
    }

    public function test_get_tree_brands(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $response = $this->actingAs($user, 'api')->get($this->routePrefix . '/tree-brands');
        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
    }
}
