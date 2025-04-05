<?php

namespace App\Services;

use App\Models\Address;

class AddressService extends BaseService
{
  public function __construct(Address $service)
  {
    $this->model = $service;
  }
}
