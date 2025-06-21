<?php

namespace App\Traits;

use App\Models\Tenant;
use App\Models\Scopes\TenantScope;

trait TenantableTrait
{
    protected static function bootTenantableTrait()
    {
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

    /**
     * Get the searchable fields for the model.
     *
     * @return array
     */
    public function searchable(): array
    {
        return $this->searchable ?? [];
    }

    // Novo: método estático para obter searchable sem precisar de instância
    public static function getSearchable(): array
    {
        return (new static())->searchable();
    }
}
