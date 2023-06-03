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
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Support\Facades\Validator;

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
        $articles = Article::with('user', 'kategory')->where('is_active', 1)->paginate(3);

        if (request('search')) {
            $articles = Article::with('user', 'kategory')->join('users', 'articles.user_id', '=', 'users.id')->join('kategory_articles', 'articles.user_id', '=', 'kategory_articles.id')->where('is_active', 1)
                ->where('articles.title', 'like', '%' . request('search') . '%')->orWhere('kategory_articles.name', 'like', '%' . request('search') . '%')->orWhere('users.name', 'like', '%' . request('search') . '%')->paginate(3);
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
        $checkValidator = Validator::make($request->all(), [
            'body' => ['required', 'min:5', 'max:255'],
        ]);

        if ($checkValidator->fails()) {
            Alert::error('Error', $checkValidator->errors()->getMessageBag()->all()[0]);
            return back()->withInput();
        }

        $data = [];
        $data = $request->body;
        $article = Article::where('slug', $slug)->first();
        $data['user_id'] = Auth::user()->id;
        $data['article_id'] = $article->id;
        Comment::create($data);

        Alert::success('Success', 'Berhasil menambahkan komentar');
        return redirect()->back();
    }

    public function comenntNastedStore(Request $request, $slug, $id)
    {
        $checkValidator = Validator::make($request->all(), [
            'content' => ['required', 'min:5', 'max:255'],
        ]);

        if ($checkValidator->fails()) {
            Alert::error('Error', $checkValidator->errors()->getMessageBag()->all()[0]);
            return back();
        }
        $article = Article::where('slug', $slug)->first();

        $data['body'] = $request->content;
        $data['user_id'] = Auth::user()->id;
        $data['article_id'] = $article->id;
        $data['comment_article_id'] = $id;
        Comment::create($data);

        Alert::success('Success', 'Berhasil menambahkan komentar');
        return redirect()->back();
    }
}