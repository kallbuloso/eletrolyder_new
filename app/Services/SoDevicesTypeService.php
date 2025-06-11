<?php

namespace App\Services;

use App\Models\SoDevicesType;

class SoDevicesTypeService extends BaseService
{
  public function __construct(SoDevicesType $service)
  {
    $this->model = $service;
  }
}
