<?php

namespace App\Services;

use App\Models\SoStatus;

class SoStatusService extends BaseService
{
    public function __construct(SoStatus $service)
    {
        $this->model = $service;
    }
}
