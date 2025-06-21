<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory;

trait SoDevicesTypeTrait
{
    use HasFactory, TenantableTrait, DatesModelTraits;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function soDevices()
    {
        return $this->hasMany(\App\Models\SoDevice::class, 'id', 'so_device_type_id');
    }
}
