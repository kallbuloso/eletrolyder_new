<?php

namespace App\Services;

use App\Models\SoStatusStep;

class SoStatusStepService extends BaseService
{
  public function __construct(SoStatusStep $service)
  {
    $this->model = $service;
  }
}
