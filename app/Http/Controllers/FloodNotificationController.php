<?php

namespace App\Http\Controllers;

use App\Models\FloodNotification;
use App\Http\Requests\StoreFloodNotificationRequest;
use App\Http\Requests\UpdateFloodNotificationRequest;

class FloodNotificationController extends Controller
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
     * @param  \App\Http\Requests\StoreFloodNotificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFloodNotificationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FloodNotification  $floodNotification
     * @return \Illuminate\Http\Response
     */
    public function show(FloodNotification $floodNotification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FloodNotification  $floodNotification
     * @return \Illuminate\Http\Response
     */
    public function edit(FloodNotification $floodNotification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFloodNotificationRequest  $request
     * @param  \App\Models\FloodNotification  $floodNotification
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFloodNotificationRequest $request, FloodNotification $floodNotification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FloodNotification  $floodNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy(FloodNotification $floodNotification)
    {
        //
    }
}
