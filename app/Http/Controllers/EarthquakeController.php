<?php

namespace App\Http\Controllers;

use App\Models\Earthquake;
use App\Http\Requests\StoreEarthquakeRequest;
use App\Http\Requests\UpdateEarthquakeRequest;
use GuzzleHttp\Client;

class EarthquakeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
}