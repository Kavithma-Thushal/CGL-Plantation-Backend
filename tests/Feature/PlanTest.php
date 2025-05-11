<?php

namespace Tests\Feature;

use App\Models\Plan;
use App\Models\PlanTemplate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;



class PlanTest extends TestCase
{
    use RefreshDatabase;

    private $routePrefix = 'api/admin/plans';

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
        Plan::factory(4)->create();
        $user = User::where('username', config('common.first_user_username'))->first();

        $response = $this->actingAs($user, 'api')->get($this->routePrefix);
        $response->assertStatus(200)->assertJsonStructure(['data' => []]);

        $responseData = $response->json('data');
        $this->assertGreaterThanOrEqual(4, count($responseData), 'The data array contains less than 4 objects');
    }

    public function test_get_by_id_is_working(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $plan = Plan::factory()->create();

        $response = $this->actingAs($user, 'api')->get($this->routePrefix . "/{$plan->id}");

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'plan_template_id',
                'name',
                'code',
                'duration',
                'minimum_amount',
                'profit_per_month',
                'benefit_per_month',
                'description'
            ]
        ]);
    }

    public function test_add_plan(): void
    {
       $response = $this->createPlan();
        $response->assertStatus(200);
        $this->assertDatabaseHas('plans', ['id'=>$response['data']['id']]);
    }

    private function createPlan(){
        $user = User::where('username', config('common.first_user_username'))->first();
        $planTemplate = PlanTemplate::factory()->create();
        $planData = [
            'plan_template_id' => $planTemplate->id,
            'duration' => 1,
            'name' => 'Swift',
            'description' => 'This is description',
            'minimum_amount' => 100,
            'benefit_per_month' => 20,
            'profit_per_month' => 100,
            'interest_rates' => [
                [
                    'year' => 1,
                    'rate' => 10,
                ],
                [
                    'year' => 2,
                    'rate' => 2,
                ],
                [
                    'year' => 3,
                    'rate' => 15,
                ],
            ],
        ];

        return $this->actingAs($user, 'api')->postJson($this->routePrefix, $planData);
    }

    public function test_update_plan(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $planResponse = $this->createPlan();
        $plan = Plan::find($planResponse['data']['id']);
        $updatedData = [
            'name' => 'Updated Plan Name',
            'minimum_amount' => $plan->minimum_amount,
            'description' => 'Updated description',
        ];

        $response = $this->actingAs($user, 'api')->putJson($this->routePrefix . "/{$plan->id}", $updatedData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('plans', ['id'=>$plan['id']]);
    }

    public function test_delete_plan(): void
    {
        $user = User::where('username', config('common.first_user_username'))->first();
        $plan = Plan::factory()->create();

        $response = $this->actingAs($user, 'api')->deleteJson($this->routePrefix . "/{$plan->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('plans', ['id' => $plan->id]);
    }
}
