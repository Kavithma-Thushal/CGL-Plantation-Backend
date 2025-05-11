<?php

namespace Tests\Feature;

use App\Models\PlanTemplate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

class PlanTemplateTest extends TestCase
{
    use RefreshDatabase;

    private $routePrefix = 'api/admin/plan-templates';

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
        $planTemplate = PlanTemplate::factory()->create();

        $response = $this->actingAs($user, 'api')->get($this->routePrefix . "/{$planTemplate->id}");

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'type',
                'does_return_capital',
                'does_return_profit',
                'does_return_benefit'
            ]
        ]);
    }
}
