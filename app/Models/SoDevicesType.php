<?php

namespace App\Models;

use App\Traits\SoDevicesTypeTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SoDevicesType
 *
 * @property $id
 * @property $tenant_id
 * @property $description
 * @property $created_at
 * @property $updated_at
 * @property Tenant $tenant
 * @property Main.soDevice[] $main.soDevices
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class SoDevicesType extends Model
{
    use SoDevicesTypeTrait;

    protected $table = 'so_devices_type';

    protected $perPage = 10;

    protected $guarded = ['id'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tenant_id',
        'description',
        'is_active',
    ];

    protected $searchable = [
        'description',
    ];
}
