<?php

namespace App\Services;

use App\Models\SoDevice;

class SoDeviceService extends BaseService
{
  public function __construct(SoDevice $service)
  {
    $this->model = $service;
  }
}
