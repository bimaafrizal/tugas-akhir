<?php

namespace App\Repositories\KategoryArticle;

use App\Models\KategoryArticle;
use LaravelEasyRepository\Repository;
use Exception;
use Illuminate\Support\Facades\Log;

class KategoryArticleRepository
{

    // Write something awesome :)
    protected $model;

    public function __construct()
    {
        $this->model = new KategoryArticle();
    }

    public function getAllData()
    {
        try {
            return $this->model->all();
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
            return [];
        }
    }

    public function storeCategory($data)
    {
        return KategoryArticle::create($data);
    }

    public function editStatus($id, $status)
    {
        return KategoryArticle::where('id', $id)->update([
            'status' => $status
        ]);
    }

    public function update($id, $data)
    {
        return $this->model->where('id', $id)->update($data);
    }
}