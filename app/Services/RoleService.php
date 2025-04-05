<?php

namespace App\Services;

use App\Models\Role;

class RoleService extends BaseService
{
  public function __construct(Role $service)
  {
    $this->model = $service;
  }
}
