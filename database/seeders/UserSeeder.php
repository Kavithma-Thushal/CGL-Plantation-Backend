<?php

namespace Database\Seeders;

use App\Http\Services\EmployeeService;
use App\Models\Bank;
use App\Models\User;
use App\Models\Role;
use App\Models\Title;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::beginTransaction();
        $user = User::create([
            'username' => config('common.first_user_username'),
            'nic' => '111111111111V',
            'password' => Hash::make(config('common.first_user_password'))
        ]);

        $user->assignRole(Role::where('status',0)->first()->name);//admin

        if (app()->environment() != 'production') {
            $employeeData  =  $this->getEmployeeData();
            $employeeService = App::make(EmployeeService::class);
            $employeeService->add($employeeData);
        }

        // DB::rollBack();

        // $employee = Employee::create([
        //     'user_id' => $user->id,
        //     'employee_code' => 'EMP0001',
        //     'commenced_date' => '2000/01/01',
        //     'status' => 1
        // ]);

        // $employeeBranch = EmployeeBranch::create([
        //     'employee_id' => $employee->id,
        //     'branch_id' => Branch::first()->id
        // ]);

        // $employee->current_employee_branch_id = $employeeBranch->id;
        // $employee->save();


        // PersonalDetails::create([
        //     'userable_id' => $employee->id,
        //     'userable_type' => Employee::class,
        //     'name_with_initials' => 'System Admin',
        //     'first_name' => 'System Admin',
        //     'last_name' => '',
        //     'status' => 1
        // ]);
    }

    private function getEmployeeData(){
        return [
            "title_id" => Title::first()->id,
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
            "bank_id" => Bank::first()->id,
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
            "username" => "harsha",
            "password" => "Harsha@123",
            "user_role_id" => Role::where('status',1)->first()->id
        ];
    }
}
