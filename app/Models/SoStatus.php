<?php

namespace App\Models;

use App\Traits\SoStatusTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SoStatus
 *
 * @property $id
 * @property $tenant_id
 * @property $name
 * @property $status_type
 * @property $generates_revenue
 *
 * @property Tenant $tenant
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class SoStatus extends Model
{
    use SoStatusTrait;

    protected $table = "so_statuses";

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
        'status_type',
        'generates_revenue'
    ];

    protected $searchable = [
        'description'
    ];
}
