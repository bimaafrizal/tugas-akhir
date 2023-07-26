<?php

namespace Tests\Unit;

use Tests\TestCase;
use GuzzleHttp\Client;
use App\Console\Commands\EarthquakeCorn;
use App\Models\Earthquake;
use App\Models\Disaster;
use App\Models\User;
use Carbon\Carbon;
use Mockery;

class EarthquakeCornTest extends TestCase
{
    public function testHandleMethod()
    {
        // Mock the Client
        $mockClient = Mockery::mock(Client::class);
        $mockResponse = '{"Infogempa": {"gempa": {
            "Tanggal": "23 Jul 2023",
            "Jam": "03:27:35 WIB",
            "DateTime": "2023-07-22T20:27:35+00:00",
            "Coordinates": "-1.96,99.93",
            "Lintang": "1.96 LS",
            "Bujur": "99.93 BT",
            "Magnitude": "4.2",
            "Kedalaman": "10 km",
            "Wilayah": "Pusat gempa berada di laut 35 km TimurLaut Pulau Sipora",
            "Potensi": "Gempa ini dirasakan untuk diteruskan pada masyarakat",
            "Dirasakan": "II-III Padang",
            "Shakemap": "20230723032735.mmi.jpg"}}}';
        $mockClient->shouldReceive('request')->andReturn(
            new \GuzzleHttp\Psr7\Response(200, [], $mockResponse)
        );

        // Mock the database models
        $mockEarthquake = Mockery::mock(Earthquake::class);
        $mockEarthquake->shouldReceive('orderBy')->andReturnSelf();
        $mockEarthquake->shouldReceive('first')->andReturnNull();
        $mockEarthquake->shouldReceive('insert')->andReturn(true);

        $mockDisaster = Mockery::mock(Disaster::class);
        $mockDisaster->shouldReceive('where')->andReturnSelf();
        $mockDisaster->shouldReceive('first')->andReturnSelf();

        $mockUser = Mockery::mock(User::class);
        $mockUser->shouldReceive('join')->andReturnSelf();
        $mockUser->shouldReceive('where')->andReturnSelf();
        $mockUser->shouldReceive('whereNotNull')->andReturnSelf();
        $mockUser->shouldReceive('get')->andReturn(collect([]));

        // Create the EarthquakeCorn instance and set the mocked dependencies
        $earthquakeCorn = new EarthquakeCorn($mockClient, $mockEarthquake, $mockDisaster, $mockUser);

        // Run the handle method
        $result = $earthquakeCorn->handle();

        // Assert the result as needed
        $this->assertTrue($result);
    }
}
