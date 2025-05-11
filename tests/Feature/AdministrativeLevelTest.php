<?php

namespace Tests\Feature;

use App\Models\AdministrativeLevel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

class AdministrativeLevelTest extends TestCase
{
    use RefreshDatabase;
    private $routePrefix = 'api/admin/administrative-levels';

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
        $response = $this->get($this->routePrefix);
        $response->assertStatus(401)->assertJson([
            'error' => [
                config('common.generic_error') => 'Unauthenticated'
            ]
        ]);
    }

    public function test_get_all_is_working(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $response = $this->actingAs($user, 'api')->get($this->routePrefix);
        $response->assertStatus(200)->assertJsonStructure(['data' => []]);

        $responseData = $response->json('data');
        $this->assertGreaterThanOrEqual(4, count($responseData), 'The data array contains less than 10 objects');
    }

    public function test_get_by_id_is_working(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $adminLevel = AdministrativeLevel::factory()->create();

        $response = $this->actingAs($user, 'api')->get($this->routePrefix . "/{$adminLevel->id}");

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'parent_id',
                'name'
            ]
        ]);
    }

    public function test_add_administrative_level(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $adminLevel = AdministrativeLevel::factory()->make();
        $adminLevelData = $adminLevel->toArray();

        $response = $this->actingAs($user, 'api')->postJson($this->routePrefix, $adminLevelData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('administrative_levels', $adminLevelData);
    }

    public function test_update_administrative_level(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $adminLevel = AdministrativeLevel::factory()->create();

        $updatedData = [
            'parent_id' => $adminLevel->parent_id,
            'name' => 'Updated Admin Level Name',
        ];

        $response = $this->actingAs($user, 'api')->putJson($this->routePrefix . "/{$adminLevel->id}", $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('administrative_levels', $updatedData);
    }


    public function test_can_not_update_parent_id_with_own_child_id(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();

        // Create a designation directly in the database
        $parent = AdministrativeLevel::factory(['parent_id' => null])->create();
        $child = AdministrativeLevel::factory(['parent_id' => $parent->id])->create();
        $recursiveChild = AdministrativeLevel::factory(['parent_id' => $child->id, 'name' => 'recursive child test'])->create();

        // Prepare updated data
        $updatedData = [
            'parent_id' => $recursiveChild->id,
            'name' => 'Updated Name',
        ];

        $response = $this->actingAs($user, 'api')->putJson($this->routePrefix . "/{$parent->id}", $updatedData);
        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'parent_id'
            ]
        ]);

        // also check update it in correct way
        $updatedData = [
            'parent_id' => $parent->parent_id,
            'name' => 'Updated Name',
        ];

        $response = $this->actingAs($user, 'api')->putJson($this->routePrefix . "/{$parent->id}", $updatedData);
        $response->assertStatus(200);
    }

    public function test_can_not_update_parent_id_with_own_id(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();

        // Create a designation directly in the database
        $parent = AdministrativeLevel::factory(['parent_id' => null])->create();

        // Prepare updated data
        $updatedData = [
            'parent_id' => $parent->id,
            'name' => 'Updated Name',
        ];

        $response = $this->actingAs($user, 'api')->putJson($this->routePrefix . "/{$parent->id}", $updatedData);
        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'parent_id'
            ]
        ]);

        // also check update it in correct way
        $updatedData = [
            'parent_id' => $parent->parent_id,
            'name' => 'Updated Name',
        ];

        $response = $this->actingAs($user, 'api')->putJson($this->routePrefix . "/{$parent->id}", $updatedData);
        $response->assertStatus(200);
    }

    public function test_delete_administrative_level(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $adminLevel = AdministrativeLevel::factory()->create();

        $response = $this->actingAs($user, 'api')->deleteJson($this->routePrefix . "/{$adminLevel->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('administrative_levels', ['id' => $adminLevel->id]);
    }
}
