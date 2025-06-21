<?php

namespace App\Services;

use App\Models\ServiceOrder;

class ServiceOrderService extends BaseService
{
  public function __construct(ServiceOrder $service)
  {
    $this->model = $service;
  }
}
