<?php

namespace App\Traits;

use App\Models\Tenant;
use App\Models\Scopes\TenantScope;

trait TenantebleTrait
{
  protected static function boot()
  {
    parent::boot();
    static::addGlobalScope(new TenantScope);
    static::creating(function ($model) {
      if (checkTenantId()) {
        $model->tenant_id = session('tenant_id');
      }
    });
  }

  public function tenant()
  {
    return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
  }
}
