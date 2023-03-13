<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Earthquake;
use GuzzleHttp\Client;

class EarthquakeCorn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'earthquake:corn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data earthquake from bmkg every one minutes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json');
        $data = json_decode($response->getBody()->getContents());
        $detailData = $data->Infogempa->gempa;

        $earthquake = Earthquake::orderBy('created_at', 'desc')->first();

        $latitude = substr($detailData->Coordinates, strpos($detailData->Coordinates, ',') + 1);
        $longitude = substr($detailData->Coordinates, '0', strpos($detailData->Coordinates, ','));
        $strength = $detailData->Magnitude;
        $depth = $detailData->Kedalaman;
        $tanggal = $detailData->Tanggal;
        $jam = $detailData->Jam;
        if ($earthquake  == null) {
            Earthquake::create([
                'longitude' => $longitude,
                'latitude' => $latitude,
                'strength' => $strength,
                'depth' => $depth,
                'tanggal' => $tanggal,
                'jam' => $jam
            ]);
        } else {
            if ($earthquake->longitude != $longitude && $earthquake->latitude != $latitude && $earthquake->tanggal != $detailData->Tanggal && $earthquake->jam  != $detailData->Jam) {

                Earthquake::create([
                    'longitude' => $longitude,
                    'latitude' => $latitude,
                    'strength' => $strength,
                    'depth' => $depth,
                    'tanggal' => $tanggal,
                    'jam' => $jam
                ]);
            }
        }
        $this->info('Berhasil menambahkan data gempa');
    }
}