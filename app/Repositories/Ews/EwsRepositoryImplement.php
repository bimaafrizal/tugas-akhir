<?php

namespace App\Repositories\Ews;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Ews;

class EwsRepositoryImplement extends Eloquent implements EwsRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Ews $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)

    public function all()
    {
        return $this->model->all();
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function updateData($data, $id)
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function editStatus($id, $data)
    {
        return $this->model->where('id', $id)->update([
            'status' => $data
        ]);
    }
}
