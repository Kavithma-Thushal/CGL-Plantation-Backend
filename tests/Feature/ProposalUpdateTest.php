<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use App\Trait\Testing\ProposalTestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProposalUpdateTest extends TestCase
{
    use ProposalTestTrait;
    use RefreshDatabase;

    private $routePrefix = 'api/admin/user-packages';

    // Setup method runs before every test in this class
    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate:custom');
    }

    public function test_can_update_user_package_with_valid_data()
    {
        // Arrange
        $data = $this->getPackageData();
        $package = $this->addPackage($data);
        $updateData = $this->getPackageData();

        // Act
        $user = User::first();
        $response = $this->actingAs($user, 'api')->putJson($this->routePrefix . "/{$package->id}", $updateData);

        // Assert
        $response->assertStatus(200); // Assuming 200 Created is returned
    }
}
