<?php

namespace Tests\Feature;

use App\Classes\CodeGenerator;
use Tests\TestCase;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\User;
use App\Models\Title;
use App\Models\Employee;
use App\Models\EmployeeDesignation;
use Laravel\Passport\ClientRepository;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

class EmployeeUpdateTest extends TestCase
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

    public function test_update_employee(): void
    {
        $employee = $this->createEmployee();
        $updateData = $this->getEmployeeData(['first_name' => 'UpdatedName']);

        $response = $this->actingAs($employee->user, 'api')->put("{$this->routePrefix}/{$employee->id}", $updateData);

        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
    }

    public function test_update_employee_with_invalid_nic_format(): void
    {
        $employee = $this->createEmployee();
        $updateData = $this->getEmployeeData(['nic' => 'invalidNIC']);

        $response = $this->actingAs($employee->user, 'api')->put("{$this->routePrefix}/{$employee->id}", $updateData);

        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'nic'
            ]
        ]);
    }

    public function test_update_employee_with_existing_mobile_number(): void
    {
        $existingEmployee = $this->createEmployee();
        $employeeToUpdate = $this->createEmployee(['nic' => '950184258V','username'=>'32', 'epf_number' => '2322dff', 'mobile_number' => '0717000000']);

        $updateData = $this->getEmployeeData(['mobile_number' => $existingEmployee->mobile_number]);

        $response = $this->actingAs($employeeToUpdate->user, 'api')->put("{$this->routePrefix}/{$employeeToUpdate->id}", $updateData);

        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'mobile_number'
            ]
        ]);
    }

    public function test_update_employee_with_existing_nic_number(): void
    {
        $existingEmployee = $this->createEmployee();
        $employeeToUpdate = $this->createEmployee(['nic' => '950234018V','username'=>'32', 'epf_number' => '2322dff', 'mobile_number' => '0717000000']);

        $updateData = $this->getEmployeeData(['nic' => $existingEmployee->nic]);

        $response = $this->actingAs($employeeToUpdate->user, 'api')->put("{$this->routePrefix}/{$employeeToUpdate->id}", $updateData);

        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'nic'
            ]
        ]);
    }

    public function test_update_employee_with_invalid_title_id(): void
    {
        $employee = $this->createEmployee();
        $updateData = $this->getEmployeeData(['title_id' => 9999]);

        $response = $this->actingAs($employee->user, 'api')->put("{$this->routePrefix}/{$employee->id}", $updateData);

        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'title_id'
            ]
        ]);
    }

    public function test_update_employee_with_special_characters_in_first_name(): void
    {
        $employee = $this->createEmployee();
        $updateData = $this->getEmployeeData(['first_name' => 'Invalid@Name']);

        $response = $this->actingAs($employee->user, 'api')->put("{$this->routePrefix}/{$employee->id}", $updateData);

        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'first_name'
            ]
        ]);
    }

    public function test_update_employee_without_system_access(): void
    {
        $employee = $this->createEmployee();
        $updateData = $this->getEmployeeData(['has_system_access' => 0, 'username' => null, 'password' => null]);

        $response = $this->actingAs($employee->user, 'api')->put("{$this->routePrefix}/{$employee->id}", $updateData);
        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
    }

    public function test_update_employee_with_system_access(): void
    {
        $employee = $this->createEmployee();
        $updateData = $this->getEmployeeData(['has_system_access' => 1, 'username' => 'UpdatedUsername', 'password' => 'NewPassword']);

        $response = $this->actingAs($employee->user, 'api')->put("{$this->routePrefix}/{$employee->id}", $updateData);

        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
    }

    public function test_update_employee_with_incorrect_role_id(): void
    {
        $employee = $this->createEmployee();
        $updateData = $this->getEmployeeData(['user_role_id' => 9999]);

        $response = $this->actingAs($employee->user, 'api')->put("{$this->routePrefix}/{$employee->id}", $updateData);

        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'user_role_id'
            ]
        ]);
    }

    public function test_update_employee_with_invalid_operating_branches(): void
    {
        $employee = $this->createEmployee();
        $updateData = $this->getEmployeeData(['operating_branches' => [['branch_id' => 9999]]]);

        $response = $this->actingAs($employee->user, 'api')->put("{$this->routePrefix}/{$employee->id}", $updateData);

        $response->assertStatus(422)->assertJsonStructure([
            'error' => [
                'operating_branches.0.branch_id'
            ]
        ]);
    }

    public function test_update_employee_with_valid_operating_branches(): void
    {
        $employee = $this->createEmployee();
        $updateData = $this->getEmployeeData(['operating_branches' => [['branch_id' => 1], ['branch_id' => 2]]]);

        $response = $this->actingAs($employee->user, 'api')->put("{$this->routePrefix}/{$employee->id}", $updateData);

        $response->assertStatus(200)->assertJsonStructure(['data' => []]);
    }

    public function test_update_employee_change_employee_code(): void
    {
        $employee = $this->createEmployee();
        $branchId = 2;
        $updateData = $this->getEmployeeData(['base_branch_id' => $branchId]);
        
        $response = $this->actingAs($employee->user, 'api')->put("{$this->routePrefix}/{$employee->id}", $updateData);
        $response->assertStatus(200);
        
        $branchCode = Branch::find($branchId)->branch_code;
        $employeeEpf = $employee->epf_number;
        $employeeBranchCode = CodeGenerator::generateEmployeeCode($employeeEpf,$branchCode);
        
        $updatedEmployee = Employee::find($employee->id);
        $updatedDesignation = EmployeeDesignation::where('employee_id',$employee->id)->active()->first();
        $this->assertEquals($employeeBranchCode, $updatedEmployee->employee_code, 'The employee code was not updated correctly in employee table.');
        $this->assertEquals($employeeBranchCode, $updatedDesignation->employee_code, 'The employee code was not updated correctly in employee designation table.');
    }

    private function createEmployee(array $overrides = [])
    {
        $user = User::factory()->create();
        $employeeData  =  $this->getEmployeeData($overrides);
        $response =  $this->actingAs($user, 'api')->post($this->routePrefix, $employeeData);
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
}
