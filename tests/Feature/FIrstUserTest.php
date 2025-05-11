<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class FIrstUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Set up the first user using the existing seeder.
     */
    private function seedFirstUser(): void
    {
        // Run the specific seeder
        Artisan::call('db:seed');
    }

    /**
     * Test if the auth route is working.
     */
    public function test_auth_test_route_is_working(): void
    {
        $this->seedFirstUser(); // Seed the first user

        $user = User::where('username', config('common.first_user_username'))->first(); // Retrieve the user created by the seeder

        $response = $this->actingAs($user, 'api')->get('/api/test/auth-user');

        $response->assertStatus(200);
    }
}
