<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Collaboration;
use App\Models\Comment;
use App\Models\Feature;
use App\Models\LandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

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
        $articles = Article::with('user', 'kategory')->where('is_active', 1)->get();
        
        dd($articles);
        if (request('search')) {
            $articles = Article::where('is_active', 1)->paginate(2);
        }
        return view('pages.landing-page.blog', compact('page', 'articles'));
    }

    public function blogSingle($slug)
    {
        $page = LandingPage::where('id', 1)->first();
        $article = Article::where('slug', $slug)->first();
        $comments = Comment::where('article_id', $article->id)->whereNull('comment_article_id')->get();
        $countComment = Comment::where('article_id', $article->id)->count();

        return view('pages.landing-page.blog-single', compact('page', 'article', 'comments', 'countComment'));
    }


    public function comenntStore(Request $request, $slug)
    {
        $data = $request->validate(['body' => 'required|min:5']);
        $article = Article::where('slug', $slug)->first();
        $data['user_id'] = Auth::user()->id;
        $data['article_id'] = $article->id;
        Comment::create($data);

        // Alert::success('Success Title', 'Success Message');
        alert()->success('Title', 'Lorem Lorem Lorem');
        return redirect()->back();
    }

    public function comenntNastedStore(Request $request, $slug, $id)
    {
        // dd($id);
        $request->validate(['content' => 'required|min:5']);
        $article = Article::where('slug', $slug)->first();

        $data['body'] = $request->content;
        $data['user_id'] = Auth::user()->id;
        $data['article_id'] = $article->id;
        $data['comment_article_id'] = $id;
        Comment::create($data);
        return redirect()->back();
    }
}