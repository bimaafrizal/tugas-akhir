<?php

namespace App\Http\Controllers;

use App\Models\Collaboration;
use App\Http\Requests\StoreCollaborationRequest;
use App\Http\Requests\UpdateCollaborationRequest;

class CollaborationController extends Controller
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
     * @param  \App\Http\Requests\StoreCollaborationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCollaborationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Collaboration  $collaboration
     * @return \Illuminate\Http\Response
     */
    public function show(Collaboration $collaboration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Collaboration  $collaboration
     * @return \Illuminate\Http\Response
     */
    public function edit(Collaboration $collaboration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCollaborationRequest  $request
     * @param  \App\Models\Collaboration  $collaboration
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCollaborationRequest $request, Collaboration $collaboration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Collaboration  $collaboration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collaboration $collaboration)
    {
        //
    }
}
