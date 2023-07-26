<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use App\Http\Requests\StoreEwsRequest;
use App\Http\Requests\UpdateEwsRequest;
use App\Models\Ews;
use App\Models\User;
use App\Services\Ews\EwsService;
use Mockery;

class EwsControllerTest extends TestCase
{
    /**
     * Test creating a new EWS.
     *
     * @return void
     */
    public function testCreateEws()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(User::find(3));

        // Mock the EwsService
        $mockService = Mockery::mock(EwsService::class);
        $this->app->instance(EwsService::class, $mockService);
        // Mock the StoreEwsRequest validation
        $requestData = [
            'name' => 'EWS Name',
            'province_id' => '1',
            'regency_id' => '1',
            'standard_id' => '1',
            'detail' => 'EWS Detail',
            'longitude' => '-7.563356',
            'latitude' => '123.456',
            'api_url' => 'https://api.thingspeak.com/testing',
        ];

        // Mock the StoreEwsRequest validation
        $request = new StoreEwsRequest();
        $request->merge($requestData);
        $request->setContainer(app());
        $request->validateResolved();

        // Expect the create method of the EwsService to be called once with the request data
        $mockService->shouldReceive('create')->once()->with($requestData);

        // Make the request to the store method
        $response = $this->post(route('ews.store'), $requestData);

        // Assert that the response is as expected
        $response->assertStatus(302);
        $response->assertRedirect(route('ews.index'));
        $response->assertSessionHas('success', 'Alat EWS berhasil ditambahkan');
    }

    /**
     * Test updating an existing EWS.
     *
     * @return void
     */
    public function testUpdateEws()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(User::find(3));

        // Create an EWS to update
        $ews = Ews::create([
            'name' => 'EWS Name',
            'province_id' => '1',
            'regency_id' => '1',
            'standard_id' => '1',
            'detail' => 'EWS Detail',
            'longitude' => '-7.563356',
            'latitude' => '123.456',
            'api_url' => 'https://api.thingspeak.com/testing',
        ]);

        // Mock the UpdateEwsRequest validation
        $requestData = [
            'name' => 'Update EWS Name',
            'province_id' => '1',
            'regency_id' => '1',
            'standard_id' => '1',
            'detail' => 'EWS Detail',
            'longitude' => '-7.563356',
            'latitude' => '123.456',
            'api_url' => 'https://api.thingspeak.com/testing',
        ];

        $request = new UpdateEwsRequest();
        $request->merge($requestData);
        $request->setContainer(app());
        $request->validateResolved();

        $this->mock(EwsService::class, function ($mock) use ($ews, $requestData) {
            $mock->shouldReceive('update')->once()->with($ews->id, $requestData);
        });

        $response = $this->post(route('ews.update', encrypt($ews->id)), $requestData);

        // Assert that the EWS was updated successfully
        $response->assertStatus(302);
        $response->assertRedirect(route('ews.index'));
        $response->assertSessionHas('success', 'Alat EWS berhasil diedit');
    }
    /**
     * Test updating the status of an existing EWS.
     *
     * @return void
     */
    public function testUpdateEwsStatus()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(User::find(3));

        // Create an EWS to update the status
        $ews = Ews::create([
            'name' => 'EWS Name Update',
            'province_id' => '1',
            'regency_id' => '1',
            'standard_id' => '1',
            'detail' => 'EWS Detail',
            'longitude' => '-7.563356',
            'latitude' => '123.456',
            'api_url' => 'https://api.thingspeak.com/testing',
            'status' => '0'
        ]);

        // Mock the request data
        $requestData = [
            'is_active' => '1', // Set the desired status here
        ];

        $this->mock(EwsService::class, function ($mock) use ($ews, $requestData) {
            $mock->shouldReceive('updateStatus')->once()->with($ews->id, $requestData['is_active']);
        });

        $response = $this->post(route('ews.edit-status', encrypt($ews->id)), $requestData);

        // Assert that the EWS status was updated successfully
        $response->assertStatus(302);
        $response->assertRedirect(route('ews.index'));
        $response->assertSessionHas('success', 'Status EWS berhasil dirubah');
    }
}
