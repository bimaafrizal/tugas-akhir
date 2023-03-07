<?php

namespace App\Repositories\Ews;

use LaravelEasyRepository\Repository;

interface EwsRepository extends Repository
{
    // Write something awesome :)
    public function all();
    public function store($data);
    public function updateData($data, $id);
    public function editStatus($id, $data);
}
