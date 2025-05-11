<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class LoginTest extends TestCase
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

    public function test_can_login_with_valid_credentials()
    {
        // Arrange
        $loginData = [
            'username' => config('common.first_user_username'),
            'password' => config('common.first_user_password')
        ];

        // Act
        $response = $this->postJson($this->routePrefix.'/login', $loginData);

        // Assert
        $response->assertStatus(200);

        // Check that access_token is not null
        $responseData = $response->json('data');
        $this->assertNotNull($responseData['access_token']);
    }

    public function test_cant_login_with_invalid_username()
    {
        // Arrange
        $loginData = [
            'username' => 'invalid',
            'password' => config('common.first_user_password')
        ];

        // Act
        $response = $this->postJson($this->routePrefix.'/login', $loginData);

        // Assert
        $response->assertStatus(422)->assertJsonStructure([
            'error'=>[
                config('common.generic_error')
            ]
        ]);
    }

    public function test_cant_login_with_invalid_password()
    {
        // Arrange
        $loginData = [
            'username' => config('common.first_user_username'),
            'password' => 'invalid'
        ];

        // Act
        $response = $this->postJson($this->routePrefix.'/login', $loginData);

        // Assert
        $response->assertStatus(422)->assertJsonStructure([
            'error'=>[
                config('common.generic_error')
            ]
        ]);
    }

    public function test_cant_login_with_empty_credentials()
    {
        // Arrange
        $loginData = [
            'username' => "",
            'password' => "",
        ];

        // Act
        $response = $this->postJson($this->routePrefix.'/login', $loginData);

        // Assert
        $response->assertStatus(422)->assertJsonStructure([
            'error'=>[
                'username',
                'password'
            ]
        ]);
    }
   
    public function test_cant_login_with_empty_password()
    {
        // Arrange
        $loginData = [
            'username' => config('common.first_user_username'),
            'password' => "",
        ];

        // Act
        $response = $this->postJson($this->routePrefix.'/login', $loginData);

        // Assert
        $response->assertStatus(422)->assertJsonStructure([
            'error'=>[
                'password'
            ]
        ]);
    }

    public function test_cant_login_with_empty_username()
    {
        // Arrange
        $loginData = [
            'username' => "",
            'password' => config('common.first_user_password')
        ];

        // Act
        $response = $this->postJson($this->routePrefix.'/login', $loginData);

        // Assert
        $response->assertStatus(422)->assertJsonStructure([
            'error'=>[
                'username'
            ]
        ]);
    }
}
