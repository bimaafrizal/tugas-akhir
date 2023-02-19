<?php

namespace App\Http\Controllers;

use App\Models\KategoryArticle;
use App\Http\Requests\StoreKategoryArticleRequest;
use App\Http\Requests\UpdateKategoryArticleRequest;

class KategoryArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.dashboard.kategory-article.index');
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
     * @param  \App\Http\Requests\StoreKategoryArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKategoryArticleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KategoryArticle  $kategoryArticle
     * @return \Illuminate\Http\Response
     */
    public function show(KategoryArticle $kategoryArticle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KategoryArticle  $kategoryArticle
     * @return \Illuminate\Http\Response
     */
    public function edit(KategoryArticle $kategoryArticle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKategoryArticleRequest  $request
     * @param  \App\Models\KategoryArticle  $kategoryArticle
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKategoryArticleRequest $request, KategoryArticle $kategoryArticle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KategoryArticle  $kategoryArticle
     * @return \Illuminate\Http\Response
     */
    public function destroy(KategoryArticle $kategoryArticle)
    {
        //
    }
}
