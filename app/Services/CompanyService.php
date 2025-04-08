<?php

namespace App\Services;

use App\Models\Company;

class CompanyService extends BaseService
{
  public function __construct(Company $service)
  {
    $this->model = $service;
  }
}
