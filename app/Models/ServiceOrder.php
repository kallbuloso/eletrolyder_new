<?php

namespace App\Models;

use App\Traits\ServiceOrderTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ServiceOrder
 *
 * @property $id
 * @property $order_number
 * @property $tenant_id
 * @property $client_id
 * @property $so_device_id
 * @property $so_status_id
 * @property $so_status_steps_id
 * @property $warranty_expires_on
 * @property $labor_cost
 * @property $parts_cost
 * @property $service_cost
 * @property $discount
 * @property $advance_payment
 * @property $in_use
 * @property $currently_editing
 * @property $initially_attended_by
 * @property $abandonment_alert
 * @property $quoted_by_technician
 * @property $repaired_by_technician
 * @property $internal_notes
 * @property $closed_at
 * @property $reopened_at
 * @property $created_at
 * @property $updated_at
 * @property SoStatusStep $soStatusStep
 * @property SoStatus $soStatus
 * @property SoDevice $soDevice
 * @property Client $client
 * @property Tenant $tenant
 * @property ServiceOrderHistory[] $serviceOrderHistories
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ServiceOrder extends Model
{
    use ServiceOrderTrait;

    protected $table = 'service_orders';

    protected $perPage = 10;

    protected $guarded = ['id'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_number',
        'client_id',
        'so_device_id',
        'so_status_id',
        'so_status_steps_id',
        'warranty_expires_on',
        'labor_cost',
        'parts_cost',
        'service_cost',
        'discount',
        'advance_payment',
        'in_use',
        'currently_editing',
        'initially_attended_by',
        'abandonment_alert',
        'quoted_by_technician',
        'repaired_by_technician',
        'internal_notes',
        'closed_at',
        'reopened_at',
    ];

    protected $searchable = [
        'order_number',
    ];
}
