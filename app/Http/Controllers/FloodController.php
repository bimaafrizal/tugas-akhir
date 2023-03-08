<?php

namespace App\Http\Controllers;

use App\Models\Flood;
use App\Http\Requests\StoreFloodRequest;
use App\Http\Requests\UpdateFloodRequest;
use App\Models\Ews;
use Carbon\Carbon;
use GuzzleHttp\Client;

class FloodController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFloodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $ews = Ews::all();
        $client = new Client();
        $array = [];

        foreach ($ews as $item) {
            $response = $client->request('GET', $item->api_url);
            $data = json_decode($response->getBody()->getContents());
            $detailData = $data->feeds[0];
            $arrayTemp = [];
            $flood = Flood::where('ews_id', $item->id)->orderBy('created_at', 'desc')->first();
            if ($flood == null) {
                if (property_exists($detailData, 'field2') == false) {
                    $arrayTemp['ews_id'] = $item->id;
                    if ($detailData->field1 <= 1024) {
                        $arrayTemp['level'] = 0;
                    } else if ($detailData->field1 > 1024 && $detailData->field1 <= 2048) {
                        $arrayTemp['level'] = 1;
                    } else if ($detailData->field1 > 2048 && $detailData->field1 <= 3072) {
                        $arrayTemp['level'] = 2;
                    } else if ($detailData->field3 > 3072) {
                        $arrayTemp['level'] = 3;
                    }
                    $arrayTemp['created_at'] = $detailData->created_at;
                    array_push($array, $arrayTemp);
                } else {
                    $arrayTemp['ews_id'] = $item->id;
                    if ($detailData->field1 == 1) {
                        $arrayTemp['level'] = 0;
                    } else if ($detailData->field1 == 0) {
                        $arrayTemp['level'] = 1;
                    } else if ($detailData->field2 == 0) {
                        $arrayTemp['level'] = 2;
                    } else if ($detailData->field3 == 0) {
                        $arrayTemp['level'] = 3;
                    }
                    $arrayTemp['created_at'] = $detailData->created_at;
                    array_push($array, $arrayTemp);
                }
            } else {
                if (property_exists($detailData, 'field2') == false) {
                    if($detailData->created_at != $flood->created_at) {
                        $arrayTemp['ews_id'] = $item->id;
                        if ($detailData->field1 <= 1024) {
                            $arrayTemp['level'] = 0;
                        } else if ($detailData->field1 > 1024 && $detailData->field1 <= 2048) {
                            $arrayTemp['level'] = 1;
                        } else if ($detailData->field1 > 2048 && $detailData->field1 <= 3072) {
                            $arrayTemp['level'] = 2;
                        } else if ($detailData->field3 > 3072) {
                            $arrayTemp['level'] = 3;
                        }
                        $arrayTemp['created_at'] = $detailData->created_at;
                        array_push($array, $arrayTemp);
                    }
                    dd('Data sudah ada');
                } else {
                    if ($detailData->created_at != $flood->created_at) {
                        $arrayTemp['ews_id'] = $item->id;
                        if ($detailData->field1 == 1) {
                            $arrayTemp['level'] = 0;
                        } else if ($detailData->field1 == 0) {
                            $arrayTemp['level'] = 1;
                        } else if ($detailData->field2 == 0) {
                            $arrayTemp['level'] = 2;
                        } else if ($detailData->field3 == 0) {
                            $arrayTemp['level'] = 3;
                        }
                        $arrayTemp['created_at'] = $detailData->created_at;
                        array_push($array, $arrayTemp);
                    }
                    dd('Data sudah ada');
                }
            }
        }
        // dd($array);
        Flood::insert($array);
        dd('Berhasil menambahkan data baru');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Flood  $flood
     * @return \Illuminate\Http\Response
     */
    public function show(Flood $flood)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Flood  $flood
     * @return \Illuminate\Http\Response
     */
    public function edit(Flood $flood)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFloodRequest  $request
     * @param  \App\Models\Flood  $flood
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFloodRequest $request, Flood $flood)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Flood  $flood
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flood $flood)
    {
        //
    }
}