<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\KategoryArticle;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all();
        return view('pages.dashboard.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategories = KategoryArticle::where('status', 1)->get();
        return view('pages.dashboard.article.create', compact('kategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required|min:3|max:255',
            'slug' => 'required',
            'kategory_article_id' => 'required',
            'body' =>  'required|min:10',
            'cover' => 'required|file|image|mimes:jpg,jpeg,png|max:50000'
        ]);

        $validateData['is_active'] = 1;
        $foto = $request->file('cover');
        $name = $foto->hashName();
        $validateData['cover'] = 'berita/cover/' . $name;
        $foto->move(public_path('/berita/cover'), $name);

        Article::create($validateData);
        return redirect(route('article.index'));
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
        return view('pages.dashboard.article.edit', [
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
    public function update(Request $request, Article $slug)
    {
        $oldCover = $slug->cover;
        $validateData = $request->validate([
            'title' => 'required|min:3|max:255',
            'slug' => 'required',
            'kategory_article_id' => 'required',
            'body' =>  'required|min:10',
            'cover' => 'required|file|image|mimes:jpg,jpeg,png|max:50000'
        ]);

        if ($request->cover != null) {
            if ($oldCover != null) {
                if (file_exists($oldCover)) {
                    unlink(public_path($oldCover));
                }
            }
            $foto = $request->file('cover');
            $name = $foto->hashName();
            $validateData['cover'] = 'berita/cover/' . $name;
            $foto->move(public_path('/berita/cover'), $name);
        }
        $slug->update($validateData);
        return redirect(route('article.index'));
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
        Article::where('slug', $slug)->update([
            'is_active' => $request->is_active
        ]);
        return redirect(route('article.index'));
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Article::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }

    public function uploadImage(Request $request)
    {
        $image = $request->file('upload');

        $imageName = time() . '.' . $image->extension();
        $path = $request->file('upload')->storeAs('public/berita', $imageName);
        $url = Storage::url($path);

        return response()->json([
            'url' => $url
        ]);
        // if ($request->hasFile('upload')) {
        //     $mimeType = $request->file('upload')->getMimeType();
        //     $allowedMimeTypes = ['image/jpeg', 'image/png'];
        //     if (!in_array($mimeType, $allowedMimeTypes)) {
        //         return response()->json(['uploaded' => 0, 'error' => 'File yang diupload harus berupa gambar dengan format JPEG atau PNG.']);
        //     }
        //     $size = $request->file('upload')->getSize();
        //     $maxSize = 5242880; // 5 MB
        //     if ($size > $maxSize) {
        //         return response()->json(['uploaded' => 0, 'error' => 'Ukuran file yang diupload tidak boleh lebih dari 5 MB.']);
        //     }
        //     $originName = $request->file('upload')->getClientOriginalName();
        //     $fileName = pathinfo($originName, PATHINFO_FILENAME);
        //     $extension = $request->file('upload')->getClientOriginalExtension();
        //     $fileName = $fileName . '_' . time() . '.' . $extension;

        //     $request->file('upload')->move(public_path('berita'), $fileName);

        //     $url = asset('berita/' . $fileName);
        //     return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        // }
        // return response()->json(['uploaded' => 0, 'error' => 'Tidak ada file yang diupload.']);

        // if ($request->hasFile('file')) {
        //     //get filename with extension
        //     $filenamewithextension = $request->file('file')->getClientOriginalName();

        //     //get filename without extension
        //     $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

        //     //get file extension
        //     $extension = $request->file('file')->getClientOriginalExtension();

        //     //filename to store
        //     $filenametostore = $filename . '_' . time() . '.' . $extension;

        //     //Upload File
        //     $request->file('file')->move(public_path('public/article'), $filenametostore);

        //     // you can save image path below in database
        //     $path = asset('public/article/' . $filenametostore);

        //     echo $path;
        //     exit;
        // }
    }
}
