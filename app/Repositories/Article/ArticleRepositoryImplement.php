<?php

namespace App\Repositories\Article;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Article;

class ArticleRepositoryImplement extends Eloquent implements ArticleRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model::all();
    }
    public function allArticle($id)
    {
        return $this->model::where('user_id', $id)->get();
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function updateData($data, $id)
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function editStatus($slug, $data)
    {
        return $this->model->where('slug', $slug)->update([
            'is_active' => $data
        ]);
    }
}
