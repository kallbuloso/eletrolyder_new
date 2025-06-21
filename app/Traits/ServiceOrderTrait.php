<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory;

trait ServiceOrderTrait
{
    use HasFactory, TenantableTrait, DatesModelTraits;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function soStatusStep()
    {
        return $this->belongsTo(\App\Models\SoStatusStep::class, 'so_status_steps_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function soStatus()
    {
        return $this->belongsTo(\App\Models\SoStatus::class, 'so_status_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function soDevice()
    {
        return $this->belongsTo(\App\Models\SoDevice::class, 'so_device_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function serviceOrderHistories()
    // {
    //     return $this->hasMany(\App\Models\ServiceOrderHistory::class, 'id', 'order_id');
    // }
}
