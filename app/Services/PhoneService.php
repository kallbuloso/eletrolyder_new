<?php

namespace App\Services;

use App\Models\Phone;

class PhoneService extends BaseService
{
    public function __construct(Phone $service)
    {
        $this->model = $service;
    }
}
