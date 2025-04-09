<?php

namespace App\Services;

use App\Models\Client;

class ClientService extends BaseService
{
  public function __construct(Client $service)
  {
    $this->model = $service;
  }
}
