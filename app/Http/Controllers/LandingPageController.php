<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Collaboration;
use App\Models\Feature;
use App\Models\LandingPage;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $page = LandingPage::where('id', 1)->first();
        $collabs = Collaboration::all();
        $fiturs = Feature::all();
        return view('pages.landing-page.home', compact('page', 'collabs', 'fiturs'));
    }

    public function blog()
    {
        $page = LandingPage::where('id', 1)->first();
        $articles = Article::where('is_active', 1)->get();
        return view('pages.landing-page.blog', compact('page', 'articles'));
    }

    public function blogSingle()
    {
        $page = LandingPage::where('id', 1)->first();
        return view('pages.landing-page.blog-single', compact('page'));
    }
}