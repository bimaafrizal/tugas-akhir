<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\EWS;
use App\Models\Flood;
use GuzzleHttp\Promise\Promise;
use Illuminate\Foundation\Testing\PendingDispatch;
use Mockery;

class FloodCornTest extends TestCase
{
    public function testFloodCornCommand()
    {
        // Mock data for EWS and Flood models
        $ewsData = [
            EWS::where('status', '1')->get()
        ];

        $floodData = [
            Flood::all()
        ];

        // Mock the EWS and Flood models
        $ewsMock = Mockery::mock(Ews::class);
        $ewsMock->shouldReceive('where')->with('status', '1')->andReturnSelf();
        $ewsMock->shouldReceive('get')->andReturn($ewsData);

        $floodMock = Mockery::mock(Flood::class);
        $floodMock->shouldReceive('where', 'first')->andReturnUsing(function ($args) use ($floodData) {
            return collect($floodData)->where('ews_id', $args[1])->sortByDesc('created_at')->first();
        });

        // Bind the mock instances to the IoC container to be used in the command
        $this->app->instance(Ews::class, $ewsMock);
        $this->app->instance(Flood::class, $floodMock);

        // Mock the dispatch method for promises and jobs
        $this->mockPromiseDispatch();

        // Run the command
        $this->artisan('flood:corn')
            ->assertExitCode(0);
    }

    private function mockPromiseDispatch()
    {
        app()->instance(\GuzzleHttp\Promise\Promise::class, new \GuzzleHttp\Promise\Promise());
    }
}
