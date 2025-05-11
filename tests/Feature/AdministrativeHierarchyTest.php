<?php

namespace Tests\Feature;

use App\Models\AdministrativeHierarchy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

class AdministrativeHierarchyTest extends TestCase
{
    use RefreshDatabase;

    private $routePrefix = 'api/admin/administrative-hierarchies';

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
        $this->assertGreaterThanOrEqual(4, count($responseData), 'The data array contains less than 4 objects');
    }

    public function test_get_by_id_is_working(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $adminHierarchy = AdministrativeHierarchy::factory()->create();

        $response = $this->actingAs($user, 'api')->get($this->routePrefix . "/{$adminHierarchy->id}");

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'administrative_level_id',
                'parent_id',
                'name'
            ]
        ]);
    }

    public function test_add_administrative_hierarchy(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $adminHierarchy = AdministrativeHierarchy::factory()->make();
        $adminHierarchyData = $adminHierarchy->toArray();

        $response = $this->actingAs($user, 'api')->postJson($this->routePrefix, $adminHierarchyData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('administrative_hierarchies', $adminHierarchyData);
    }

    public function test_update_administrative_hierarchy(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $adminHierarchy = AdministrativeHierarchy::factory()->create();

        $updatedData = [
            'parent_id' => $adminHierarchy->parent_id,
            'administrative_level_id'=>$adminHierarchy->administrative_level_id,
            'name' => 'Updated Hierarchy Name',
        ];

        $response = $this->actingAs($user, 'api')->putJson($this->routePrefix . "/{$adminHierarchy->id}", $updatedData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('administrative_hierarchies', $updatedData);
    }

    public function test_can_not_update_parent_id_with_own_child_id(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();

        // Create hierarchy directly in the database
        $parent = AdministrativeHierarchy::factory(['parent_id' => null])->create();
        $child = AdministrativeHierarchy::factory(['parent_id' => $parent->id])->create();
        $recursiveChild = AdministrativeHierarchy::factory(['parent_id' => $child->id, 'name' => 'recursive child test'])->create();

        // Prepare updated data
        $updatedData = [
            'parent_id' => $recursiveChild->id,
            'administrative_level_id'=>$parent->administrative_level_id,
            'name' => 'Updated Name',
        ];

        $response = $this->actingAs($user, 'api')->putJson($this->routePrefix . "/{$parent->id}", $updatedData);
        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'parent_id'
            ]
        ]);

        // also check update in the correct way
        $updatedData = [
            'parent_id' => $parent->parent_id,
            'administrative_level_id'=>$parent->administrative_level_id,
            'name' => 'Updated Name',
        ];

        $response = $this->actingAs($user, 'api')->putJson($this->routePrefix . "/{$parent->id}", $updatedData);
        $response->assertStatus(200);
    }

    public function test_can_not_update_parent_id_with_own_id(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();

        // Create hierarchy directly in the database
        $parent = AdministrativeHierarchy::factory(['parent_id' => null])->create();

        // Prepare updated data
        $updatedData = [
            'parent_id' => $parent->id,
            'administrative_level_id'=>$parent->administrative_level_id,
            'name' => 'Updated Name',
        ];

        $response = $this->actingAs($user, 'api')->putJson($this->routePrefix . "/{$parent->id}", $updatedData);
        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'parent_id'
            ]
        ]);

        // also check update in the correct way
        $updatedData = [
            'parent_id' => $parent->parent_id,
            'administrative_level_id'=>$parent->administrative_level_id,
            'name' => 'Updated Name',
        ];

        $response = $this->actingAs($user, 'api')->putJson($this->routePrefix . "/{$parent->id}", $updatedData);
        $response->assertStatus(200);
    }

    public function test_delete_administrative_hierarchy(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $adminHierarchy = AdministrativeHierarchy::factory()->create();

        $response = $this->actingAs($user, 'api')->deleteJson($this->routePrefix . "/{$adminHierarchy->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('administrative_hierarchies', ['id' => $adminHierarchy->id]);
    }
}
