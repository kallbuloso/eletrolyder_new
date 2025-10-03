<?php

namespace App\Models;

use App\Traits\SoDeviceTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SoDevice
 *
 * @property $id
 * @property $tenant_id
 * @property $so_device_type_id
 * @property $description
 * @property $brand
 * @property $model
 * @property $serial_number
 * @property $damages
 * @property $accessories
 * @property $notes
 * @property $warranty_provider
 * @property $purchase_date
 * @property $reseller
 * @property $invoice_number
 * @property $warranty_certificate
 * @property $created_at
 * @property $updated_at
 * @property SoDevicesType $soDevicesType
 * @property Tenant $tenant
 * @property Main.serviceOrder[] $main.serviceOrders
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class SoDevice extends Model
{
    use SoDeviceTrait;

    protected $table = 'so_devices';

    protected $perPage = 10;

    protected $guarded = ['id'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tenant_id',
        'so_device_type_id',
        'description',
        'brand',
        'model',
        'serial_number',
        'damages',
        'accessories',
        'notes',
        'warranty_provider',
        'purchase_date',
        'reseller',
        'invoice_number',
        'warranty_certificate',
    ];

    protected $searchable = [
        'brand',
        'model',
    ];
}
