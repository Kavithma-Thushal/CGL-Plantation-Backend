<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Bank;
use App\Models\User;
use App\Models\Title;
use Laravel\Passport\ClientRepository;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeCreateTest extends TestCase
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

    public function test_add_employee(): void
    {
        $response = $this->addEmployee();
        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
        $this->assertDatabaseHas('employees', ['epf_number' => $response['data']['epf_number']]);
    }

    public function test_create_multiple_employee_with_same_epf_number(): void
    {
        $this->addEmployee();
        $response = $this->addEmployee();
        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'epf_number'
            ]
        ]);
    }

    private function addEmployee()
    {
        $user = User::factory()->create();
        $employeeData  =  $this->getEmployeeData();
        return $this->actingAs($user, 'api')->post($this->routePrefix, $employeeData);
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


    public function test_add_employee_with_missing_required_fields(): void
    {
        $employeeData = $this->getEmployeeData();
        unset($employeeData['first_name'], $employeeData['last_name']);

        $response = $this->actingAs(User::factory()->create(), 'api')->post($this->routePrefix, $employeeData);
        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'first_name'
            ]
        ]);
    }

    public function test_add_employee_with_invalid_nic_format(): void
    {
        $employeeData = $this->getEmployeeData(['nic' => 'invalidNIC']);

        $response = $this->actingAs(User::factory()->create(), 'api')->post($this->routePrefix, $employeeData);

        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'nic'
            ]
        ]);
    }

    public function test_add_employee_with_non_existent_title_id(): void
    {
        $employeeData = $this->getEmployeeData(['title_id' => 9999]);

        $response = $this->actingAs(User::factory()->create(), 'api')->post($this->routePrefix, $employeeData);

        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'title_id'
            ]
        ]);
    }

    public function test_add_employee_with_special_characters_in_first_name(): void
    {
        $employeeData = $this->getEmployeeData(['first_name' => 'Harsha@deva']);

        $response = $this->actingAs(User::factory()->create(), 'api')->post($this->routePrefix, $employeeData);

        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'first_name'
            ]
        ]);
    }

    public function test_add_employee_with_special_characters_in_middle_name(): void
    {
        $employeeData = $this->getEmployeeData(['middle_name' => 'Harsha@deva']);

        $response = $this->actingAs(User::factory()->create(), 'api')->post($this->routePrefix, $employeeData);

        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'middle_name'
            ]
        ]);
    }

    public function test_add_employee_with_special_characters_in_last_name(): void
    {
        $employeeData = $this->getEmployeeData(['last_name' => 'Harsha@deva']);

        $response = $this->actingAs(User::factory()->create(), 'api')->post($this->routePrefix, $employeeData);

        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'last_name'
            ]
        ]);
    }

    public function test_add_employee_with_existing_mobile_number(): void
    {
        $this->addEmployee();

        $employeeData = $this->getEmployeeData(['mobile_number' => '0717233539', 'epf_number' => 'LKD']);
        $response = $this->actingAs(User::factory()->create(), 'api')->post($this->routePrefix, $employeeData);
        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'mobile_number'
            ]
        ]);
    }

    public function test_add_employee_without_system_access(): void
    {
        $employeeData = $this->getEmployeeData(['has_system_access' => 0, 'username' => null, 'password' => null]);

        $response = $this->actingAs(User::factory()->create(), 'api')->post($this->routePrefix, $employeeData);

        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
    }

    public function test_add_employee_with_system_access(): void
    {
        $employeeData = $this->getEmployeeData(['has_system_access' => 1, 'username' => 'Harsha', 'password' => 'password']);

        $response = $this->actingAs(User::factory()->create(), 'api')->post($this->routePrefix, $employeeData);

        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
    }

    public function test_add_employee_with_maximum_length_fields(): void
    {
        $employeeData = $this->getEmployeeData([
            'first_name' => str_repeat('A', 255),
            'last_name' => str_repeat('B', 255),
            'address' => str_repeat('C', 500)
        ]);

        $response = $this->actingAs(User::factory()->create(), 'api')->post($this->routePrefix, $employeeData);

        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
    }

    public function test_add_employee_with_invalid_bank_id(): void
    {
        $employeeData = $this->getEmployeeData(['bank_id' => 9999]);

        $response = $this->actingAs(User::factory()->create(), 'api')->post($this->routePrefix, $employeeData);

        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'bank_id'
            ]
        ]);
    }

    public function test_add_employee_with_incorrect_role_id(): void
    {
        $employeeData = $this->getEmployeeData(['user_role_id' => 9999]);

        $response = $this->actingAs(User::factory()->create(), 'api')->post($this->routePrefix, $employeeData);

        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'user_role_id'
            ]
        ]);
    }

    public function test_add_employee_with_invalid_operating_branches(): void
    {
        $employeeData = $this->getEmployeeData(['operating_branches' => [['branch_id' => 9999]]]);

        $response = $this->actingAs(User::factory()->create(), 'api')->post($this->routePrefix, $employeeData);

        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'operating_branches.0.branch_id'
            ]
        ]);
    }

    public function test_add_employee_with_valid_operating_branches(): void
    {
        $employeeData = $this->getEmployeeData(['operating_branches' => [['branch_id' => 1], ['branch_id' => 2]]]);

        $response = $this->actingAs(User::factory()->create(), 'api')->post($this->routePrefix, $employeeData);

        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
    }
}
