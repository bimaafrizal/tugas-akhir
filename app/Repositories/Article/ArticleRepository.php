<?php

namespace App\Repositories\Article;

use LaravelEasyRepository\Repository;

interface ArticleRepository extends Repository
{
    public function getAll();
    public function allArticle($id);
    public function store($data);
    public function updateData($data, $id);
    public function editStatus($slug, $data);
}
