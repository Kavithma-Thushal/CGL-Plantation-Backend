<?php

namespace Tests\Feature;

use App\Models\Bank;
use App\Models\Employee;
use App\Models\Title;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    private $routePrefix = 'api/admin/employees';

    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('db:seed');

        $clientRepository = new ClientRepository();
        $clientRepository->createPersonalAccessClient(
            null,
            'Test Personal Access Client',
            'http://localhost'
        );
    }

    public function test_block_unauthenticated_accesses(): void
    {
        $routes = [
            'get' => [
                '/by-nic/123456789V',
                '/1',
                ''
            ],
            'post' => [''],
            'put' => ['/1'],
            'delete' => ['/1']
        ];

        foreach ($routes as $method => $paths) {
            foreach ($paths as $path) {
                $response = $this->$method($this->routePrefix . $path);
                $response->assertStatus(401)->assertJson([
                    'error' => [
                        config('common.generic_error') => 'Unauthenticated'
                    ]
                ]);
            }
        }
    }

    private function addEmployee()
    {
        $user = User::factory()->create();
        $employeeData  =  $this->getEmployeeData();
        $response = $this->actingAs($user, 'api')->post($this->routePrefix, $employeeData);
        return Employee::find($response['data']['id']);
    }

    private function getEmployeeData(array $overrides = []): array
    {
        return array_merge([
            "title_id" => Title::factory()->create()->id,
            "name_with_initials" => "B.A.M.H.P.bandara",
            "first_name" => "Harshadeva",
            "middle_name" => "Priyankara",
            "last_name" => "Bandara",
            "family_name" => "Bopegedara Athauda",
            "media_id" => null,
            "epf_number" => "B1AM1654",
            "commenced_date" => "2024/06/01",
            "mobile_number" => "0717233539",
            "nic" => "950134018V",
            "dob" => "1994/01/01",
            "has_system_access" => 1,
            "bank_id" => Bank::factory()->create()->id,
            "branch" => "Piliyandala",
            "address" => "No 32/ buddaloka mawatha, suwarapola ,piliyandala",
            "account_number" => "1232342342",
            "base_branch_id" => 1,
            "designation_id" => 1,
            "reporting_person_id" => null,
            "letter_date" => "2024/05/26",
            "operating_branches" => [
                [
                    "branch_id" => 1
                ]
            ],
            "username" => "Harsha",
            "password" => "Harshda@1243",
            "user_role_id" => 1
        ], $overrides);
    }

    // public function test_get_employee_by_nic(): void
    // {
    //     $user = User::factory()->create();
    //     $employee = $this->addEmployee();
    //     $response = $this->actingAs($user, 'api')->get($this->routePrefix . '/by-nic/' . $employee->getPersonalDetail()->nic);
    //     Log::info($response->json());
    //     $response->assertStatus(200)->assertJsonStructure(['data' => []]);
    // }



    // public function test_delete_employee(): void
    // {
    //     $user = User::factory()->create();
    //     $employee = $this->addEmployee();

    //     $response = $this->actingAs($user, 'api')->delete($this->routePrefix . '/' . $employee->id);

    //     $response->assertStatus(200);
    //     $this->assertDatabaseMissing('employees', ['id' => $employee->id]);
    // }

    public function test_get_employee_by_id(): void
    {
        $user = User::factory()->create();
        $employee = $this->addEmployee();
        $response = $this->actingAs($user, 'api')->get($this->routePrefix . '/' . $employee->id);

        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
    }

    public function test_get_all_employees(): void
    {
        $user = User::factory()->create();
        $this->addEmployee();

        $response = $this->actingAs($user, 'api')->get($this->routePrefix);

        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
        $this->assertCount(2, $response->json('data'));
    }
}
