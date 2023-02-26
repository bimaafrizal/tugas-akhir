<?php

namespace App\Services\Article;

use LaravelEasyRepository\BaseService;

interface ArticleService extends BaseService
{

    // Write something awesome :)
    public function storeArticle($data, $request);
    public function updateArticle($data, $request, $oldData);
    public function updateStatusArticle($slug, $data);
}
