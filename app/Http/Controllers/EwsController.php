<?php

namespace App\Http\Controllers;

use App\Models\Ews;
use App\Http\Requests\StoreEwsRequest;
use App\Http\Requests\UpdateEwsRequest;
use App\Models\Flood;
use App\Services\Ews\EwsService;
use Illuminate\Http\Request;

class EwsController extends Controller
{
    protected $service;
    public function __construct(EwsService $ews)
    {
        $this->service = $ews;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = $this->service->all();
        return view('pages.dashboard2.ews.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard2.ews.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEwsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEwsRequest $request)
    {
        $this->service->create($request->all());
        return redirect(route('ews.index'))->with('success', 'Alat EWS berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ews  $ews
     * @return \Illuminate\Http\Response
     */
    public function show($ew)
    {
        $idDecrypt = decrypt($ew);
        $ews = Ews::where('id', $idDecrypt)->first();
        $flood = Flood::with('ews')->where('ews_id', $idDecrypt)->orderBy('id', 'desc')->get();
        // dd($flood);
        return view('pages.dashboard2.ews.detail', compact('ews', 'flood'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ews  $ews
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $decryptId = decrypt($id);
        $data = Ews::where('id', $decryptId)->first();
        return view('pages.dashboard2.ews.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEwsRequest  $request
     * @param  \App\Models\Ews  $ews
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEwsRequest $request, $id)
    {
        $decryptId = decrypt($id);
        // dd($request->all());
        $this->service->update($decryptId, $request->all());
        return redirect(route('ews.index'))->with('success', 'Alat EWS berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ews  $ews
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ews $ews)
    {
        //
    }

    public function editStatus($id, Request $request)
    {
        $decryptId = decrypt($id);

        $this->service->updateStatus($decryptId, $request->is_active);
        return redirect(route('ews.index'))->with('success', 'Status EWS berhasil dirubah');
    }

    public function getDetailData(Request $request)
    {
        // $decryptId = decrypt($request->id);
        // $floods = Flood::where('ews_id', $decryptId)->orderBy('id', 'desc')->take(30)->get();
        // $labels = ['0', '1', '2', '3'];
        // $data = $floods->pluck('level');

        // return response()->json(compact('labels', 'data'));
        echo $request->id;
    }
}