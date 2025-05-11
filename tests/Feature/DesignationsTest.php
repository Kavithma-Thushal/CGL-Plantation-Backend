<?php

namespace Tests\Feature;

use App\Models\Designation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

class DesignationsTest extends TestCase
{
    use RefreshDatabase;
    private $routePrefix = 'api/admin';

    // setup method runs when starting of every single test in this class
    protected function setUp(): void
    {
        parent::setUp();

        // Create a personal access client for testing
        $clientRepository = new ClientRepository();
        $clientRepository->createPersonalAccessClient(
            null,
            'Test Personal Access Client',
            'http://localhost'
        );

        // Run the database seeders
        Artisan::call('db:seed');
    }

    public function test_block_unauthenticated_accesses(): void
    {
        $response = $this->get($this->routePrefix . '/designations');
        $response->assertStatus(401)->assertJson([
            'error' => [
                config('common.generic_error') => 'Unauthenticated'
            ]
        ]);
    }

    public function test_get_all_is_working(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first(); // Retrieve the user created by the seeder
        $response = $this->actingAs($user, 'api')->get($this->routePrefix . '/designations');
        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
        // Get the JSON response data
        $responseData = $response->json('data');

        // Assert that there are at least 10 objects in the data array
        $this->assertGreaterThanOrEqual(10, count($responseData), 'The data array contains less than 10 objects');
    }

    public function test_tree_is_working(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first(); // Retrieve the user created by the seeder
        $response = $this->actingAs($user, 'api')->get($this->routePrefix . '/designations/tree');
        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
        // Get the JSON response data
        $responseData = $response->json('data');

        // Assert that there are at least 1 objects in the data array
        $this->assertGreaterThanOrEqual(1, count($responseData), 'The data array contains less than 10 objects');
    }

    public function test_add_designation_without_parent(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first(); // Retrieve the user created by the seeder

        // Arrange
        // Generate a new Designation instance using the factory
        $designation = Designation::factory(['parent_id' => null])->make();
        $designationData = $designation->toArray();

        // Act
        $response = $this->actingAs($user, 'api')->postJson($this->routePrefix . '/designations', $designationData);

        // Assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('designations', $designationData);
    }

    public function test_add_designation_with_parent(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first(); // Retrieve the user created by the seeder

        // Arrange
        // Generate a new Designation instance using the factory
        $designation = Designation::factory(['parent_id' => null])->make();
        $designationData = $designation->toArray();

        // Act
        $response = $this->actingAs($user, 'api')->postJson($this->routePrefix . '/designations', $designationData);

        $childDesignation = Designation::factory(['parent_id' => $designation->id])->make();
        $childDesignation = $childDesignation->toArray();

        // Act
        $childResponse = $this->actingAs($user, 'api')->postJson($this->routePrefix . '/designations', $childDesignation);

        // Assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('designations', $designationData);

        $childResponse->assertStatus(200);
        $this->assertDatabaseHas('designations', $childDesignation);
    }

    public function test_get_by_id_is_working(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();

        // Create a designation directly in the database
        $designation = Designation::factory(['parent_id' => null])->create();

        $response = $this->actingAs($user, 'api')->get($this->routePrefix . "/designations/{$designation->id}");

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'parent_id',
                'name',
                'orc',
                'code',
            ]
        ]);
    }

    public function test_update_designation(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();

        // Create a designation directly in the database
        $designation = Designation::factory(['parent_id' => null])->create();

        // Prepare updated data
        $updatedData = [
            'parent_id' => $designation->parent_id,
            'name' => 'Updated Designation Name',
            'orc' => $designation->orc,
            'code' => 'UPDATED_CODE',
        ];

        $response = $this->actingAs($user, 'api')->putJson($this->routePrefix . "/designations/{$designation->id}", $updatedData);

        $response->assertStatus(200); // Assuming 200 OK for successful update
        $this->assertDatabaseHas('designations', $updatedData);
    }

    public function test_can_not_update_parent_id_with_own_child_id(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();

        // Create a designation directly in the database
        $designation = Designation::factory(['parent_id' => null])->create();
        $childDesignation = Designation::factory(['parent_id' => $designation->id])->create();
        $recursiveChild = Designation::factory(['parent_id' => $childDesignation->id, 'name' => 'recursive child test'])->create();

        // Prepare updated data
        $updatedData = [
            'parent_id' => $recursiveChild->id,
            'name' => 'Updated Designation Name',
            'orc' => $designation->orc,
            'code' => 'UPDATED_CODE',
        ];

        $response = $this->actingAs($user, 'api')->putJson($this->routePrefix . "/designations/{$designation->id}", $updatedData);
        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'parent_id'
            ]
        ]);

        // also check update it in correct way
        $updatedData = [
            'parent_id' => $designation->parent_id,
            'name' => 'Updated Designation Name',
            'orc' => $designation->orc,
            'code' => 'UPDATED_CODE',
        ];

        $response = $this->actingAs($user, 'api')->putJson($this->routePrefix . "/designations/{$designation->id}", $updatedData);
        $response->assertStatus(200);
    }

    public function test_can_not_update_parent_id_with_own_id(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();

        // Create a designation directly in the database
        $designation = Designation::factory(['parent_id' => null])->create();

        // Prepare updated data
        $updatedData = [
            'parent_id' => $designation->id,
            'name' => 'Updated Designation Name',
            'orc' => $designation->orc,
            'code' => 'UPDATED_CODE',
        ];

        $response = $this->actingAs($user, 'api')->putJson($this->routePrefix . "/designations/{$designation->id}", $updatedData);
        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'parent_id'
            ]
        ]);

        // also check update it in correct way
        $updatedData = [
            'parent_id' => $designation->parent_id,
            'name' => 'Updated Designation Name',
            'orc' => $designation->orc,
            'code' => 'UPDATED_CODE',
        ];

        $response = $this->actingAs($user, 'api')->putJson($this->routePrefix . "/designations/{$designation->id}", $updatedData);
        $response->assertStatus(200);
    }


    public function test_can_not_delete_designation_with_children(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();

        $parent = Designation::factory(['parent_id' => null])->create();
        Designation::factory(['parent_id' => 1])->create();
        $secondChild = Designation::factory(['parent_id' => $parent->id])->create();
        Designation::factory(['parent_id' => $secondChild->id])->create();

        $designations = Designation::whereHas('children')->get();

        foreach ($designations as $designation) {
            $response = $this->actingAs($user, 'api')->deleteJson($this->routePrefix . "/designations/{$designation->id}");
            $response->assertStatus(422);
            $this->assertDatabaseHas('designations', ['id' => $designation->id]);
        }
    }

    public function test_can_delete_designation_without_children(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();

        $parent = Designation::factory(['parent_id' => null])->create();
        Designation::factory(['parent_id' => 1])->create();
        $secondChild = Designation::factory(['parent_id' => $parent->id])->create();
        Designation::factory(['parent_id' => $secondChild->id])->create();

        $designations = Designation::whereDoesntHave('children')->get();

        foreach ($designations as $designation) {
            $response = $this->actingAs($user, 'api')->deleteJson($this->routePrefix . "/designations/{$designation->id}");
            $response->assertStatus(200);
            $this->assertDatabaseMissing('designations', ['id' => $designation->id]);
        }
    }
}
