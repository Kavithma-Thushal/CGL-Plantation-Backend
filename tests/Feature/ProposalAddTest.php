<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Bank;
use App\Models\Plan;
use App\Models\User;
use App\Models\Title;
use App\Enums\PaymentModesEnum;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use App\Trait\Testing\ProposalTestTrait;

class ProposalAddTest extends TestCase
{
    use ProposalTestTrait;

    private $routePrefix = 'api/admin/user-packages';

    // Setup method runs before every test in this class
    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate:custom');

        // $clientRepository = new ClientRepository();
        // $clientRepository->createPersonalAccessClient(
        //     null,
        //     'Test Personal Access Client',
        //     'http://localhost'
        // );
    }

    public function test_can_add_user_package_with_valid_data()
    {
        // Arrange
        $data = $this->getPackageData();

        // Act
        $user = User::first();
        $response = $this->actingAs($user, 'api')->postJson($this->routePrefix, $data);

        // Assert
        $response->assertStatus(200); // Assuming 200 Created is returned
    }

    public function test_cant_add_user_package_with_invalid_first_name()
    {
        $data = $this->getPackageData(['first_name' => 'lkj ldfl . ls']);
        $this->assertValidationError($data, 'first_name');
    }
  
    public function test_cant_add_user_package_with_null_first_name()
    {
        $data = $this->getPackageData(['first_name' => null]);
        $this->assertValidationError($data, 'first_name');
    }
    
    public function test_cant_add_user_package_with_invalid_last_name()
    {
        $data = $this->getPackageData(['last_name' =>32423234]);
        $this->assertValidationError($data, 'last_name');
    }

    public function test_cant_add_user_package_with_invalid_email()
    {
        $data = $this->getPackageData(['email' => 'invalid-email']);
        $this->assertValidationError($data, 'email');
    }

    public function test_cant_add_user_package_with_null_email()
    {
        $data = $this->getPackageData(['email' => null]);
        $this->assertValidationSuccess($data);
    }

    public function test_cant_add_user_package_with_invalid_title_id()
    {
        $data = $this->getPackageData(['title_id' => 3453453]);
        $this->assertValidationError($data, 'title_id');
    }
  
    public function test_cant_add_user_package_with_invalid_name_with_initials()
    {
        $data = $this->getPackageData(['name_with_initials' => 3453453]);
        $this->assertValidationError($data, 'name_with_initials');
    }

    public function test_cant_add_user_package_with_invalid_family_name()
    {
        $data = $this->getPackageData(['family_name' => 3453453]);
        $this->assertValidationError($data, 'family_name');
    }

    public function test_cant_add_user_package_with_license_number()
    {
        $data = $this->getPackageData(['license_number' => 3453453]);
        $this->assertValidationError($data, 'license_number');
    }

    public function test_cant_add_user_package_with_license_number_length()
    {
        $data = $this->getPackageData(['license_number' => 3434534534534534534534534534534534534534534534534534]);
        $this->assertValidationError($data, 'license_number');
    }

     // Test missing agent_id
     public function test_cant_add_user_package_without_agent_id()
     {
         $data = $this->getPackageData(['agent_id' => null]);
         $this->assertValidationError($data, 'agent_id');
     }
   
     public function test_cant_add_user_package_with_invalid_agent_id()
     {
         $data = $this->getPackageData(['agent_id' => 6666]);
         $this->assertValidationError($data, 'agent_id');
     }
    
     public function test_cant_add_user_package_with_minus_total_amount()
     {
         $data = $this->getPackageData(['total_amount' => -43]);
         $this->assertValidationError($data, 'total_amount');
     }

     public function test_cant_add_user_package_with_null_total_amount()
     {
         $data = $this->getPackageData(['total_amount' => null]);
         $this->assertValidationError($data, 'total_amount');
     }
   
     public function test_cant_add_user_package_with_lang()
     {
         $data = $this->getPackageData(['lang' => null]);
         $this->assertValidationError($data, 'lang');
     }

     public function test_cant_add_user_package_with_invalid_lang()
     {
         $data = $this->getPackageData(['lang' => 'dd']);
         $this->assertValidationError($data, 'lang');
     }

    // Test invalid NIC format
    public function test_cant_add_user_package_with_invalid_nic()
    {
        $data = $this->getPackageData(['nic' => 'invalidNIC']);
        $this->assertValidationError($data, 'nic');
    }
    
    public function test_cant_add_user_package_with_invalid_nic_length()
    {
        $data = $this->getPackageData(['nic' => '123456789123456789']);
        $this->assertValidationError($data, 'nic');
    }
  
    public function test_cant_add_user_package_with_invalid_mobile_number()
    {
        $data = $this->getPackageData(['mobile_number' => '072xcvxc75539']);
        $this->assertValidationError($data, 'mobile_number');
    }
    
    public function test_cant_add_user_package_with_invalid_mobile_number_length()
    {
        $data = $this->getPackageData(['mobile_number' => '0734567891234567845142']);
        $this->assertValidationError($data, 'mobile_number');
    }
  
    public function test_cant_add_user_package_with_invalid_country_id()
    {
        $data = $this->getPackageData(['country_id' => 34345]);
        $this->assertValidationError($data, 'country_id');
    }
  
    public function test_can_add_user_package_with_null_country_id()
    {
        $data = $this->getPackageData(['country_id' => null]);
        $this->assertValidationSuccess($data);
    }
 
    public function test_cant_add_user_package_with_invalid_race_id()
    {
        $data = $this->getPackageData(['race_id' => 34345]);
        $this->assertValidationError($data, 'race_id');
    }
  
    public function test_can_add_user_package_with_null_race_id()
    {
        $data = $this->getPackageData(['race_id' => null]);
        $this->assertValidationSuccess($data);
    }
   
    public function test_cant_add_user_package_with_invalid_nationality_id()
    {
        $data = $this->getPackageData(['nationality_id' => 34345]);
        $this->assertValidationError($data, 'nationality_id');
    }
  
    public function test_can_add_user_package_with_null_nationality_id()
    {
        $data = $this->getPackageData(['nationality_id' => null]);
        $this->assertValidationSuccess($data);
    }
    
   
    public function test_cant_add_user_package_with_invalid_occupation_id()
    {
        $data = $this->getPackageData(['occupation_id' => 34345]);
        $this->assertValidationError($data, 'occupation_id');
    }
  
    public function test_can_add_user_package_with_null_occupation_id()
    {
        $data = $this->getPackageData(['occupation_id' => null]);
        $this->assertValidationSuccess($data);
    }
    
 
    // Test invalid nominee percentage sum
    public function test_cant_add_user_package_with_invalid_nominee_percentage_sum()
    {
        $data = $this->getPackageData();
        $data['nominees'][0]['percentage'] = 90;
        $this->assertValidationError($data, 'nominees');
    }

    public function test_cant_add_user_package_with_valid_nominee_percentage_sum()
    {
        $data = $this->getPackageData();
        $data['nominees'][0]['percentage'] = 100;
        $this->assertValidationSuccess($data);
    }

    public function test_cant_add_user_package_with_valid_nominee_multiple_percentage_sum()
    {
        $data = $this->getPackageData();
        $data['nominees'][0]['percentage'] = 25;

        $data['nominees'][1] = $data['nominees'][0];
        $data['nominees'][1]['percentage'] = 25;

        $data['nominees'][2] = $data['nominees'][0];
        $data['nominees'][2]['percentage'] = 20;

        $data['nominees'][3] = $data['nominees'][0];
        $data['nominees'][3]['percentage'] = 30;
        $this->assertValidationSuccess($data);
    }
  
    public function test_cant_add_user_package_with_invalid_nominee_multiple_percentage_sum()
    {
        $data = $this->getPackageData();
        $data['nominees'][0]['percentage'] = 25;

        $data['nominees'][1] = $data['nominees'][0];
        $data['nominees'][1]['percentage'] = 25;

        $data['nominees'][2] = $data['nominees'][0];
        $data['nominees'][2]['percentage'] = 20;

        $data['nominees'][3] = $data['nominees'][0];
        $data['nominees'][3]['percentage'] = 29;
        $this->assertValidationError($data, 'nominees');
    }

    public function test_cant_add_user_package_with_invalid_nominee_multiple_beyond_percentage_sum()
    {
        $data = $this->getPackageData();
        $data['nominees'][0]['percentage'] = 25;

        $data['nominees'][1] = $data['nominees'][0];
        $data['nominees'][1]['percentage'] = 25;

        $data['nominees'][2] = $data['nominees'][0];
        $data['nominees'][2]['percentage'] = 20;

        $data['nominees'][3] = $data['nominees'][0];
        $data['nominees'][3]['percentage'] = 31;
        $this->assertValidationError($data, 'nominees');
    }

    // Test required fields in introducer array
    public function test_cant_add_user_package_with_missing_introducer_fields()
    {
        $data = $this->getPackageData(['introducer' => [
            'family_name' => 'Introducer',
            // Missing 'first_name',relationship,nic and 'reason'
        ]]);
        $this->assertValidationError($data, 'introducer.first_name');
        $this->assertValidationError($data, 'introducer.reason');
        $this->assertValidationError($data, 'introducer.nic');
        $this->assertValidationError($data, 'introducer.relationship');
    }

    public function test_cant_add_user_package_with_introducer_fields()
    {
        $data = $this->getPackageData(['introducer' => [
            'first_name' => 'Introducer',
            'reason' => 'dfd',
            'nic'=>'43443',
            'relationship'=>'sdfdfs'
        ]]);
        $this->assertValidationSuccess($data);
    }

    // Test invalid payment mode
    public function test_cant_add_user_package_with_invalid_payment_mode()
    {
        $data = $this->getPackageData(['payment_mode' => 'INVALID']);
        $this->assertValidationError($data, 'payment_mode');
    }
   
    public function test_can_add_user_package_only_with_required_filed()
    {
        $plan = Plan::factory()->create();
        $title = Title::factory()->create();
        $bank = Bank::factory()->create();
        $nic = '123456789V';
        $data = [
            'first_name' => 'John',
            'title_id' => $title->id,
            'agent_id' => 1,
            'total_amount' => 5000.00,
            'lang' => 'en',
            'nic' => $nic,
            'mobile_number' => '0771234567',
            'payment_mode' => 'MONTHLY',
            'plan_id' => $plan->id,
            
            'nominees' => [
                [
                    'title_id' => $title->id,
                    'name_with_initials' => 'J. Doe',
                    'first_name' => 'Doe',
                    'percentage' => 100,
                    'nic' => '354353453V',
                    'relationship' => 'dauter'
                ]
            ],
            'introducer' => [
                'first_name' => 'John',
                'reason' => 'Introducer reason',
                'relationship' => 'dfd',
                'nic' => $nic
            ],
            'beneficiary' => [
                'first_name' => 'John',
                'nic' => $nic,
                'relationship' => 'dfd',
                'bank_id' => $bank->id, 
                'account_number' => '123456789',
            ]
        ];
        $this->assertValidationSuccess($data);
    }

    public function test_cant_add_user_package_with_valid_payment_mode()
    {
        $data = $this->getPackageData(['payment_mode' => PaymentModesEnum::YEARLY]);
        $this->assertValidationSuccess($data);
    }
   
    public function test_cant_add_user_package_with_invalid_nominees()
    {
        $data = $this->getPackageData(['nominees' => 'invalid']);
        $this->assertValidationError($data, 'nominees');
    }
 
    public function test_can_add_user_package_with_null_name_with_initial_si()
    {
        $data = $this->getPackageData();
        $data['lang'] = 'en';
        $data['name_with_initial_si'] = null;
        $this->assertValidationSuccess($data);
    }
   
    public function test_cant_add_user_package_with_null_name_with_initial_si_when_lang_is_sinhala()
    {
        $data = $this->getPackageData();
        $data['lang'] = 'si';
        $data['name_with_initial_si'] = null;
        $this->assertValidationError($data, 'name_with_initial_si');
    }
  
    public function test_can_add_user_package_with_lang_is_sinhala()
    {
        $data = $this->getPackageData();
        $data['lang'] = 'si';
        $data['name_with_initial_si'] = 'බො.අ';
        $data['family_name_si'] = 'මුදියන්සෙලගෙ';
        $data['first_name_si'] = 'හර්ෂ';
        $data['middle_name_si'] = 'ප්‍රියංකර';
        $data['last_name_si'] = 'බණ්ඩාර';
        $data['address_si'] = 'සුවාරපොල, පිලියන්දල';
        $this->assertValidationSuccess($data);
    }
    
    public function test_can_add_user_package_with_null_family_name_si()
    {
        $data = $this->getPackageData();
        $data['lang'] = 'en';
        $data['family_name_si'] = null;
        $this->assertValidationSuccess($data);
    }
   
    public function test_cant_add_user_package_with_null_family_name_si_when_lang_is_sinhala()
    {
        $data = $this->getPackageData();
        $data['lang'] = 'si';
        $data['family_name_si'] = null;
        $this->assertValidationError($data, 'family_name_si');
    }
   
    public function test_can_add_user_package_with_null_first_name_si()
    {
        $data = $this->getPackageData();
        $data['lang'] = 'en';
        $data['first_name_si'] = null;
        $this->assertValidationSuccess($data);
    }
   
    public function test_cant_add_user_package_with_null_first_name_si_when_lang_is_sinhala()
    {
        $data = $this->getPackageData();
        $data['lang'] = 'si';
        $data['first_name_si'] = null;
        $this->assertValidationError($data, 'first_name_si');
    }

    public function test_cant_add_user_package_with_null_nominees()
    {
        $data = $this->getPackageData();
        $data['nominees'] = [];
        $this->assertValidationError($data, 'nominees');
    }
  
    public function test_cant_add_user_package_with_null_plan_id()
    {
        $data = $this->getPackageData();
        $data['plan_id'] = null;
        $this->assertValidationError($data, 'plan_id');
    }
  
    public function test_cant_add_user_package_with_invalid_plan_id()
    {
        $data = $this->getPackageData();
        $data['plan_id'] = 2342;
        $this->assertValidationError($data, 'plan_id');
    }
  
    public function test_cant_add_user_package_with_invalid_land_size()
    {
        $data = $this->getPackageData();
        $data['land_size'] = -2342;
        $this->assertValidationError($data, 'land_size');
    }

    public function test_cant_add_user_package_with_invalid_land_value()
    {
        $data = $this->getPackageData();
        $data['land_value'] = -2342;
        $this->assertValidationError($data, 'land_value');
    }
  
    public function test_cant_add_user_package_with_invalid_number_of_trees()
    {
        $data = $this->getPackageData();
        $data['number_of_trees'] = -2342;
        $this->assertValidationError($data, 'number_of_trees');
    }

    // Helper method to assert validation error
    private function assertValidationError(array $data, string $field,bool $log = false)
    {
        $user = User::first();
        $response = $this->actingAs($user, 'api')->postJson($this->routePrefix, $data);
        if($log) Log::info($response->json());
        $response->assertStatus(422)
            ->assertJsonStructure([
                'error' => [
                    $field
                ]
            ]);
    }

    private function assertValidationSuccess(array $data,bool $log = false)
    {
        $user = User::first();
        $response = $this->actingAs($user, 'api')->postJson($this->routePrefix, $data);
        if($log) Log::info($response->json());
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    
}
