<?php

namespace App\Http\Controllers;

use App\Models\Disaster;
use App\Http\Requests\StoreDisasterRequest;
use App\Http\Requests\UpdateDisasterRequest;
use Illuminate\Http\Request;

class DisasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Disaster::all();
        return view('pages.dashboard2.disaster.index', compact('datas'));
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
     * @param  \App\Http\Requests\StoreDisasterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDisasterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Disaster  $disaster
     * @return \Illuminate\Http\Response
     */
    public function show(Disaster $disaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Disaster  $disaster
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $decryptId = decrypt($id);
        $data = Disaster::where('id', $decryptId)->first();
        return view('pages.dashboard2.disaster.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDisasterRequest  $request
     * @param  \App\Models\Disaster  $disaster
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $decryptId = decrypt($id);
        if ($decryptId == 1) {
            $validateData = $request->validate([
                'distance' => 'required|integer',
            ]);
        } else {
            $validateData = $request->validate([
                'distance' => 'required|integer',
                'strength' => 'required|integer',
                'depth' => 'required|integer',
            ]);
        }
        $data = Disaster::where('id', $decryptId)->first();
        $data->update($validateData);
        return redirect(route('disaster.index'))->with('success', 'Berhasil merubah setting bencana');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disaster  $disaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disaster $disaster)
    {
        //
    }
}
