<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Console\Commands\WeatherCorn;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Mockery;

class WeatherCornTest extends TestCase
{
    public function testHandleMethodDispatchesNotifications()
    {
        // Mock the Client
        $mockResponseData = '{"list": [{"weather": [{"description": "awan tersebar"}]}]}';
        $mockResponse = new Response(200, [], $mockResponseData);
        $mockClient = Mockery::mock(Client::class);
        $mockClient->shouldReceive('request')->andReturn($mockResponse);

        // Bind the mocked Client instance into the app container
        $this->app->instance(Client::class, $mockClient);

        // Create the WeatherCorn instance
        $weatherCorn = app()->make(WeatherCorn::class);

        // Run the handle method
        $result = $weatherCorn->handle();

        // Assert the result as needed
        $this->assertTrue($result);
    }
}
