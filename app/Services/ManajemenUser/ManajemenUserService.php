<?php

namespace App\Services\ManajemenUser;

use LaravelEasyRepository\BaseService;

interface ManajemenUserService extends BaseService{

    // Write something awesome :)
    public function updateStatus($id, $data);
}