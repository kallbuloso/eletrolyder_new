<?php

namespace App\Services;

use App\Models\Supplier;

class SupplierService extends BaseService
{
  public function __construct(Supplier $service)
  {
    $this->model = $service;
  }
}
