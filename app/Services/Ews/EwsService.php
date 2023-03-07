<?php

namespace App\Services\Ews;

use LaravelEasyRepository\BaseService;

interface EwsService extends BaseService
{

    // Write something awesome :)
    public function updateStatus($id, $data);
}
