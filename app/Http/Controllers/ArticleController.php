<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\KategoryArticle;
use App\Services\Article\ArticleServiceImplement;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    protected $service;
    public function __construct(ArticleServiceImplement $article)
    {
        $this->service = $article;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = $this->service->all();
        return view('pages.dashboard2.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategories = KategoryArticle::where('status', 1)->get();
        return view('pages.dashboard2.article.create', compact('kategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $userId = Auth::user()->id;

        $this->service->storeArticle($request->all(), $request, $userId);
        return redirect(route('article.index'))->with('success', 'Berhasil menambahkan article');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $slug)
    {
        $kategories = KategoryArticle::where('status', 1)->get();
        return view('pages.dashboard2.article.edit', [
            'article' => $slug,
            'kategories' => $kategories
        ]);;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $slug)
    {
        $this->service->updateArticle($request->all(), $request, $slug);
        return redirect(route('article.index'))->with('success', 'Berhasil merubah article');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }

    public function editStatus($slug, Request $request)
    {
        $this->service->updateStatusArticle($slug, $request->is_active);
        return redirect(route('article.index'))->with('success', 'Berhasil Merubah Status');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Article::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }
}