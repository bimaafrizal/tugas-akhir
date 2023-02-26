<?php

namespace App\Services\Article;

use LaravelEasyRepository\Service;
use App\Repositories\Article\ArticleRepository;

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

  public function storeArticle($data, $request)
  {
    $data['is_active'] = 1;
    $foto = $request->file('cover');
    $name = $foto->hashName();
    $data['cover'] = 'berita/cover/' . $name;
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

    return $this->mainRepository->updateData($dataValidate, $oldData->id);
  }

  public function updateStatusArticle($slug, $data)
  {
    return $this->mainRepository->editStatus($slug, $data);
  }
}
