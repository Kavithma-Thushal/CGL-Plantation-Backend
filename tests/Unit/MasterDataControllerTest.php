<?php

namespace Tests\Unit;

use App\Http\Controllers\MasterDataController;
use Mockery;
use PHPUnit\Framework\TestCase;

class MasterDataControllerTest extends TestCase
{
    // public function testGetTitles()
    // {
    //    // Mock MasterDataService
    //    $mockService = Mockery::mock(MasterDataService::class);
        
    //    // Mock request
    //    $request = $this->createMock(\Illuminate\Http\Request::class);
    //    $request->expects($this->once())->method('all')->willReturn([]);

    //    // Mock data response from service
    //    $mockTitles = [
    //        ['id' => 1, 'name' => 'Title A'],
    //        ['id' => 2, 'name' => 'Title B'],
    //    ];
    //    $mockService->shouldReceive('getTitles')->once()->andReturn($mockTitles);

    //    // Call the controller method
    //    $controller = new MasterDataController($mockService);
    //    $response = $controller->getTitles($request);

    //    // Assertions
    //    $response->assertStatus(200); // Assuming SuccessResource returns 200 OK
    //    $response->assertJson([
    //        'data' => $mockTitles, // Check if the returned data matches mock data
    //    ]);
    // }
}
