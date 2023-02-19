<?php

namespace App\Service\KategoryArticle;

use App\Http\Requests\StoreKategoryArticleRequest;
use App\Repositories\KategoryArticle\KategoryArticleRepository;

class KategoryArticleService
{

    protected $repo;
    public function __construct()
    {
        $this->repo = new KategoryArticleRepository;
    }

    public function all()
    {
        return $this->repo->getAllData();
    }

    public function insert($data)
    {
        return $this->repo->storeCategory($data);
    }
}
