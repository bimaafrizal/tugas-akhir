<?php

namespace App\Repositories\ManajemenUser;

use LaravelEasyRepository\Repository;

interface ManajemenUserRepository extends Repository
{
    public function store($data);
    public function updateData($data, $id);
    public function editStatus($id, $data);
}
