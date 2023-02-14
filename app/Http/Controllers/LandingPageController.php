<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        return view('pages.landing-page.home');
    }

    public function blog()
    {
        return view('pages.landing-page.blog');
    }

    public function blogSingle()
    {
        return view('pages.landing-page.blog-single');
    }
}
