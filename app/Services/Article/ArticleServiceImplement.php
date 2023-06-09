<?php

namespace App\Services\Article;

use LaravelEasyRepository\Service;
use App\Repositories\Article\ArticleRepository;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class ArticleServiceImplement extends Service implements ArticleService
{

  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  protected $mainRepository;

  public function __construct(ArticleRepository $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  // Define your custom methods :)

  public function all()
  {
    return $this->mainRepository->getAll();
  }
  public function allArticle($session)
  {
    if ($session->role_id == 2) {
      return $this->mainRepository->allArticle($session->id);
    }
    return $this->mainRepository->getAll();
  }

  public function storeArticle($data, $request, $id)
  {
    //upload image
    $dom = new \DomDocument();
    $dom->loadHtml($request->body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $image_file = $dom->getElementsByTagName('img');

    if (!File::exists(public_path('berita'))) {
      File::makeDirectory(public_path('berita'));
    }
    foreach ($image_file as $key => $image) {
      $data2 = $image->getAttribute('src');

      list($type, $data2) = explode(';', $data2);
      list(, $data2) = explode(',', $data2);

      $img_data = base64_decode($data2);
      $image_name = "/berita/" . time() . $key . '.png';
      $path = public_path() . $image_name;
      file_put_contents($path, $img_data);

      $image->removeAttribute('src');
      $image->setAttribute('src', $image_name);
    }

    $data['is_active'] = 1;
    $foto = $request->file('cover');
    $name = $foto->hashName();
    $data['cover'] = 'berita/cover/' . $name;
    $data['user_id'] = $id;
    $data['body'] = $dom->saveHTML();
    $foto->move(public_path('/berita/cover'), $name);

    return $this->mainRepository->store($data);
  }

  public function updateArticle($data, $request, $oldData)
  {
    $dataValidate = [
      'title' => $data['title'],
      'slug' => $data['slug'],
      'kategory_article_id' => $data['kategory_article_id'],
      'body' => $data['body']
    ];
    $oldCover = $oldData->cover;
    $dataValidate['cover'] = $oldCover;
    // dd($oldData->body);

    if ($request->cover != null) {
      if ($oldCover != null) {
        if (file_exists($oldCover)) {
          unlink(public_path($oldCover));
        }
      }
      $foto = $request->file('cover');
      $name = $foto->hashName();
      $dataValidate['cover'] = 'berita/cover/' . $name;
      $foto->move(public_path('/berita/cover'), $name);
    }

    $storage = "berita/";
    $dom = new \DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($request->body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NOIMPLIED);
    libxml_clear_errors();
    $images = $dom->getElementsByTagName('img');
    foreach ($images as $img) {
      $src = $img->getAttribute('src');
      if (preg_match('/data:image/', $src)) {
        preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
        $mimetype = $groups['mime'];
        $fileNameContent = uniqid();
        $fileNameContentRand = substr(md5($fileNameContent), 6, 6) . '_' . time();
        $filepath = ("$storage/$fileNameContentRand.$mimetype");
        $image = Image::make($src)
          ->encode($mimetype, 100)
          ->save(public_path($filepath));
        $new_src = asset($filepath);
        $img->removeAttribute('src');
        $img->setAttribute('src', $new_src);
        $img->setAttribute('class', 'img-responsive');
      }
    }

    $dataValidate['body'] = $dom->saveHTML();

    return $this->mainRepository->updateData($dataValidate, $oldData->id);
  }

  public function updateStatusArticle($slug, $data)
  {
    return $this->mainRepository->editStatus($slug, $data);
  }
}
