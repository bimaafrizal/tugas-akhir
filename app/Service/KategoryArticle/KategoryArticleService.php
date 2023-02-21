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

    public function getAllStatus()
    {
        $datas =  $this->repo->getAllData();
        $array = [];
        foreach ($datas as $data) {
            $array[$data->id] = $data->status;
        }

        return $array;
    }

    public function updateStatus($id, $status)
    {
        $newStatus = 1;
        if ($status == 1) {
            $newStatus = 0;
        }
        return $this->repo->editStatus($id, $newStatus);
    }

    public function update($id, $data)
    {
        return $this->repo->update($id, $data);
    }
}
