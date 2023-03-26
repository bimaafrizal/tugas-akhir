<?php

namespace App\Http\Controllers;

use App\Models\Earthquake;
use App\Http\Requests\StoreEarthquakeRequest;
use App\Http\Requests\UpdateEarthquakeRequest;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class EarthquakeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gempa = Earthquake::orderBy('id', 'desc')->first();
        return view('pages.dashboard2.earthquake.index', compact('gempa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEarthquakeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
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
        $createdAt = $detailData->DateTime;

        if ($earthquake  == null) {
            Earthquake::insert([
                'longitude' => $longitude,
                'latitude' => $latitude,
                'strength' => $strength,
                'depth' => $depth,
                'tanggal' => $tanggal,
                'jam' => $jam,
                'created_at' => $createdAt
            ]);
        } else {
            if ($earthquake->longitude != $longitude || $earthquake->latitude != $latitude || $earthquake->tanggal != $detailData->Tanggal || $earthquake->jam  != $detailData->Jam) {
                Earthquake::insert([
                    'longitude' => $longitude,
                    'latitude' => $latitude,
                    'strength' => $strength,
                    'depth' => $depth,
                    'tanggal' => $tanggal,
                    'jam' => $jam,
                    'created_at' => $createdAt
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Earthquake  $earthquake
     * @return \Illuminate\Http\Response
     */
    public function show(Earthquake $earthquake)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Earthquake  $earthquake
     * @return \Illuminate\Http\Response
     */
    public function edit(Earthquake $earthquake)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEarthquakeRequest  $request
     * @param  \App\Models\Earthquake  $earthquake
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEarthquakeRequest $request, Earthquake $earthquake)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Earthquake  $earthquake
     * @return \Illuminate\Http\Response
     */
    public function destroy(Earthquake $earthquake)
    {
        //
    }

    public function downloadData()
    {
        $data = Earthquake::all();

        //create a csv file with fatched data
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=data-gempa" . Carbon::now() . '.csv',
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, array('Longitude', 'Latitude', 'Strength', 'Depth', 'Date', 'Time', 'Created At', 'Inserted At', 'Potency'));
            foreach ($data as $row) {
                fputcsv($file, array($row->longitude, $row->latitude, $row->strength, $row->depth, $row->date, $row->time, $row->created_at, $row->inserted_at, $row->potency));
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
