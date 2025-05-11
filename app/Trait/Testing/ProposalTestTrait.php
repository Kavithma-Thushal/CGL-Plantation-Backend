<?php
namespace App\Trait\Testing;

use App\Models\Bank;
use App\Models\Plan;
use App\Models\Title;
use App\Models\User;
use App\Models\UserPackage;
use Illuminate\Support\Facades\Log;

trait ProposalTestTrait{

    private function addPackage($data)
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')->post('api/admin/user-packages', $data);
        if(!isset($response['data']['id'])){
            Log::error($response->json());
        }
        return UserPackage::find($response['data']['id']);
    }

    private function getPackageData(array $overrides = []): array
    {
        $plan = Plan::factory()->create();
        $title = Title::factory()->create();
        $bank = Bank::factory()->create();
        $nic = '123456789V';
        return array_merge([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'title_id' => $title->id,
            'agent_id' => 1,
            'total_amount' => 5000.00,
            'lang' => 'en',
            'nic' => $nic,
            'mobile_number' => '0771234567',
            'passport_number' => 'A1234567',
            'payment_mode' => 'MONTHLY',
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
                'family_name' => 'Introducer',
                'first_name' => 'John',
                'reason' => 'Introducer reason',
                'relationship' => 'dfd',
                'nic' => $nic
            ],
            'plan_id' => $plan->id,
            'beneficiary' => [
                'first_name' => 'John',
                'nic' => $nic,
                'relationship' => 'dfd',
                'bank_id' => $bank->id, 
                'account_number' => '123456789',
            ]
        ], $overrides);
    }
}