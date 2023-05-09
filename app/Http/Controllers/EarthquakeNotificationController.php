<?php

namespace App\Http\Controllers;

use App\Models\EarthquakeNotification;
use App\Http\Requests\StoreEarthquakeNotificationRequest;
use App\Http\Requests\UpdateEarthquakeNotificationRequest;

class EarthquakeNotificationController extends Controller
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
     * @param  \App\Http\Requests\StoreEarthquakeNotificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEarthquakeNotificationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EarthquakeNotification  $earthquakeNotification
     * @return \Illuminate\Http\Response
     */
    public function show(EarthquakeNotification $earthquakeNotification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EarthquakeNotification  $earthquakeNotification
     * @return \Illuminate\Http\Response
     */
    public function edit(EarthquakeNotification $earthquakeNotification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEarthquakeNotificationRequest  $request
     * @param  \App\Models\EarthquakeNotification  $earthquakeNotification
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEarthquakeNotificationRequest $request, EarthquakeNotification $earthquakeNotification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EarthquakeNotification  $earthquakeNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy(EarthquakeNotification $earthquakeNotification)
    {
        //
    }
}
