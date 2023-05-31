<?php

namespace App\Http\Controllers;

use App\Models\SettingDisaster;
use App\Http\Requests\StoreSettingDisasterRequest;
use App\Http\Requests\UpdateSettingDisasterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingDisasterController extends Controller
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
     * @param  \App\Http\Requests\StoreSettingDisasterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($data)
    {
        $auth = Auth::user();
        SettingDisaster::create([
            'user_id' => $auth->id,
            'disaster_id' => $data,
        ]);
        echo 'data berhasil ditambahkan';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SettingDisaster  $settingDisaster
     * @return \Illuminate\Http\Response
     */
    public function show(SettingDisaster $settingDisaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SettingDisaster  $settingDisaster
     * @return \Illuminate\Http\Response
     */
    public function edit(SettingDisaster $settingDisaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSettingDisasterRequest  $request
     * @param  \App\Models\SettingDisaster  $settingDisaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $auth = Auth::user();

        $setting = SettingDisaster::where('user_id', $auth->id)->where('disaster_id', $id)->first();
        if ($setting == null) {
            $this->store($id);
        } else {
            $status = '0';
            if ($setting->status == $status) {
                $status = '1';
            }
            $setting->update([
                'status' => $status
            ]);
            echo 'berhasil merubah data';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SettingDisaster  $settingDisaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(SettingDisaster $settingDisaster)
    {
        //
    }
}