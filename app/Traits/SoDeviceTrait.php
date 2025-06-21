<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory;

trait SoDeviceTrait
{
    use HasFactory, TenantebleTrait, DatesModelTraits;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function soDevicesType()
    {
        return $this->belongsTo(\App\Models\SoDevicesType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function serviceOrders()
    {
        return $this->hasMany(\App\Models\ServiceOrder::class, 'id', 'so_device_id');
    }
}
